<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthenticationController extends Controller
{
    public function googleRedirect(){
        return Socialite::driver('google')->redirect();
    }
    public function googleRedirectCallBack(){
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email',$googleUser->email)->first();
        if($user){
            Auth::login($user);
            return redirect()->route('dashboard');
        }else{
           $user = User::create([
                'name'=>$googleUser->name,
                'email'=>$googleUser->email,
                'password'=>Hash::make('12345678'),
                'google_id'=>$googleUser->id
            ]);
            if($user){
                Auth::login($user);
                return redirect()->route('dashboard');
            }
        }
    }
}
