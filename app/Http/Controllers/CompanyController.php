<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Company;

use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\CompanyCollection as CompanyCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

/* REMOVE LATER */ 
use App\Http\Helpers\ReturnHelper;
use App\Http\Helpers\AuthorizationHelper;

class CompanyController extends Controller {
   	
   	/**
     * @OA\Get(
     *     path="/v1/companies",
     *     tags={"Companies"},
     *     summary="Get all companies.",
     *     operationId="company",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\Parameter(
     *         name="employees",
     *         description="Disable/Enable the employees return.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean" 
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
        $companies = Company::has('user')->get();

        if ($req->employees === 'false' || empty($req->employees)) {
            foreach ($companies as $company) {
                $company->employees = [];
            }
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
     *             type="boolean"
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
   	public function getCompanyById($id, Request $req) {
        $company = Company::has('user')->find($id);

        if ($req->employees === 'false' || empty($req->employees)) {
            $company->employees = [];
        }

        if ($company == null) {
           return ErrorHelper::notFound('company', $id);
        }

        if (!empty($company)) {
            return new CompanyResource($company);
        }
    }	

    /**
     * @OA\Delete(
     *     path="/v1/companies/{id}",
     *     tags={"Companies"},
     *     summary="Delete company by id.",
     *     operationId="deleteCompany",
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
    public function deleteCompanyById($id, Request $req) {
		$company = Company::with(['user' => function ($q) {
            $q->withTrashed();
        }])->find($id);

        if ($company == null) {
            return ErrorHelper::notFound('company', $id);
        }

        $userId = $company->user_id;
        $token = $req->bearerToken();

        $request = Request::create('/api/v1/users/'.$userId, 'DELETE');
        $request->headers->set('Authorization', 'Bearer '.$token);

        if (Route::dispatch($request)) {
            return new CompanyResource($company);
        }
    }
}
