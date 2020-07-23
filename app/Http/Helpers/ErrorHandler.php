<?php
namespace App\Http\Helpers;

use App\Http\Resources\ErrorHandler as ErrorResource;

class ErrorHandler {
	
	public static function notFound($name, $id = false, $role = false) {
        if ($id === false) {
            $message = 'There are currently no '.$name.' to display.';
        } else if ($role === false) {
            $message = 'There was no '.$name.' found with id \''.$id.'\'.';
        } else {    
            $message = 'There was no '.$name.' found with '.$role.' id \''.$id.'\'.';
        }

        return (new ErrorResource((object) [
            'message' => $message,
            'status' => 'fail',
            'code' => 404
        ]))->response()->setStatusCode(404);
	}

    public static function exceptions($message, $code) {
        return (new ErrorResource((object) [
            'message' => $message,
            'status' => 'error',
            'code' => $code
        ]))->response()->setStatusCode($code);
    }
}