<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\PermissionRegistrar;

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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        if ($user->is_active === 0) {
            return back()->withErrors([
                'email' => 'Your account is not active. Please contact the administrator.',
            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'employee'])) {
            // ล้าง role/permission cache ของ Spatie
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            $request->session()->regenerate();
            $user->update(['last_logged_in_at' => Carbon::now()]);
            
            if ($request->redirect) {
                return redirect()->to($request->redirect); 
            }

            return redirect()->intended('profile');
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
