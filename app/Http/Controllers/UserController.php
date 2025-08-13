<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::where('role', 'admin') // Filter hanya role admin
            ->where('id', '!=', auth()->id()) // Skip user yang sedang login
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('User.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.add');
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
        $validatedData['role'] = 'admin';

        if ($request->file('profile_picture')) {
            $request->validate([
                "profile_picture" => 'image|file|max:2048',
            ]);
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_picture', 'public');
        }
        // dd($validatedData);

        User::create($validatedData);
        return redirect('/user')->with('success', 'Berhasil menambah data pengguna');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            "name" => 'required|string|max:255',
            "email" => 'required|email:dns|max:255|unique:users,email,' . $user->id,
            // "rePassword" => 'required|string|min:8|max:16',
        ]);
        // dd($validatedData);
        if ($request->has('isChangePassword')) {
            $passwordData = $request->validate([
                "password" => 'required|string|min:8|max:16|confirmed'
            ]);
            $validatedData['password'] = $passwordData['password'];
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $validatedData['role'] = $user->role;

        if ($request->file('profile_picture')) {
            // dd($request->file('profile_picture'));
            $request->validate([
                'profile_picture' => 'image|file|max:2048'
            ]);
            if ($request->old_profile_picture && Storage::exists($request->old_profile_picture)) {
                Storage::delete($request->old_profile_picture);
            }
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_picture', 'public');
        } else $validatedData['profile_picture'] = $request->old_profile_picture;

        // dd($validatedData);
        $user->update($validatedData);
        return redirect('/user')->with('success', 'Berhasil merubah data pengguna');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->profile_picture && Storage::exists($user->profile_picture)) {
            Storage::delete($user->profile_picture);
        }
        $user->delete();
        return redirect('/user')->with('success', 'Berhasil menghapus data pengguna');
    }

    // public function toggleStatus($id)
    // {
    //     $user = User::findOrFail($id);

    //     if ($user->role !== 'admin') {
    //         return back()->with('error', 'Hanya user admin yang bisa diubah statusnya di sini.');
    //     }

    //     $user->is_active = !$user->is_active;
    //     $user->save();

    //     $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
    //     return back()->with('success', "Admin berhasil $status.");
    // }
}
