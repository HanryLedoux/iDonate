<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's public profile (LinkedIn Style).
     */
    public function show($id = null)
    {
        $userId = $id ?: Auth::id();
        $profileUser = \App\Models\User::with(['company.foodItems' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($userId);

        $events = [];
        if ($profileUser->role === 'voluntario' || $profileUser->role === 'doador') {
            $events = \App\Models\Event::where('user_id', $profileUser->id)->orderBy('event_date', 'desc')->get();
        }

        return view('profile.show', compact('profileUser', 'events'));
    }

    /**
     * Display the user's profile form (Settings).
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $foodItems = null;

        if ($user->role === 'doador') {
            if (!$user->company) {
                $user->company()->create(['name' => $user->name]);
                $user->refresh();
            }
            $foodItems = $user->company->foodItems()->orderBy('created_at', 'desc')->get();
        }

        return view('profile.edit', [
            'user' => $user,
            'foodItems' => $foodItems,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
