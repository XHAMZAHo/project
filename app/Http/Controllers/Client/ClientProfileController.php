<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('client.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:30',
            'company' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'phone', 'company']));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }
}
