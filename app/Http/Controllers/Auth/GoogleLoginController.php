<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback(): \Illuminate\Http\JsonResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        if(!$user)
        {
            $user = DB::table('users')->insert(['name' => $googleUser->name, 'email' => $googleUser->email, 'password' => Hash::make(rand(100000,999999))]);
        }

        $login = Auth::login($user);

        return response()->json([
            'status' => 'logged in with Google'
        ], 200);

//        return redirect(RouteServiceProvider::HOME);
    }
}
