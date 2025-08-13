<?php

namespace App\Http\Controllers;

use App\Mail\ScheduleNotification;
use App\Mail\ScheduleUpdatedMail;
use App\Models\Couple;
use App\Models\BusyHour;
use App\Models\Schedule;
use App\Models\Announcement;
use App\Models\SyncLog;
use App\Models\ThemeView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lastSync = SyncLog::where('type', 'announcement')->latest('synced_at')->first();

        $statuses = is_array($request->get('status')) ? $request->get('status') : [];

        // $statuses = $request->get('status', []); // Ambil status yang dipilih (array)
        $search = $request->get('search');

        $schedules = Schedule::with('couple')
            ->when($statuses, function ($query) use ($statuses) {
                $query->whereHas('couple', function ($q) use ($statuses) {
                    $q->whereIn('marriage_status', $statuses); // Filter berdasarkan status yang dipilih
                });
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('couple', function ($q) use ($search) {
                    $q->where(function ($subQuery) use ($search) {
                        $subQuery->where('groom_name', 'like', "%{$search}%")
                            ->orWhere('bride_name', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('marriage_date', 'asc') // Urut berdasarkan tanggal pernikahan
            ->orderBy('marriage_time', 'asc') // Urut berdasarkan waktu pernikahan
            ->paginate(10)->withQueryString();

        return view('Schedule.index', compact('schedules', 'statuses', 'lastSync'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schedule.add', [
            "couples" => Couple::registered()->orderBy('groom_name', 'asc')->get(), // gunakan scope registered(),
            "penghulu" => User::activePenghulu()->get(), // Pakai scope yang kamu buat
            "themeViews" => ThemeView::orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "couple_id" => "required",
            "user_id" => 'required',
            "guardian_name" => "required|string|max:255",
            "guardian_relationship" => "required|string|max:255",
            "guardian_father_name" => "required|string|max:255",
            "guardian_birth_date" => "required|string|max:255",
            "guardian_birth_place" => "required|string|max:255",
            "guardian_nationality" => "required|string|max:255",
            "guardian_occupation" => "required|string|max:255",
            "guardian_religion" => "required|string|max:255",
            "guardian_address" => "required|string|max:255",
            "marriage_date" => "required|string|max:255",
            "marriage_time" => "required|string|max:255",
            "marriage_venue" => "required|string|max:255",
            "theme_view_id" => 'required'
        ]);

        // merubah status pernikahan ditabel catin
        $couple = Couple::findOrFail($validatedData['couple_id']);
        $couple->marriage_status = "terjadwal";
        $couple->save();

        $schedule = Schedule::create($validatedData);

        Announcement::create([
            "schedule_id" => $schedule->id,
            "theme_view_id" => $validatedData['theme_view_id']
        ]);

        if ($couple) {
            Mail::to($couple->groom_email)->send(new ScheduleNotification($schedule));
            Mail::to($couple->bride_email)->send(new ScheduleNotification($schedule));
        }

        // mengisi data jadwal sibuk penghulu
        $penghulu = User::findOrFail($validatedData['user_id']);
        if ($penghulu) {
            BusyHour::create([
                'user_id' => $penghulu->id,
                'schedule_id' => $schedule->id,
                'date' => $validatedData['marriage_date'],
                'time' => $validatedData['marriage_time']
            ]);
        }

        return redirect('/schedule')->with('success', 'Berhasil menambah data jadwal');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        return view('schedule.edit', [
            "couple" => $schedule->couple,
            "penghulu" => User::activePenghulu()->get(), // Lebih efisien & rapi
            'schedule' => $schedule,
            "themeViews" => ThemeView::orderBy('name', 'asc')->get(),
            "announcement" => Announcement::where('schedule_id', $schedule->id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        // dd($request);

        $validatedData = $request->validate([
            "marriage_status" => "required|string",
            "user_id" => 'required',
            "guardian_name" => "required|string|max:255",
            "guardian_relationship" => "required|string|max:255",
            "guardian_father_name" => "required|string|max:255",
            "guardian_birth_date" => "required|string|max:255",
            "guardian_birth_place" => "required|string|max:255",
            "guardian_nationality" => "required|string|max:255",
            "guardian_occupation" => "required|string|max:255",
            "guardian_religion" => "required|string|max:255",
            "guardian_address" => "required|string|max:255",
            "marriage_date" => "required|string|max:255",
            "marriage_time" => "required|string|max:255",
            "marriage_venue" => "required|string|max:255",
            "theme_view_id" => "required"
        ]);

        // Cek apakah tanggal/waktu/tempat berubah
        $shouldNotify = (
            $schedule->marriage_date !== $validatedData['marriage_date'] ||
            $schedule->marriage_time !== $validatedData['marriage_time'] ||
            $schedule->marriage_venue !== $validatedData['marriage_venue'] ||
            $schedule->user_id != $validatedData['user_id']
        );

        // dd($validatedData);
        // Update status pernikahan catin
        $couple = Couple::findOrFail($schedule->couple->id);
        $couple->marriage_status = $validatedData['marriage_status'];
        $couple->save();

        $announcement = Announcement::where('schedule_id', $schedule->id)->first();

        if ($announcement) {
            $announcement->theme_view_id = $validatedData['theme_view_id'];
            $announcement->save();
        } else {
            // Kalau tidak ditemukan, buat data baru misalnya
            Announcement::create([
                'schedule_id' => $schedule->id,
                'theme_view_id' => $validatedData['theme_view_id'],
                // field lain jika ada
            ]);
        }


        // Hapus jam sibuk lama
        BusyHour::where('user_id', $schedule->user_id)
            ->where('schedule_id', $schedule->id)
            ->where('date', $schedule->marriage_date)
            ->where('time', $schedule->marriage_time)
            ->delete();

        // Tambahkan jam sibuk baru
        BusyHour::create([
            'user_id' => $validatedData['user_id'],
            'schedule_id' => $schedule->id,
            'date' => $validatedData['marriage_date'],
            'time' => $validatedData['marriage_time']
        ]);



        // Update schedule
        $schedule->update($validatedData);

        // Kirim email hanya jika tanggal/waktu/tempat berubah/penghulu
        if ($shouldNotify) {
            Mail::to($couple->groom_email)->send(new ScheduleUpdatedMail($schedule));
            Mail::to($couple->bride_email)->send(new ScheduleUpdatedMail($schedule));
        }

        return redirect('/schedule')->with('success', 'Berhasil mengupdate data jadwal');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $couple = Couple::findOrFail($schedule->couple->id);
        $couple->marriage_status = "terdaftar";
        $couple->save();

        $schedule->delete();

        return redirect('/schedule')->with('success', 'Berhasil menghapus data jadwal');
    }

    //berfungsi
    // public function penghuluAvailable(Request $request)
    // {
    //     $tanggal = $request->tanggal;
    //     $jam = $request->waktu;

    //     // Ambil user_id penghulu yang sibuk di tanggal dan jam tersebut
    //     $penghuluSibuk = JamSibuk::where('date', $tanggal)
    //         ->where('hour', $jam)
    //         ->pluck('user_id');

    //     // Ambil user yang role-nya penghulu DAN tidak sibuk
    //     $penghuluTersedia = User::where('role', 'penghulu')
    //         ->whereNotIn('id', $penghuluSibuk)
    //         ->get();

    //     return response()->json($penghuluTersedia);
    // }

    public function penghuluAvailable(Request $request)
    {
        // dd($request);
        $tanggal = $request->tanggal; // format: Y-m-d
        $jamPermintaan = $request->waktu; // format: H:i

        // Ubah jam ke format Carbon
        $jamMulai = Carbon::createFromFormat('H:i', $jamPermintaan);
        $jamSelesai = (clone $jamMulai)->addHours(2); // dianggap sibuk 2 jam

        // Ambil semua user_id penghulu yang bentrok di waktu tersebut
        $penghuluSibuk = BusyHour::where('date', $tanggal)
            ->get()
            ->filter(function ($item) use ($jamMulai, $jamSelesai) {
                $jamSibuk = Carbon::createFromFormat('H:i:s', $item->time);
                $jamSibukSelesai = (clone $jamSibuk)->addHours(2); // waktu sibuk penghulu

                return $jamMulai->between($jamSibuk, $jamSibukSelesai->subMinute()) || // mulai bentrok
                    $jamSelesai->between($jamSibuk->addMinute(), $jamSibukSelesai); // selesai bentrok
            })
            ->pluck('user_id');

        // Ambil penghulu yang tidak sibuk
        $penghuluTersedia = User::activePenghulu()
            ->whereNotIn('id', $penghuluSibuk)
            ->get();

        return response()->json($penghuluTersedia);
    }
}
