<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\hash;



use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function redirect() {
        return Socialite::driver('github')->redirect();
    }
    public function callback() {
        $githubUser = Socialite::driver('github')->stateless()->user();
 
        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name ?? $githubUser->nickname,
            'email' => $githubUser->email,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
            'password'=>Hash::make(Str::password(30)),
        ]);
     
        Auth::login($user);
     
        return redirect('/');
    }
}
