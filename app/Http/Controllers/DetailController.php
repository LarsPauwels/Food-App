<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Detail as DetailResource;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\DetailController as LogicDetail;

class DetailController extends Controller {
    /**
     * @OA\Post(
     *     path="/v1/detail",
     *     tags={"Details"},
     *     summary="Create a new detail.",
     *     operationId="DetailCreate",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="number", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="province", type="string"),
     *             @OA\Property(property="country", type="string")
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
     * Create a new detail api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createDetail(Request $req) {
        $detail = LogicDetail::createDetail($req);

        if (is_a($detail, 'Illuminate\Http\JsonResponse')) {
            return $detail;
        }

        if (!is_null($detail)) {
            return new DetailResource($detail);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/detail/{id}",
     *     tags={"Details"},
     *     summary="Update a detail.",
     *     operationId="detailUpdate",
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
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="number", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="province", type="string"),
     *             @OA\Property(property="country", type="string")
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
     * Update detail by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateDetailById(Request $req, $id) {
        $detail = LogicDetail::updateDetailById($req, $id);

        if (is_a($detail, 'Illuminate\Http\JsonResponse')) {
            return $detail;
        }

        if (!is_null($detail)) {
            return new DetailResource($detail);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}