<?php

namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Supplier;
use App\User_Supplier;
use App\Company_Supplier;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\BaseController as LogicBase;
use App\Http\LogicControllers\UserController as LogicUser;
use App\Http\LogicControllers\DetailController as LogicDetail;
use App\Http\LogicControllers\OrderController as LogicOrder;

class SupplierController {
    /* GET ALL SUPPLIERS */
    public static function getSuppliers(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);
        $timesheet = filter_var($req->timesheet, FILTER_VALIDATE_BOOLEAN);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        $suppliers = Supplier::select('suppliers.*')
            ->join('details', 'details.id', '=', 'suppliers.detail_id')
            ->where('details.name', 'LIKE', "%".$search."%")
            ->whereHas('user', function ($query) {
                return $query->where('deleted_at', null);
            })
            ->orWhere('locked', true)
            ->orderBy('locked', 'asc')
            ->orderBy('details.name', $sort)
            ->paginate($size);

        if (!$timesheet || empty($timesheet)) {
            foreach ($suppliers as $supplier) {
                $supplier->timesheets = [];
            }
        }

        foreach ($suppliers as $key => $supplier) {
            $bases = LogicBase::getAllBasesBySupplier($req, $supplier->id);

            if (is_a($bases, 'Illuminate\Http\JsonResponse')) {
                return $bases;
            }

            $suppliers[$key]->bases = $bases;
        }

        if (count($suppliers)) {
            return $suppliers;
        }
        return null;
    }

    /* GET SUPPLIER BY ID */ 
    public static function getSupplierById(Request $req, $id) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $timesheet = filter_var($req->timesheet, FILTER_VALIDATE_BOOLEAN);

        $supplier = Supplier::has('user')->find($id);

        if (is_null($supplier)) {
           return ErrorHelper::notFound('supplier', $id);
        }

        if (!$timesheet || empty($timesheet)) {
            $supplier->timesheets = [];
        }

        $bases = LogicBase::getAllBasesBySupplier($req, $id);

        if (is_a($bases, 'Illuminate\Http\JsonResponse')) {
            return $bases;
        }

        $supplier->bases = $bases;

        if (!empty($supplier)) {
            return $supplier;
        }
        return null;
    }

    /* GET SUPPLIER REVENUE */
    public static function getSupplierRevenue(Request $req, $id) {
        $orders = LogicOrder::getRoleOrder($req, $id, 'supplier');
        
        if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
            return $orders;
        }

        $price = 0;
        foreach ($orders as $order) {
            $price += $order->total_price;
        }

        return $price;
    }

    /* CREATE A NEW SUPPLIER */
    public static function createSupplier(Request $req) {
        $req->request->add([
            'role_id' => 4
        ]);

        $user = LogicUser::createUser($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        $detail = LogicDetail::createDetail($req);

        if (is_a($detail, 'Illuminate\Http\JsonResponse')) {
            return $detail;
        }

        $supplier = new Supplier;

        $supplier->detail_id = $detail->id;
        $supplier->locked = 0;
        $supplier->created_at = date('Y-m-d H:i:s');
        $supplier->updated_at = date('Y-m-d H:i:s');

        if ($supplier->save()) {
            $userSupplier = new User_Supplier;

            $userSupplier->user_id = $user->id;
            $userSupplier->supplier_id = $supplier->id;
            $userSupplier->created_at = date('Y-m-d H:i:s');
            $userSupplier->updated_at = date('Y-m-d H:i:s');
            
            if ($userSupplier->save()) {
                return $supplier;
            }
            return null;
        }
        return null;
    }

    /* UPDATE SUPPLIER BY ID */
    public static function updateSupplierById(Request $req, $id) {
        $validation = ValidationHelper::supplier($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $supplier = Supplier::with('user')->find($id);

        if (is_null($supplier)) {
           return ErrorHelper::notFound('supplier', $id);
        }

        $detail = LogicDetail::updateDetailById($req, $supplier->detail_id);

        if (is_a($detail, 'Illuminate\Http\JsonResponse')) {
            return $detail;
        }

        if ($req->locked) {
            foreach ($supplier->user as $user) {
                $user = LogicUser::deleteUserById($user->id);

                if (is_a($user, 'Illuminate\Http\JsonResponse')) {
                    return $user;
                }
            }

            $supplier->locked = true;
        } else {
            foreach ($supplier->user as $user) {
                $user = LogicUser::restoreUserById($user->id);

                if (is_a($user, 'Illuminate\Http\JsonResponse')) {
                    return $user;
                }
            }

            $supplier->locked = false;
        }

        if ($supplier->save()) {
            return $supplier;
        }
        return null;
    }

    /* DELETE SUPPLIER BY ID */ 
    public static function deleteSupplierById($id) {
        $supplier = Supplier::with('orders', 'user')->find($id);
        
        if (is_null($supplier)) {
           return ErrorHelper::notFound('supplier', $id);
        }

        foreach ($supplier->user as $user) {
            $user = LogicUser::deleteUserById($user->id);

            if (is_a($user, 'Illuminate\Http\JsonResponse')) {
                return $user;
            }
        }

        foreach ($supplier->orders as $order) {
            $orders = LogicOrder::deleteOrderById($order->id);

            if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
                return $orders;
            }
        }

        $supplier->locked = false;

        if ($supplier->save()) {
            return $supplier;
        }
        return null;
    }
}
