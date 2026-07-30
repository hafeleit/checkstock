<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLoggedIn;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\PermissionRegistrar;

class AzureController extends Controller
{
    public function redirectToAzure()
    {
        return Socialite::driver('azure')->redirect();
    }

    public function handleAzureCallback(Request $request)
    {
        try {
            $azureUser = Socialite::driver('azure')->user();
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to sign in with Azure AD. Please try again.',
            ]);
        }

        $user = User::where('email', $azureUser->getEmail())->first();

        if (!$user) {
            event(new UserLoggedIn(0, 'login', 'fail', 'The provided Azure AD email does not match our records.'));
            return redirect()->route('login')->withErrors([
                'email' => 'The provided Azure AD email does not match our records.',
            ]);
        }

        if ($user->is_active === 0) {
            event(new UserLoggedIn($user->id, 'login', 'fail', 'Your account is not active. Please contact the administrator.'));
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is not active. Please contact the administrator.',
            ]);
        }

        if ($user->type === 'employee') {
            Auth::guard('web')->login($user);
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            $request->session()->regenerate();
            $user->update(['last_logged_in_at' => Carbon::now()]);

            event(new UserLoggedIn($user->id, 'login', 'pass'));

            return redirect()->intended('profile');
        }

        if ($user->type === 'customer') {
            Auth::guard('customer')->login($user);

            $request->session()->regenerate();
            $user->update(['last_logged_in_at' => Carbon::now()]);

            event(new UserLoggedIn($user->id, 'external_login', 'pass'));

            return redirect('/customer/products');
        }

        event(new UserLoggedIn($user->id, 'login', 'fail', 'You do not have permission to access this area.'));
        return redirect()->route('login')->withErrors([
            'email' => 'You do not have permission to access this area.',
        ]);
    }
}
