<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Supplier as SupplierResource;
use App\Http\Resources\SupplierCollection as SupplierCollection;
use App\Http\Resources\Revenue as RevenueResource;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\SupplierController as LogicSupplier;

class SupplierController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/supplier/list",
     *     tags={"Suppliers"},
     *     summary="Get all suppliers with/without timesheet.",
     *     operationId="supplier",
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
     *         name="timesheet",
     *         description="Disable/Enable the timesheet return.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="true/false" 
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
     * Get all suppliers api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getSuppliers(Request $req) {
        $suppliers = LogicSupplier::getSuppliers($req);

        if (is_a($suppliers, 'Illuminate\Http\JsonResponse')) {
            return $suppliers;
        }

        if (count($suppliers)) {
            return new SupplierCollection($suppliers);
        }

        return ErrorHelper::notFound('suppliers');
    }

    /**
     * @OA\Get(
     *     path="/v1/supplier/{id}",
     *     tags={"Suppliers"},
     *     summary="Get supplier by id with/without timesheet.",
     *     operationId="supplierId",
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
     *     @OA\Parameter(
     *         name="timesheet",
     *         description="Disable/Enable the timesheet return.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="true/false" 
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
     * Get supplier by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getSupplierById(Request $req, $id) {
        $supplier = LogicSupplier::getSupplierById($req, $id);

        if (is_a($supplier, 'Illuminate\Http\JsonResponse')) {
            return $supplier;
        }

        if (!is_null($supplier)) {
            return new SupplierResource($supplier);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Get(
     *     path="/v1/supplier/{id}/revenue",
     *     tags={"Suppliers"},
     *     summary="Get suppliers revenue.",
     *     operationId="supplierRevenue",
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
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="today/week/month/year" 
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
     * Get Get suppliers revenue api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getSupplierRevenue(Request $req, $id) {
        $revenue = LogicSupplier::getSupplierRevenue($req, $id);

        if (is_a($revenue, 'Illuminate\Http\JsonResponse')) {
            return $revenue;
        }

        if (!is_null($revenue)) {
            return new RevenueResource((object)["revenue" => $revenue]);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Post(
     *     path="/v1/supplier/{id}/request",
     *     tags={"Suppliers"},
     *     summary="Create a request to company.",
     *     operationId="supplierCreateRequest",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string")
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
     * Create a request to company api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createSupplier(Request $req) {
        $supplier = LogicSupplier::createSupplier($req);

        if (is_a($supplier, 'Illuminate\Http\JsonResponse')) {
            return $supplier;
        }

        if (!is_null($supplier)) {
            return new SupplierResource($supplier);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/supplier/{id}",
     *     tags={"Suppliers"},
     *     summary="Update a supplier.",
     *     operationId="supplierUpdate",
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
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="number", type="string"),
     *             @OA\Property(property="province", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="country", type="string"),
     *             @OA\Property(property="locked", type="boolean")
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
     * Update supplier by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateSupplierById(Request $req, $id) {
        $supplier = LogicSupplier::updateSupplierById($req, $id);

        if (is_a($supplier, 'Illuminate\Http\JsonResponse')) {
            return $supplier;
        }

        if (!is_null($supplier)) {
            return new SupplierResource($supplier);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/supplier/{id}",
     *     tags={"Suppliers"},
     *     summary="Delete a supplier.",
     *     operationId="supplierDelete",
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
     * Delete supplier by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteSupplierById($id) {
        $supplier = LogicSupplier::deleteSupplierById($id);

        if (is_a($supplier, 'Illuminate\Http\JsonResponse')) {
            return $supplier;
        }

        if (!is_null($supplier)) {
            return new SupplierResource($supplier);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}
