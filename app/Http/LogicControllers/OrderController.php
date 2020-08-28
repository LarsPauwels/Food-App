<?php

namespace App\Http\LogicControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Employee;
use App\Supplier;
use App\Company;
use App\Order;
use App\Base;
use App\Topping;
use App\Base_Order;
use App\Base_Order_Topping;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\OrderController as LogicOrder;

class OrderController {

    /* GET ALL ORDERS */
   	public static function getOrders(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);
        $delivered = filter_var($req->delivered, FILTER_VALIDATE_BOOLEAN);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        if (is_null($delivered)) {
            $delivered = false;
        }

        if ($delivered === true) {
            return Order::with('employee', 'supplier')
                ->where('delivered', 1)
                ->where('created_at', 'LIKE', "%".$search."%")
                ->orderBy('created_at', $sort)
                ->paginate($size);
        } else if ($delivered === false) {
            return Order::with('employee', 'supplier')
                ->where('delivered', 0)
                ->where('created_at', 'LIKE', "%".$search."%")
                ->orderBy('created_at', $sort)
                ->paginate($size);
            return Order::with('employee', 'supplier')
                ->where('created_at', 'LIKE', "%".$search."%")
                ->orderBy('created_at', $sort)
                ->paginate($size);
        }
   	}

    /* GET ALL ORDERS BY SUPPLIER */
    public static function getOrdersBySupplier(Request $req, $supplierId) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);
        $delivered = filter_var($req->delivered, FILTER_VALIDATE_BOOLEAN);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        if (is_null($delivered)) {
            $delivered = false;
        }

        $orders = Supplier::join('orders', 'orders.supplier_id', '=', 'suppliers.id')
            ->where('suppliers.id', $supplierId)
            ->paginate($size);

        $orders = $orders->groupBy('delivery_date')->values()->all();

        return $orders;

        // if ($delivered === true) {
        //     return Supplier::select('delivery_date, suppliers.*, orders.*')
        //         ->join('orders', 'orders.supplier_id', '=', 'suppliers.id')
        //         ->where('suppliers.id', $supplierId)
        //         ->where('delivered', 1)
        //         ->where('delivery_date', 'LIKE', "%".$search."%")
        //         ->groupBy('delivery_date')
        //         ->orderBy('delivery_date', $sort)
        //         ->paginate($size);
        // } else if ($delivered === false) {
        //     return Supplier::select('delivery_date, suppliers.*, orders.*')
        //         ->join('orders', 'orders.supplier_id', '=', 'suppliers.id')
        //         ->where('suppliers.id', $supplierId)
        //         ->where('delivered', 0)
        //         ->where('delivery_date', 'LIKE', "%".$search."%")
        //         ->groupBy('delivery_date')
        //         ->orderBy('delivery_date', $sort)
        //         ->paginate($size);
        //     return Supplier::select('delivery_date, suppliers.*, orders.*')
        //         ->join('orders', 'orders.supplier_id', '=', 'suppliers.id')
        //         ->where('suppliers.id', $supplierId)
        //         ->where('delivery_date', 'LIKE', "%".$search."%")
        //         ->groupBy('delivery_date')
        //         ->orderBy('delivery_date', $sort)
        //         ->paginate($size);
        // }
    }

    /* GET ALL ORDERS BY ROLE NAME */
    public static function getOrderByRole(Request $req, $roleId, $role) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);
        $delivered = filter_var($req->delivered, FILTER_VALIDATE_BOOLEAN);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        if (is_null($delivered)) {
            $delivered = false;
        }

        if ($delivered === true) {
            return Order::
                where($role.'_id', $roleId)
                ->where('delivered', 1)
                ->where('delivery_date', 'LIKE', "%".$search."%")
                ->orderBy('delivery_date', $sort)
                ->paginate($size);
        } else if ($delivered === false) {
            return Order::
                where($role.'_id', $roleId)
                ->where('delivered', 0)
                ->where('delivery_date', 'LIKE', "%".$search."%")
                ->orderBy('delivery_date', $sort)
                ->paginate($size);
            return Order::
                where($role.'_id', $roleId)
                ->where('delivery_date', 'LIKE', "%".$search."%")
                ->orderBy('delivery_date', $sort)
                ->paginate($size);
        }
    }

    /* GET ORDER BY ID */ 
    public static function getOrderById($id) {
        $order = Order::find($id);

        if (is_null($order)) {
           return ErrorHelper::notFound('order', $id);
        }

        if (!empty($order)) {
            return $order;
        }
        return null;
    }

    /* GET ALL THE ORDERS BY ROLE */ 
    public static function getRoleOrder(Request $req, $id, $role) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $date = strtolower($req->date);

        if (empty($date)) {
            $date = "today";
        }

        $now = Carbon::now();
        switch ($date) {
            case 'today':
                $start = $now->format('Y-m-d 00:00:00');
                $end = $now->format('Y-m-d 23:59:59');
                break;
            case 'week':
                $start = $now->startOfWeek()->format('Y-m-d H:i:s');
                $end = $now->endOfWeek()->format('Y-m-d H:i:s');
                break;
            case 'month':
                $start = $now->startOfMonth()->format('Y-m-d H:i:s');
                $end = $now->endOfMonth()->format('Y-m-d H:i:s');
                break;
            case 'year':
                $start = $now->startOfYear()->format('Y-m-d H:i:s');
                $end = $now->endOfYear()->format('Y-m-d H:i:s');
                break;
        }

        return Order::where($role.'_id', $id)
            ->whereDate('created_at','<=', $end)
            ->whereDate('created_at','>=', $start)
            ->get();
    }

    /* CREAT A NEW ORDER */ 
    public static function createOrder(Request $req) {
        $validation = ValidationHelper::order($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $order = new Order;

        if (auth()->user()->role_id == 3) {
            $employee = Employee::where('user_id', auth()->user()->id)->first();

            if (is_null($employee)) {
                $message = 'You need to be an employee to create an order.';
                return ErrorHelper::exceptions($message, 500);
            }

            $order->employee_id = $employee->id;
            $order->company_id = $employee->company_id;

        } else if (auth()->user()->role_id == 2) {
            $userId = auth()->user()->id;
            $company = Company::whereHas('user', function($q) use($userId) {
                $q->where('users.id', $userId);
            })->first();

            if (is_null($company)) {
                $message = 'You need to be an company to create an order.';
                return ErrorHelper::exceptions($message, 500);
            }

            $order->employee_id = null;
            $order->company_id = $company->id;
        }

        $order->supplier_id = $req->supplier_id;
        $order->timesheet_id = $req->timesheet_id;
        $order->delivery_date = $req->delivery_date;
        $order->delivered = 0;
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date('Y-m-d H:i:s');

        if (!isset($req->products)) {
            $message = 'There were no products selected.';
            return ErrorHelper::exceptions($message, 500);
        }

        $order->save();

        $price = 0;
        foreach ($req->products as $key => $baseArray) {
            $base = Base::find($baseArray['id']);

            if (is_null($base)) {
               return ErrorHelper::notFound('base', $baseArray['id']);
            }

            $order->bases[$key] = $base;

            $price += $base->price;

            $base_id = LogicOrder::createBaseOrder($baseArray, $order->id);

            if (isset($baseArray['toppings'])) {
                foreach ($baseArray['toppings'] as $k => $t) {
                    $topping = Topping::find($t['id']);

                    if (is_null($topping)) {
                       return ErrorHelper::notFound('topping',$t['id']);
                    }

                    $order->bases[$key]->toppings[$k] = $topping;

                    $price += $topping->price;

                    LogicOrder::createToppingOrder($t['id'], $base_id, $order->id);
                }
            } else {
                $order->bases[$key]->toppings = [];
            }
        }

        $order->total_price = $price;
        if ($order->save()) {
            return $order;
        }
        return null;
    }

    private static function createBaseOrder($base, $id) {
        $base_order = new Base_Order;

        $base_order->order_id = $id;
        $base_order->base_id = $base['id'];
        $base_order->created_at = date('Y-m-d H:i:s');
        $base_order->updated_at = date('Y-m-d H:i:s');

        if ($base_order->save()) {
            return $base_order->id;
        }
        return false;
    }

    private static function createToppingOrder($topping, $id, $order_id) {
        $topping_order = new Base_Order_Topping;

        $topping_order->base_order_id = $id;
        $topping_order->topping_id = $topping;
        $topping_order->order_id = $order_id;
        $topping_order->created_at = date('Y-m-d H:i:s');
        $topping_order->updated_at = date('Y-m-d H:i:s');

        if ($topping_order->save()) {
            return  true;
        }
        return false;
    }

    /* UPDATE ORDER TO DELIVERED */ 
    public static function deliverdOrder($id) {
        $order = Order::find($id);

        if (is_null($order)) {
           return ErrorHelper::notFound('order', $id);
        }

        if ($order->delivered) {
            $message = 'This order is already delivered.';
            return ErrorHelper::exceptions($message, 500);
        }

        $order->delivered = true;

        if ($order->save()) {
            return $order;
        }
        return null;
    }

    /* DELETE ORDER BY ID */ 
   	public static function deleteOrderById($id) {
        $order = Order::find($id);

        if (is_null($order)) {
           return ErrorHelper::notFound('order', $id);
        }

        if ($order->delete()) {
            return $order;
        }
        return null;
    }
}
