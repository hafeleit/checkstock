<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use App\Models\External\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view("external.profile.show", [
            "user" => $user,
        ]);
    }

    public function edit($id)
    {
         $user = User::findOrFail($id);
        return view('external.profile.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        dd($request->all());
        $user->update($request->all());
    }

    public function changePassword()
    {
        return view('external.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('external.profile.show')->with('success', 'Password changed successfully');
    }
}
