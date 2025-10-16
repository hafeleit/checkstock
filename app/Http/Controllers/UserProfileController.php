<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        // Validate
        $attributes = $request->validate([
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255'],
        ]);

        // Authorize the user
        if (!auth()->user()) {
            abort(403, 'Unauthorized action.');
        }

        // Update
        auth()->user()->update($attributes);

        return back()->with('success', 'Profile successfully updated');
    }
}
