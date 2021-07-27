<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DefaultLoginController extends Controller
{
    public function login(Request $request){
        $user = $this->emailRegistred($request->input('email'));
        
        if(!$user)
            return;
        
        if(!Hash::check($request->input('password'), $user->password))
            return;

        Auth::login($user);
    }

    public function register(Request $request){
        if($this->nameRegistred($request->input('name')))
            return;

        if($this->emailRegistred($request->input('email')))
            return;
        
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
    }

    private function nameRegistred(String $username){
        return User::where('name', '=', $username)->first();
    }

    private function emailRegistred(String $email){
        return User::where('email', '=', $email)->first();
    }

}