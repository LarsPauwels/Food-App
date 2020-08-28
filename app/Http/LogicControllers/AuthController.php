<?php

namespace App\Http\LogicControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Hash;

use App\User;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\AuthController as LogicAuth;

class AuthController {
    
    /* LOGIN */
    public static function login(Request $req) {
        $validation = ValidationHelper::auth($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $creadentials = $req->only(['email', 'password']);

        if(Auth::attempt($creadentials, $req->remember)) { 
            $user = Auth::user(); 
            $token =  $user->createToken('Personal Access Token')->accessToken;
            $user->token = $token;

            return $user;
        } 
        return null;
    }

    /* REGISTER */
    public static function register(Request $req) {
        $validation = ValidationHelper::authRegister($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $user = new User;

        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->role_id = $req->role_id;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($user->save()) { 
            return LogicAuth::login($req);
        }
        return null;
    }

    /* LOGOUT */
    public static function logout(Request $req) {
        $user = Auth::user();
        $user->token = $req->bearerToken();

        $req->user()->token()->revoke();

        return $user;
    }
}
