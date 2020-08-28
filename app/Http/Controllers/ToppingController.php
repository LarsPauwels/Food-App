<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Topping as ToppingResource;
use App\Http\Resources\ToppingCollection as ToppingCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\ToppingController as LogicTopping;

class ToppingController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/base/{baseId}/topping/list",
     *     tags={"Toppings"},
     *     summary="Get all toppings by base.",
     *     operationId="topping",
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
     * Get all toppings by base api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getAllToppingsByBase(Request $req, $baseId) {
        $toppings = LogicTopping::getAllToppingsByBase($req, $baseId);

        if (is_a($toppings, 'Illuminate\Http\JsonResponse')) {
            return $toppings;
        }

        if (count($toppings)) {
            return new ToppingCollection($toppings);
        }

        return ErrorHelper::notFound('toppings');
    }

    /**
     * @OA\Post(
     *     path="/v1/base/{baseId}/topping",
     *     tags={"Toppings"},
     *     summary="Create a new topping.",
     *     operationId="toppingCreate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="toppings",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="price", type="number"),
     *                     @OA\Property(property="isAvailable", type="boolean")
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
     * Create a new topping api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createTopping(Request $req, $baseId) {
        $toppings = LogicTopping::createTopping($req, $baseId);

        if (is_a($toppings, 'Illuminate\Http\JsonResponse')) {
            return $toppings;
        }

        if (!is_null($toppings)) {
            return new ToppingCollection($toppings);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/base/{baseId}/topping",
     *     tags={"Toppings"},
     *     summary="Delete a topping.",
     *     operationId="toppingDelete",
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
     * Delete topping by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteToppingByBase($baseId) {
        $toppings = LogicTopping::deleteToppingByBase($baseId);

        if (is_a($toppings, 'Illuminate\Http\JsonResponse')) {
            return $toppings;
        }

        if (!is_null($toppings)) {
            return new ToppingCollection($toppings);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}