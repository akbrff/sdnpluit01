<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the administrator's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the administrator's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $admin = $request->user();

        $admin->nama = $request->validated('nama');
        $admin->email = $request->validated('email');

        $admin->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the administrator's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $admin = $request->user();

        // Cegah penghapusan admin terakhir agar website
        // tidak kehilangan seluruh akses administrator.
        if (Admin::query()->count() <= 1) {
            return Redirect::route('profile.edit')
                ->withErrors([
                    'password' => 'Akun admin terakhir tidak dapat dihapus.',
                ], 'userDeletion');
        }

        $admin->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
