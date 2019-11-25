<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class MattermostAuthController extends Controller
{
    public function login(Request $request)
    {
        return Socialite::driver('mattermost')
            ->redirect();
    }

    public function callback()
    {
        $mattermostUser = Socialite::driver('mattermost')->user();

        $user = User::firstOrCreate([
            'mattermost_user_id' => $mattermostUser->id,
        ], [
            'mattermost_user_id' => $mattermostUser->id,
            'email' => $mattermostUser->email,
            'name' => $mattermostUser->name,
            'real_name' => $mattermostUser->real_name,
        ]);

        Auth::login($user, true);
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    private function guard()
    {
        return Auth::guard();
    }
}
