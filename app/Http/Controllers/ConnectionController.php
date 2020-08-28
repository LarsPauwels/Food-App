<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\CompanyCollection as CompanyCollection;
use App\Http\Resources\Supplier as SupplierResource;
use App\Http\Resources\SupplierCollection as SupplierCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\ConnectionController as LogicConnection;

class ConnectionController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/supplier/company/{companyId}",
     *     tags={"Connections"},
     *     summary="Get all suppliers by company.",
     *     operationId="supplierCompany",
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
     * Get all suppliers by company api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getSuppliers(Request $req, $companyId) {
        $suppliers = LogicConnection::getSuppliers($req, $companyId);

        if (is_a($suppliers, 'Illuminate\Http\JsonResponse')) {
            return $suppliers;
        }

        if (!is_null($suppliers)) {
            return new SupplierCollection($suppliers);
        }

        return ErrorHelper::notFound('suppliers');
    }

    /**
     * @OA\Get(
     *     path="/v1/company/supplier/{supplierId}",
     *     tags={"Connections"},
     *     summary="Get all companies by supplier.",
     *     operationId="company",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\Parameter(
     *         name="orderBy",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="name, date"
     *         )
     *     ),
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
     *         name="date",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="today, week, month, year"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="employees",
     *         description="Disable/Enable the employees return.",
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
     * Get all companies by supplier api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getCompanies(Request $req, $supplierId) {
        $companies = LogicConnection::getCompanies($req, $supplierId);

        if (is_a($companies, 'Illuminate\Http\JsonResponse')) {
            return $companies;
        }

        if (!is_null($companies)) {
            return new CompanyCollection($companies);
        }

        return ErrorHelper::notFound('companies');
    }

    /**
     * @OA\Post(
     *     path="/v1/supplier/{id}/add",
     *     tags={"Connections"},
     *     summary="Create a new supplier.",
     *     operationId="supplierCreate",
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
     * Create a new supplier api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createConnection(Request $req, $id) {
        $company = LogicConnection::createConnection($req, $id);

        if (is_a($company, 'Illuminate\Http\JsonResponse')) {
            return $company;
        }

        if (!is_null($company)) {
            return new CompanyResource($company);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/supplier/{id}/company/{companyId}/accept",
     *     tags={"Connections"},
     *     summary="Update supplier company connection.",
     *     operationId="supplierUpdateCompany",
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
     *         name="companyId",
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
     * Update supplier company connection api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateConnection($id, $companyId) {
        $supplier = LogicConnection::updateConnection($id, $companyId);

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
     *     path="/v1/supplier/{id}/company/{companyId}/deny",
     *     tags={"Connections"},
     *     summary="Delete supplier company connection.",
     *     operationId="supplierDeleteCompany",
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
     *         name="companyId",
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
     * Delete supplier company connection api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteConnection($id, $companyId) {
        $supplier = LogicConnection::deleteConnection($id, $companyId);

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