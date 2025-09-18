<?php

namespace App\Http\Controllers;

use App\Events\UserLoggedIn;
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

        if ($user) {
            // ตรวจสอบสถานะบัญชี
            if ($user->is_active === 0) {
                $errorMessage = 'Your account is not active. Please contact the administrator.';
                event(new UserLoggedIn($user->id, 'login', 'fail', $errorMessage));
                return back()->withErrors([
                    'email' => 'Your account is not active. Please contact the administrator.',
                ]);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'employee'])) {
                // กรณีล็อกอินสำเร็จ
                event(new UserLoggedIn(Auth::id(), 'login', 'pass'));

                // ล้าง role/permission cache ของ Spatie
                app()[PermissionRegistrar::class]->forgetCachedPermissions();

                $request->session()->regenerate();
                $user->update(['last_logged_in_at' => Carbon::now()]);

                return redirect()->intended('profile');
            }

            // ถ้า Auth::attempt ล้มเหลว (รหัสผ่านไม่ถูกต้อง)
            $errorMessage = 'Invalid email or password.';
            event(new UserLoggedIn($user->id, 'login', 'fail', $errorMessage));

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        } else {
            $errorMessage = 'Your account is not active. Please contact the administrator.';
            event(new UserLoggedIn(null, 'login', 'fail', 'Invalid email or password.'));
            return back()->withErrors(['email' => $errorMessage]);
        }
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
