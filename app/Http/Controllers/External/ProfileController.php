<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Symfony\Component\String\b;

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

    public function update($id)
    {
        request()->validate([
            'username' => 'required|string|max:100',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users')->ignore($id),
            ],
        ]);

        $user = User::findOrFail($id);
        $user->update(request()->all());

        return redirect()->route('customer.profile.show', $user->id)->with('success', '');
    }

    public function changePassword()
    {
        return view('external.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::guard('customer')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'current password is incorrect']);
        }

        $user->update(['password' => $request->password]);

        Auth::guard('customer')->login($user);
        $request->session()->regenerate();

        return back()->with('success', 'password changed successfully');
    }
}
