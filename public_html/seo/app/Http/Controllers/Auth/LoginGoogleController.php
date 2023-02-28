<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
class LoginGoogleController extends Controller
{
    //
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }     
     public function callback(){
        start_Session();
            $user = Socialite::driver('google')->user();
           $_SESSION['google_token'] = $user->token;
            return  redirect('sca');

     }          
}
