<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 

use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\CompanyCollection as CompanyCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\CompanyController as LogicCompany;
use App\Http\LogicControllers\ConnectionController as LogicConnection;

class CompanyController extends Controller {
   	
   	/**
     * @OA\Get(
     *     path="/v1/company",
     *     tags={"Companies"},
     *     summary="Get all companies.",
     *     operationId="company",
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
     * Get all companies api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
   	public function getCompanies(Request $req) {
        $companies = LogicCompany::getCompanies($req);

        if (is_a($companies, 'Illuminate\Http\JsonResponse')) {
            return $companies;
        }

        if (count($companies)) {
            return new CompanyCollection($companies);
        }

        return ErrorHelper::notFound('companies');
   	}

   	/**
     * @OA\Get(
     *     path="/v1/companies/{id}",
     *     tags={"Companies"},
     *     summary="Get company by id.",
     *     operationId="companyId",
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
     * Get company by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
   	public function getCompanyById(Request $req, $id) {
        $company = LogicCompany::getCompanyById($req, $id);

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
     * @OA\Post(
     *     path="/v1/company/{id}",
     *     tags={"Companies"},
     *     summary="Create a new company.",
     *     operationId="companyCreate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="number", type="string"),
     *             @OA\Property(property="province", type="string"),
     *             @OA\Property(property="city", type="string"),
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
     * Create a new company api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createCompany(Request $req) {
        $company = LogicCompany::createCompany($req);

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
     *     path="/v1/company/{id}",
     *     tags={"Companies"},
     *     summary="Update a company.",
     *     operationId="companyUpdate",
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
     * Update company by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateCompanyById(Request $req, $id) {
        $company = LogicCompany::updateCompanyById($req, $id);

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
     * @OA\Delete(
     *     path="/v1/company/{id}",
     *     tags={"Companies"},
     *     summary="Delete a company.",
     *     operationId="companyDelete",
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
     * Delete company by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteCompanyById($id) {
        $company = LogicCompany::deleteCompanyById($id);

        if (is_a($company, 'Illuminate\Http\JsonResponse')) {
            return $company;
        }

        if (!is_null($company)) {
            return new CompanyResource($company);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}
