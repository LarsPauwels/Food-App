<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthorizationHelper {
	
	/** 
     * check if role has access to call
     * 
     * @return Boolean 
     */ 
	public static function checkRole($roles) {
        $user = Auth::user()->role_id;
        $validation = [];

		foreach ($roles as $role) {
            $roleId = \App\Role::select('id')
                        ->where('name', '=', $role)
                        ->first();
            if ($roleId->id == $user) {
                array_push($validation, 'true');
            } else {
                array_push($validation, 'false');
            }
        }
        return in_array('true', $validation);
	}

    /** 
     * check if id has access to call
     * 
     * @return Boolean
     */ 
    public static function checkId($id, $roles = null) {
        if (AuthorizationHelper::checkRole($roles)) {
            return true;
        }

        $user = Auth::user()->id;
        if ($user == $id) {
            return true;
        }
        return false;
    }
}