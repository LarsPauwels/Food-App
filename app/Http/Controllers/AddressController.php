<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Address as AddressResource;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\AddressController as LogicAddress;

class AddressController extends Controller {
    /**
     * @OA\Post(
     *     path="/v1/address",
     *     tags={"Addresses"},
     *     summary="Create a new address.",
     *     operationId="AddressCreate",
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
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
     * Create a new address api
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createAddress(Request $req) {
        $address = LogicAddress::createAddress($req);

        if (is_a($address, 'Illuminate\Http\JsonResponse')) {
            return $address;
        }

        if (!is_null($address)) {
            return new AddressResource($address);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/address/{id}",
     *     tags={"Addresses"},
     *     summary="Update a address.",
     *     operationId="addressUpdate",
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
     * Update address by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateAddressById(Request $req, $id) {
        $address = LogicAddress::updateAddressById($req, $id);

        if (is_a($address, 'Illuminate\Http\JsonResponse')) {
            return $address;
        }

        if (!is_null($address)) {
            return new AddressResource($address);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}