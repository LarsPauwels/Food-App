<?php
namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Employee;
use App\Supplier;

use App\Http\LogicControllers\SupplierController as LogicSupplier;
use App\Http\LogicControllers\OrderController as LogicOrder;

class ResourceHelper {
	
	/** 
     * Calculate the amount of orders by employee
     * 
     * @return Boolean 
     */ 
	public static function amountOrders($id) {
        $employee = Employee::where('id', $id)->withCount('orders')->first();
        if (!empty($employee)) {
            return $employee->orders_count;
        }
        return 0;
	}

    /** 
     * Calculate the average price of an employee
     * 
     * @return Boolean 
     */ 
    public static function averagePrice($id) {
        $employee = Employee::with('orders')->find($id);

        if (!empty($employee)) {
            $price = [];
            foreach ($employee->orders as $order) {
                array_push($price, $order->total_price);
            }

            if(count($price)) {
                return array_sum($price)/count($price);
            }
            return 0;
        }
        return 0;
    }

    /** 
     * Check if supplier is locked
     * 
     * @return Boolean 
     */ 
    public static function locked($id) {
        $supplier = Supplier::find($id);

        if ($supplier->locked == 1) {
            return true;
        }
        return false;
    }

    /** 
     * Get revenue of supplier
     * 
     * @return Integer 
     */ 
    public static function revenue($id) {
        $req = new Request([
            'date' => 'month'
        ]);
        $revenue = LogicSupplier::getSupplierRevenue($req, $id);
        
        if (is_a($revenue, 'Illuminate\Http\JsonResponse')) {
            return $revenue;
        }
        return $revenue;
    }

    /** 
     * Get profit of company
     * 
     * @return Integer 
     */ 
    public static function companyProfit($id, $date = 'today') {
        $req = new Request([
            'date' => $date
        ]);
        $orders = LogicOrder::getRoleOrder($req, $id, 'company');
        
        if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
            return $orders;
        }

        $price = 0;
        foreach ($orders as $order) {
            $price += $order->total_price;
        }
        return $price;
    }

    /** 
     * Get profit of employee
     * 
     * @return Integer 
     */ 
    public static function employeeProfit($id, $date = 'today') {
        $req = new Request([
            'date' => $date
        ]);
        $orders = LogicOrder::getRoleOrder($req, $id, 'employee');
        
        if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
            return $orders;
        }

        $price = 0;
        foreach ($orders as $order) {
            $price += $order->total_price;
        }
        return $price;
    }
}