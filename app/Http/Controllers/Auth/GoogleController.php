<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();

            if ($findUser) {
                // Ensure user has a role entry
                if (!$findUser->userRole) {
                    \App\Models\UserRole::create([
                        'user_id' => $findUser->id,
                        'role' => 'user',
                    ]);
                }
                Auth::login($findUser);

                // Check if user has an approved registration
                $pendaftaran = Pendaftaran::where('email', $findUser->email)->first();
                if ($pendaftaran && $pendaftaran->status === 'approved') {
                    return redirect()->intended(route('home'));
                }

                return redirect()->intended(route('pendaftaran.create'));
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'avatar' => $user->avatar,
                    'password' => encrypt('123456dummy')
                ]);

                // Create default user role
                \App\Models\UserRole::create([
                    'user_id' => $newUser->id,
                    'role' => 'user',
                ]);

                Auth::login($newUser);
                return redirect()->intended(route('pendaftaran.create'));
            }
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }
}
