<?php

namespace App\Http\Controllers;

// use App\Models\Penghulu;
use App\Models\BusyHour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PenghuluController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $penghulu = User::where('role', 'penghulu') // Filter hanya role ponghulu
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('Penghulu.index', compact('penghulu', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penghulu.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => 'required|string|max:255',
            "email" => 'required|email:dns|max:255|unique:users,email',
            // "password" => 'required|string|min:8|max:16'
        ]);

        $validatedData['password'] = Hash::make('12345678');
        $validatedData['role'] = 'penghulu';

        // if ($request->file('pp')) {
        //     $request->validate([
        //         "pp" => 'image|file|max:2048',
        //     ]);
        //     $validatedData['pp'] = $request->file('pp')->store('pp', 'public');
        // }
        // dd($validatedData);

        User::create($validatedData);
        return redirect('/penghulu')->with('success', 'Berhasil menambah data penghulu');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Penghulu $penghulu)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // dd($user);
        $user = User::findOrFail($id);
        return view('penghulu.edit', [
            'penghulu' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "name" => 'required|string|max:255',
            "email" => 'required|email:dns|max:255|unique:users,email,' . $id,
        ]);
        if ($request->has('isChangePassword')) {
            $passwordData = $request->validate([
                "password" => 'required|string|min:8|max:16|confirmed'
            ]);
            $validatedData['password'] = $passwordData['password'];
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        // dd($validatedData);


        $user = User::findOrFail($id);

        $user->update($validatedData);
        return redirect('/penghulu')->with('success', 'Berhasil merubah data penghulu');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);

    //     if ($user->profile_picture && Storage::exists($user->profile_picture)) {
    //         Storage::delete($user->profile_picture);
    //     }
    //     $user->delete();
    //     return redirect('/penghulu')->with('success', 'Berhasil menghapus data penghulu');
    //     //
    // }
    public function penghuluSchedule(Request $request)
    {

        $tanggal = $request->get('tanggal', date('Y-m-d')); // ambil dari request atau default hari ini

        $busyHours = BusyHour::join('schedules', 'busy_hours.schedule_id', '=', 'schedules.id')
            ->where('busy_hours.user_id', auth()->id())
            ->whereDate('schedules.marriage_date', $tanggal)
            ->orderBy('schedules.marriage_date')
            ->orderBy('schedules.marriage_time') // sesuaikan nama kolom
            ->with('user', 'schedule')
            ->select('busy_hours.*')
            ->paginate(6);
        // dd('its here');

        return view('penghulu.penghulu-schedule', [
            'busyHours' => $busyHours
        ]);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'penghulu') {
            return back()->with('error', 'Hanya user penghulu yang bisa diubah statusnya di sini.');
        }

        if ($user->is_active) {
            $hasUpcoming = $user->schedule()
                ->where('marriage_date', '>=', now()->toDateString())
                ->exists();

            if ($hasUpcoming) {
                return back()->with('error', 'Penghulu tidak dapat dinonaktifkan karena memiliki jadwal aktif.');
            }
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Penghulu berhasil $status.");
    }
}
