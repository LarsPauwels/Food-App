<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Resources\EmployeeCollection as EmployeeCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\EmployeeController as LogicEmployee;

class EmployeeController extends Controller {

    /**
     * @OA\Get(
     *     path="/v1/employee/list",
     *     tags={"Employees"},
     *     summary="Get all employees.",
     *     operationId="employee",
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
     * Get all employees api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getEmployees(Request $req) {
        $employees = LogicEmployee::getEmployees($req);

        if (is_a($employees, 'Illuminate\Http\JsonResponse')) {
            return $employees;
        }

        if (count($employees)) {
            return new EmployeeCollection($employees);
        }

        return ErrorHelper::notFound('employees');
    }

    /**
     * @OA\Get(
     *     path="/v1/company/{companyId}/employee/list",
     *     tags={"Employees"},
     *     summary="Get all employees by company.",
     *     operationId="employeeCompany",
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
     * Get all employees by company api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getEmployeesByCompany(Request $req, $companyId) {
        $employees = LogicEmployee::getEmployeesByCompany($req, $companyId);

        if (is_a($employees, 'Illuminate\Http\JsonResponse')) {
            return $employees;
        }

        if (count($employees)) {
            return new EmployeeCollection($employees);
        }

        return ErrorHelper::notFound('employees');
    }

    /**
     * @OA\Get(
     *     path="/v1/employee/{id}",
     *     tags={"Employees"},
     *     summary="Get employee by id.",
     *     operationId="employeeId",
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
     * Get employee by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getEmployeeById($id) {
        $employee = LogicEmployee::getEmployeeById($id);

        if (is_a($employee, 'Illuminate\Http\JsonResponse')) {
            return $employee;
        }

        if (!is_null($employee)) {
            return new SupplierResource($employee);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Post(
     *     path="/v1/company/{companyId}/employee",
     *     tags={"Employees"},
     *     summary="Create a new employee.",
     *     operationId="employeeCreate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string")
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
     * Create a new employee api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createEmployee(Request $req, $companyId) {
        $employee = LogicEmployee::createEmployee($req, $companyId);

        if (is_a($employee, 'Illuminate\Http\JsonResponse')) {
            return $employee;
        }

        if (!is_null($employee)) {
            return new EmployeeResource($employee);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/employee/{id}",
     *     tags={"Employees"},
     *     summary="Update employee by id.",
     *     operationId="employeeUpdate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="firstname", type="string"),
     *             @OA\Property(property="lastname", type="string")
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
     * Update employee by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateEmployeeById(Request $req, $id) {
        $employee = LogicEmployee::updateEmployeeById($req, $id);

        if (is_a($employee, 'Illuminate\Http\JsonResponse')) {
            return $employee;
        }

        if (!is_null($employee)) {
            return new EmployeeResource($employee);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/employee/{id}",
     *     tags={"Employees"},
     *     summary="Delete employee by id.",
     *     operationId="deleteEmployee",
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
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     * )
     * 
     * Delete employee by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteEmployeeById($id) {
        $employee = LogicEmployee::deleteEmployeeById($id);

        if (is_a($employee, 'Illuminate\Http\JsonResponse')) {
            return $employee;
        }

        if (!is_null($employee)) {
            return new EmployeeResource($employee);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}