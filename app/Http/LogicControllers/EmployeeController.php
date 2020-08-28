<?php
namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Employee;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;
use App\Http\Helpers\ResourceHelper;

use App\Http\LogicControllers\UserController as LogicUser;
use App\Http\LogicControllers\OrderController as LogicOrder;

class EmployeeController {

    /* GET ALL EMPLOYEES */
    public static function getEmployees(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        $employees = Employee::select('employees.*')
            ->with('user', 'company')
            ->join('users', 'users.id', '=', 'employees.user_id')
            ->where('firstname', 'LIKE', "%".$search."%")
            ->where('users.deleted_at', null)
            ->orderBy('firstname', $sort)
            ->paginate($size);

        foreach ($employees as $employee) {
            $employee->company->employees = [];
        }

        return $employees;
    }

    /* GET ALL EMPLOYEES BY COMPANY */ 
    public static function getEmployeesByCompany(Request $req, $companyId) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        $employees = Employee::select('employees.*')
            ->with('user', 'company')
            ->join('users', 'users.id', '=', 'employees.user_id')
            ->where('company_id', $companyId)
            ->where('firstname', 'LIKE', "%".$search."%")
            ->where('users.deleted_at', null)
            ->orderBy('firstname', $sort)
            ->paginate($size);

        foreach ($employees as $employee) {
            $employee->company->employees = [];
        }

        return $employees;
    }

    /* GET EMPLOYEE BY ID */
    public static function getEmployeeById($id) {
        $employee = Employee::with('user', 'company')->find($id);

        if (is_null($employee)) {
           return ErrorHelper::notFound('employee', $id);
        }
        
        if (isset($employee->company)) {
            $employee->company->employees = [];
        }

        if (!empty($employee)) {
            return $employee;
        }
        return null;
    }

    /* CREATE A NEW EMPLOYEE */
    public static function createEmployee(Request $req, $companyId) {
        $req->request->add([
            'role_id' => 3
        ]);

        $user = LogicUser::createUser($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        $employee = new Employee;

        $employee->user_id = $user->id;
        $employee->company_id = $companyId;
        $employee->firstname = $req->firstname;
        $employee->lastname = $req->lastname;
        $employee->created_at = date('Y-m-d H:i:s');
        $employee->updated_at = date('Y-m-d H:i:s');

        if ($employee->save()) {
            return $employee;
        }
        return null;
    }

    /* UPDATE EMPLOYEE BY ID*/
    public static function updateEmployeeById(Request $req, $id) {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            return ErrorHelper::notFound('employee', $id);
        }

        $user = LogicUser::updateUserById($req, $employee->user_id);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        return $employee;
    }

    /* DELETE EMPLOYEE BY ID */
    public static function deleteEmployeeById($id) {
        $employee = Employee::with('orders')->find($id);

        if (is_null($employee)) {
            return ErrorHelper::notFound('employee', $id);
        }

        $user = LogicUser::deleteUserById($employee->user_id);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        foreach ($employee->orders as $order) {
            $orders = LogicOrder::deleteOrderById($order->id);

            if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
                return $orders;
            }
        }

        return $employee;
    }
}