<?php
namespace App\Http\Helpers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;

class ValidationHelper {
	
	/** 
     * checks if validation is valid
     * 
     * @return boolean
     */ 
	public static function auth(Request $req) {
		$messages = [
            'regex' => 'The password must contain at least one letter, uppercase letter and number.'
        ];

        $validation = Validator::make($req->all(), [
            'email' => 'required|email|unique:App\User,email|max:255',
            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'role_id' => 'required|integer'
        ], $messages);

        if ($validation->fails()) {
            return $validation->errors();
        }
        return true;
	}
}