<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Auth as AuthResource;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\AuthController as LogicAuth;

class AuthController extends Controller {
    /**
     * @OA\Post(
     *     path="/v1/login",
     *     tags={"Auth"},
     *     summary="Login into account.",
     *     operationId="login",
     * 
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="remember", type="boolean")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     * )
     *
     * login API 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $req) {
        $user = LogicAuth::login($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new AuthResource($user);
        }

        $message = 'Your e-mail or password is incorrect.';
        return ErrorHelper::exceptions($message, 400);
    }

    /**
     * @OA\Post(
     *     path="/v1/register",
     *     tags={"Auth"},
     *     summary="Create new user.",
     *     operationId="createUser",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="role_id", type="integer"),
     *             @OA\Property(property="remember", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Invalid request"
     *      ),
     * )
     *  
     * Create order api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $req) {
        $user = LogicAuth::register($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new AuthResource($user);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Get(
     *     path="/v1/logout",
     *     tags={"Auth"},
     *     summary="Logout of account.",
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     *    
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     *
     * Logout api
     *
     * @return \Illuminate\Http\Response 
     */
    public function logout(Request $req) {
        $user = LogicAuth::logout($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new AuthResource($user);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}
