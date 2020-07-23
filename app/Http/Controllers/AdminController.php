<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Route;

use App\Admin;

use App\Http\Resources\Admin as AdminResource;
use App\Http\Resources\AdminCollection as AdminCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

class AdminController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/admins",
     *     tags={"Admins"},
     *     summary="Get all Admins.",
     *     operationId="admins",
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
    public function getAdmins() {
        $admins = Admin::has('user')->get();

        if (count($admins)) {
            return new AdminCollection($admins);
        }

        return ErrorHelper::notFound('admins');
    }

    /**
     * @OA\Get(
     *     path="/v1/admins/{id}",
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
        $admin = Admin::has('user')->find($id);

        if ($admin == null) {
           return ErrorHelper::notFound('admin', $id);
        }

        if (!empty($admin)) {
            return new AdminResource($admin);
        }
    }

    /**
     * @OA\Delete(
     *     path="/v1/admins/{id}",
     *     tags={"Admins"},
     *     summary="Delete admin by id.",
     *     operationId="deleteAdmin",
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
    public function deleteAdminById($id, Request $req) {
        $admin = Admin::with(['user' => function ($q) {
            $q->withTrashed();
        }])->find($id);

        if ($admin == null) {
            return ErrorHelper::notFound('admin', $id);
        }

        $userId = $admin->user_id;
        $token = $req->bearerToken();

        $request = Request::create('/api/v1/users/'.$userId, 'DELETE');
        $request->headers->set('Authorization', 'Bearer '.$token);

        if (Route::dispatch($request)) {
            return new AdminResource($admin);
        }
    }
}
