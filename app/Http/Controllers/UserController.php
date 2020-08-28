<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection as UserCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\UserController as UserLogic;

class UserController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/user/list",
     *     tags={"Users"},
     *     summary="Get all users.",
     *     operationId="users",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page_size",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="asc, desc" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="active",
     *         description="Return only active/deleted users.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean",
     *             example="true, false"
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
        $users = UserLogic::getUsers($req);

        if (is_a($users, 'Illuminate\Http\JsonResponse')) {
            return $users;
        }

        if (count($users)) {
            return new UserCollection($users);
        }

        return ErrorHelper::notFound('users');
    }

    /**
     * @OA\Get(
     *     path="/v1/user/{id}",
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
        $user = UserLogic::getUserById($id);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (is_null($user)) {
           return ErrorHelper::notFound('user', $id);
        }

        if (!empty($user)) {
            return new UserResource($user);
        }
    }

    /**
     * @OA\Post(
     *     path="/v1/user",
     *     tags={"Users"},
     *     summary="Create a new user.",
     *     operationId="UserCreate",
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
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string")
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
     * Create a new user api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createUser(Request $req) {
        $user = UserLogic::createUser($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new UserResource($user);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Post(
     *     path="/v1/user/company",
     *     tags={"Users"},
     *     summary="Create a new user for company.",
     *     operationId="UserCreateCompany",
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
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string"),
     *             @OA\Property(property="company_id", type="integer")
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
     * Create a new user api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createUserCompany(Request $req) {
        $user = UserLogic::createUserCompany($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new UserResource($user);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Post(
     *     path="/v1/user/supplier",
     *     tags={"Users"},
     *     summary="Create a new user for supplier.",
     *     operationId="UserCreateSupplier",
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
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string"),
     *             @OA\Property(property="supplier_id", type="integer")
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
     * Create a new user api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createUserSupplier(Request $req) {
        $user = UserLogic::createUserSupplier($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new UserResource($user);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/user/{id}",
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
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string")
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
        $user = UserLogic::updateUserById($req, $id);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new UserResource($user);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/user/{id}",
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
     * Delete user by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteUserById($id) {
        $user = UserLogic::deleteUserById($id);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new UserResource($user);
        }
    }

    /**
     * @OA\Patch(
     *     path="/v1/user/{id}",
     *     tags={"Users"},
     *     summary="Restore user by id.",
     *     operationId="patchUsers",
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
     * Restore user by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function restoreUserById($id) {
        $user = UserLogic::restoreUserById($id);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        if (!is_null($user)) {
            return new UserResource($user);
        }
    }
}