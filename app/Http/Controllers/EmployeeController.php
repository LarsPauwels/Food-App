<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Employee;

use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Resources\EmployeeCollection as EmployeeCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

class EmployeeController extends Controller {

    /**
     * @OA\Get(
     *     path="/v1/employees",
     *     tags={"Employees"},
     *     summary="Get all employees.",
     *     operationId="employee",
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
    public function getEmployees() {
        $employees = Employee::with('user', 'company')->get();

        foreach ($employees as $employee) {
            $employee->company->employees = [];
        }

        if (count($employees)) {
            return new EmployeeCollection($employees);
        }

        return ErrorHelper::notFound('employees');
    }

    /**
     * @OA\Get(
     *     path="/v1/employees/{id}",
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
    public function getEmployeeById($id, $internal = false) {
        $employee = Employee::with('user', 'company')->find($id);
        $employee->company->employees = null;

        if ($employee == null) {
           return ErrorHelper::notFound('employee', $id);
        }

        if (!empty($employee)) {
            return new EmployeeResource($employee);
        }
    }

    /**
     * @OA\Delete(
     *     path="/v1/employees/{id}",
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
     *          response=401,
     *          description="Unauthorized"
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
    public function deleteEmployeeById($id, Request $req) {
        $employee = Employee::with(['user' => function ($q) {
            $q->withTrashed();
        }])->find($id);

        if ($employee == null) {
            return ErrorHelper::notFound('employee', $id);
        }

        $userId = $employee->user_id;
        $token = $req->bearerToken();

        $request = Request::create('/api/v1/users/'.$userId, 'DELETE');
        $request->headers->set('Authorization', 'Bearer '.$token);

        if (Route::dispatch($request)) {
            return new EmployeeResource($employee);
        }
    }
}