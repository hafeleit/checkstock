<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use App\Models\External\User;
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

            // check if user is a customer
            if ($user->type === 'customer') {
                $request->session()->regenerate();
                $user->update(['last_logged_in_at' => Carbon::now()]);
                return redirect('/customer/products');
            }

            // check if user is an employee with the super-admin role
            if ($user->type === 'employee' && $user->hasRole('super-admin')) {
                $request->session()->regenerate();
                $user->update(['last_logged_in_at' => Carbon::now()]);
                return redirect('/customer/products');
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'You do not have permission to access this area.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/customer/login');
    }
}
