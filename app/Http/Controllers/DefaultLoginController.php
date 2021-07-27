<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DefaultLoginController extends Controller
{
    public function login($data){
        $user = emailRegistred($data->email);
        
        if(!$user)
            return;
        
        if(!Hash::check($data->password, $user->password))
            return;

        Auth::login($user);
    }

    public function register($data){
        if(nameRegistred($data->name))
            return;

        if(emailRegistred($data->email))
            return;
        
        $user = new USer();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = Hash::make($data->password);
        $user->save();
    }

    private function nameRegistred(String $username){
        return User::where('name', '=', $username)->first();
    }

    private function emailRegistred(string $email){
        return User::where('email', '=', $email)->first();
    }

}