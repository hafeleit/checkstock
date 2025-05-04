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
        Auth::logout();

        $id = intval(request()->id);
        $this->user = User::find($id);
    }

    public function show()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        /*$attributes = $request->validate([
            'email' => ['required'],
            'password' => ['required', 'min:5'],
            'new_password' => ['required', 'min:5', 'confirmed'],
        ]);*/

        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:5'], // current password
            'new_password' => [
                'required',
                'string',
                'min:15',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).+$/'
            ],
        ], [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
        ]);

        $existingUser = User::where('email', $attributes['email'])->first();
        if ($existingUser) {

          if (!Hash::check($attributes['password'], $existingUser->password)) {
              throw ValidationException::withMessages([
                  'password' => 'Current password is incorrect.',
              ]);
          }

            $existingUser->update([
                'password' => $attributes['new_password']
            ]);
            return redirect('login');
        } else {
            return back()->with('error', 'Your email does not match the email who requested the password change');
        }
    }
}
