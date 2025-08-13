<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MyAccountController extends Controller
{
    public function editMyAccount()
    {
        return view('user.my-account');
    }
    public function updateMyAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);
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

        if ($request->has('isDeletePP')) {
            if ($request->old_profile_picture && Storage::exists($request->old_profile_picture)) {
                Storage::delete($request->old_profile_picture);
            }
            $validatedData['profile_picture'] = null;
        } else {
            if ($request->file('profile_picture')) {
                $request->validate([
                    'profile_picture' => 'image|file|max:2048'
                ]);
                if ($request->old_profile_picture && Storage::exists($request->old_profile_picture)) {
                    Storage::delete($request->old_profile_picture);
                }
                $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_picture', 'public');
            } else $validatedData['profile_picture'] = $request->old_profile_picture;
        }

        $user->update($validatedData);
        return redirect()->route('edit.myAccount')->with('success', 'Berhasil merubah data akun');
    }
}
