<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Base as BaseResource;
use App\Http\Resources\BaseCollection as BaseCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\BaseController as LogicBase;

class BaseController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/supplier/{supplierId}/base/list",
     *     tags={"Bases"},
     *     summary="Get all bases by supplier.",
     *     operationId="base",
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
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *              response=401,
     *              description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     *  
     * Get all bases by supplier api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getAllBasesBySupplier(Request $req, $supplierId) {
        $bases = LogicBase::getAllBasesBySupplier($req, $supplierId);

        if (is_a($bases, 'Illuminate\Http\JsonResponse')) {
            return $bases;
        }

        if (count($bases)) {
            return new BaseCollection($bases);
        }

        return ErrorHelper::notFound('bases');
    }

    /**
     * @OA\Post(
     *     path="/v1/supplier/{supplierId}/base",
     *     tags={"Bases"},
     *     summary="Create a new base.",
     *     operationId="baseCreate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="isAvailable", type="boolean"),
     *             @OA\Property(
     *                 property="toppings",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="price", type="number"),
     *                     @OA\Property(property="available", type="boolean")
     *                 ),
     *             )
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
     * Create a new base api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createBase(Request $req, $supplierId) {
        $base = LogicBase::createBase($req, $supplierId);

        if (is_a($base, 'Illuminate\Http\JsonResponse')) {
            return $base;
        }

        if (!is_null($base)) {
            return new BaseResource($base);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/base/{id}",
     *     tags={"Bases"},
     *     summary="Update a base.",
     *     operationId="baseUpdate",
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
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="isAvailable", type="boolean"),
     *             @OA\Property(
     *                 property="toppings",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="price", type="number"),
     *                     @OA\Property(property="available", type="boolean")
     *                 ),
     *             )
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
     * Update base by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateBaseById(Request $req, $id) {
        $base = LogicBase::updateBaseById($req, $id);

        if (is_a($base, 'Illuminate\Http\JsonResponse')) {
            return $base;
        }

        if (!is_null($base)) {
            return new BaseResource($base);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/base/{id}",
     *     tags={"Bases"},
     *     summary="Delete a base.",
     *     operationId="baseDelete",
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
     * Delete base by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteBaseById($id) {
        $base = LogicBase::deleteBaseById($id);

        if (is_a($base, 'Illuminate\Http\JsonResponse')) {
            return $base;
        }

        if (!is_null($base)) {
            return new BaseResource($base);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}