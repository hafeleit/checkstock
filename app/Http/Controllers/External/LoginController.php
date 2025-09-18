<?php

namespace App\Http\Controllers\External;

use App\Events\UserLoggedIn;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.external-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::guard('customer')->user();

            if ($user->type === 'customer' || ($user->type === 'employee' && $user->hasRole('super-admin'))) {
                // บันทึก log เมื่อล็อกอินสำเร็จ
                event(new UserLoggedIn($user->id, 'external_login', 'pass'));

                $request->session()->regenerate();
                $user->update(['last_logged_in_at' => Carbon::now()]);
                
                return redirect('/customer/products');
            }

            // ถ้าล็อกอินสำเร็จ แต่ไม่มีสิทธิ์เข้าถึง
            Auth::logout();

            event(new UserLoggedIn($user->id, 'external_login', 'fail', 'Permission denied.'));
            return back()->withErrors(['email' => 'You do not have permission to access this area.'])->onlyInput('email');
        }

        // ถ้าล็อกอินไม่สำเร็จ (credentials ไม่ถูกต้อง)
        $user = User::where('email', $request->email)->first();
        $userId = $user ? $user->id : null;
        $errorMessage = 'The provided credentials do not match our records.';

        event(new UserLoggedIn($userId, 'external_login', 'fail', 'Invalid email or password.'));

        return back()->withErrors(['email' => $errorMessage])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/customer/login');
    }
}
