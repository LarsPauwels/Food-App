<?php
namespace App\Http\Helpers;

class ReturnHelper {
	
	/** 
     * return success messages
     * 
     * @return \Illuminate\Http\Response 
     */ 
	public static function sendSuccess($request, $message = false) {
		if ($message) {
			return ReturnHelper::successMessage($request);
		}

		return ReturnHelper::successData($request);
	}

	public static function successMessage($message) {
		return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'message' => $message
            ], 
        200);
	}

	public static function successData($data) {
		return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'data' => $data
            ], 
        200);
	}
	
	/** 
     * return fail messages
     * 
     * @return \Illuminate\Http\Response 
     */ 
	public static function sendfail($message, $code) {
		return response()->json(
            [
                'status' => 'fail',
                'code' => $code,
                'message' => $message
            ], 
        $code);
	}

	/** 
     * return error messages
     * 
     * @return \Illuminate\Http\Response 
     */ 
	public static function senderror($message, $code) {
		return response()->json(
            [
                'status' => 'error',
                'code' => $code,
                'message' => $message
            ], 
        $code);
	}
}