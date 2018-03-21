<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Google OAuth callback. Creates new user if they don't exist
     */
    public function googleCallback()
    {
        $google_user = $this->socialite()->user();

        if ($google_user->email === env('EMAIL')) {
            $user = new User;
            $user->email = $google_user->email;

            Auth::login($user, true);
        }

        return redirect()->route('show.index');
    }

    /**
     * Redirect to Google OAuth login
     */
    public function redirectToGoogle()
    {
        return $this->socialite()->redirect();
    }

    /**
     * Load 3rd party authentication package
     */
    private function socialite()
    {
        return \Socialite::driver('google');
    }
}
