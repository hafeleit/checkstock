<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePassword extends Controller
{

    protected $user;

    public function __construct()
    {
        //Auth::logout();

        //$id = intval(request()->id);
        //$this->user = User::find($id);
    }

    public function show()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'email'    => ['required'],
            'password' => ['required'],
        ]);

        $existingUser = User::where('email', $request->input('email'))->first();

        // Check password matches the current password
        if (!$existingUser || !Hash::check($request->input('password'), $existingUser->password)) {
            throw ValidationException::withMessages([
                'password' => 'Current password is incorrect.',
            ]);
        }

        // Validate the new password
        $attributes = $request->validate([
            'new_password' => [
                'required',
                'string',
                'min:15',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).+$/'
            ],
        ], [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);

        // Check new password is the same as the current password
        if (Hash::check($attributes['new_password'], $existingUser->password)) {
            return back()->withErrors(['new_password' => 'Cannot use the same password as the current one.']);
        }

        $existingUser->update([
            'password'            => $attributes['new_password'],
            'password_updated_at' => now(),
            'password_expired_at' => now()->addDays(config('services.password.expire_days')),
        ]);

        return redirect('profile')->with('success', 'Password successfully updated');
    }
}
