<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function picking()
    {
        return view('auth.picking');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1, 'type' => 'employee'])) {
            $request->session()->regenerate();
            auth()->user()->update(['last_logged_in_at' => Carbon::now()]);
            if ($request->filled('from')) {
                $request->session()->put('is_double_login', true);
                return redirect($request->input('from'));
            }
            return redirect()->intended('profile');
        }

        $user = User::where('email', $request->email)->first();

        if ($user && $user->is_active === 0) {
            return back()->withErrors([
                'email' => 'Your account is not active. Please contact the administrator.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('is_double_login');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
