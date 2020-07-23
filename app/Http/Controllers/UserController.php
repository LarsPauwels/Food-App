<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Hash;

use App\User;
use App\Employee;
use App\Supplier;

use App\Http\Resources\Auth as AuthResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection as UserCollection;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class UserController extends Controller {

    /**
     * @OA\Post(
     *     path="/v1/login",
     *     tags={"Users"},
     *     summary="Login into account.",
     *     operationId="login",
     * 
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
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
        $creadentials = $req->only(['email', 'password']);

        if(Auth::attempt($creadentials)) { 
            $user = Auth::user(); 
            $token =  $user->createToken('Personal Access Token')->accessToken;
            $user->token = $token;
            $user->message = 'You are successfully logged in!';

            return new AuthResource($user);
        } 

        $message = 'Your e-mail or password is incorrect.';
        return ErrorHelper::exceptions($message, 400);
    }

    /**
     * @OA\Post(
     *     path="/v1/register",
     *     tags={"Users"},
     *     summary="Create new user.",
     *     operationId="createUser",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="role_id", type="integer")
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
        $validation = ValidationHelper::auth($req);

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
            $request = Request::create('/api/v1/login', 'POST', $req->all());
            return Route::dispatch($request);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Get(
     *     path="/v1/logout",
     *     tags={"Users"},
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
        $user = Auth::user();
        $user->token = $req->bearerToken();
        $user->message = 'You are successfully logged out!';

        $req->user()->token()->revoke();

        return new AuthResource($user);
    }

    /**
     * @OA\Get(
     *     path="/v1/users",
     *     tags={"Users"},
     *     summary="Get all users.",
     *     operationId="users",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="active",
     *         description="Return only active/deleted users.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ), 
     *     @OA\Parameter(
     *         name="amount",
     *         description="Return amount in one page (min. 1 and max. 200).",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
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
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Get all users api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getUsers(Request $req) {
        if (Gate::authorize('admin')) {
            $active = $req->active;
            $page = (int)$req->amount;

            if (empty($active)) {
                $active = true;
            }

            if ($req->amount === null) {
                $page = 50;
            }

            if ($page <= 0 || $page > 200) {
                $message = 'The amount value needs to be minimal 1 or maximum 200.';
                return ErrorHelper::exceptions($message, 400);
            }

            if ($active === 'true') {
                $users = User::paginate($page);
            } else {
                $users = User::withTrashed()->paginate($page);
            }

            if (count($users)) {
                return new UserCollection($users);
            }

            return ErrorHelper::notFound('users');
        }
    }

    /**
     * @OA\Get(
     *     path="/v1/users/{id}",
     *     tags={"Users"},
     *     summary="Get user by id.",
     *     operationId="usersId",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
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
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Get user by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getUserById($id) {
        if (Gate::any(['admin', 'user'], $id)) {
            $user = User::find($id);

            if ($user == null) {
               return ErrorHelper::notFound('user', $id);
            }

            if (!empty($user)) {
                return new UserResource($user);
            }
        }
    }

    /**
     * @OA\Put(
     *     path="/v1/users/{id}",
     *     tags={"Users"},
     *     summary="Update user by id.",
     *     operationId="updateUsers",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
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
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Get user by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateUserById(Request $req, $id) {
        if (Gate::authorize('user', $id)) {
            $validation = ValidationHelper::auth($req);
            if ($validation !== true) {
                return ErrorHelper::exceptions($validation, 400);
            }

            $user = User::find($id);

            if ($user == null) {
                return new ErrorResource(ErrorHelper::notFound('user', $id));
            }

            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->updated_at = date('Y-m-d H:i:s');

            if ($user->save()) {
                return new UserResource($user);
            }

            $message = 'Something went wrong! Try again later.';
            return ErrorHelper::exceptions($message, 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/v1/users/{id}",
     *     tags={"Users"},
     *     summary="Delete user by id.",
     *     operationId="deleteUsers",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
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
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Get user by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteUserById($id) {
        if (Gate::authorize('user', $id)) {
            $user = User::find($id);

            if ($user == null) {
                return ErrorHelper::notFound('user', $id);
            }

            if ($user->delete()) {
                $employee = User::withTrashed()->findorfail($id)->employee;
                $supplier = User::withTrashed()->findorfail($id)->supplier;

                $orders = [];
                if (!empty($employee)) {
                    $orders = Employee::findorfail($employee->id)->orders;
                } else if (!empty($supplier)) {
                    $orders = Supplier::findorfail($supplier->id)->orders;
                }
                
                foreach ($orders as $order) {
                    $order->delete();
                }

                return new UserResource($user);
            }
        }
    }
}