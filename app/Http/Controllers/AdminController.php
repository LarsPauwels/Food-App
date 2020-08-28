<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Admin as AdminResource;
use App\Http\Resources\AdminCollection as AdminCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\AdminController as LogicAdmin;

class AdminController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/admin/list",
     *     tags={"Admins"},
     *     summary="Get all Admins.",
     *     operationId="admins",
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
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     *
     * Get all admins api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getAdmins(Request $req) {
        $admins = LogicAdmin::getAdmins($req);

        if (is_a($admins, 'Illuminate\Http\JsonResponse')) {
            return $admins;
        }

        if (count($admins)) {
            return new AdminCollection($admins);
        }

        return ErrorHelper::notFound('admins');
    }

    /**
     * @OA\Get(
     *     path="/v1/admin/{id}",
     *     tags={"Admins"},
     *     summary="Get admin by id.",
     *     operationId="adminId",
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
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Get admin by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getAdminById($id) {
        $admin = LogicAdmin::getAdminById($id);

        if (is_a($admin, 'Illuminate\Http\JsonResponse')) {
            return $admin;
        }

        if (!is_null($admin)) {
            return new AdminResource($admin);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Post(
     *     path="/v1/admin",
     *     tags={"Admins"},
     *     summary="Create a new admin.",
     *     operationId="adminCreate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string"),
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
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Create a new admin api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createAdmin(Request $req) {
        $admin = LogicAdmin::createAdmin($req);

        if (is_a($admin, 'Illuminate\Http\JsonResponse')) {
            return $admin;
        }

        if (!is_null($admin)) {
            return new AdminResource($admin);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/admin/{id}",
     *     tags={"Admins"},
     *     summary="Update admin by id.",
     *     operationId="adminUpdate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
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
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Update admin by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateAdminById(Request $req, $id) {
        $admin = LogicAdmin::updateAdminById($req, $id);

        if (is_a($admin, 'Illuminate\Http\JsonResponse')) {
            return $admin;
        }

        if (!is_null($admin)) {
            return new AdminResource($admin);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/admin/{id}",
     *     tags={"Admins"},
     *     summary="Delete admin by id.",
     *     operationId="adminDelete",
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
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Delete admin by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteAdminById($id) {
        $admin = LogicAdmin::deleteAdminById($id);

        if (is_a($admin, 'Illuminate\Http\JsonResponse')) {
            return $admin;
        }

        if (!is_null($admin)) {
            return new AdminResource($admin);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}
