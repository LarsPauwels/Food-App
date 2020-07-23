<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 

use App\Order;
use App\Base_Order;
use App\Base_Order_Topping;

use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection as OrderCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

/* DELETE LATER */
use App\Http\Helpers\ReturnHelper;
use App\Http\Helpers\AuthorizationHelper;

class OrderController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/orders",
     *     tags={"Orders"},
     *     summary="Get all orders.",
     *     operationId="orders",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\Parameter(
     *         name="amount",
     *         description="Return amount in one page (min. 1 and max. 200).",
     *         in="query",
     *         required=false,
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
     * Get all orders api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
   	public function getOrders(Request $req) {
        $page = (int)$req->amount;

        if ($req->amount === null) {
            $page = 50;
        }

        if ($page <= 0 || $page > 200) {
            $message = 'The amount value needs to be minimal 1 or maximum 200.';
            return ErrorHelper::exceptions($message, 400);
        }

        $orders = Order::paginate($page);
        return $orders;

        if (count($orders)) {
            return new OrderCollection($orders);
        }

        return ErrorHelper::notFound('orders');
   	}

    /**
     * @OA\Post(
     *     path="/v1/orders",
     *     tags={"Orders"},
     *     summary="Create new order.",
     *     operationId="createOrder",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="employee_id", type="integer"),
     *             @OA\Property(property="supplier_id", type="integer"),
     *             @OA\Property(property="timesheet_id", type="integer")
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
     *     @OA\Response(
     *          response=400,
     *          description="Invalid request"
     *      ),
     * )
     *  
     * Create order api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function setOrder(Request $req) {
        $order = new Order;

        $order->employee_id = auth()->user()->id;
        $order->supplier_id = $req->supplier_id;
        $order->timesheet_id = $req->timesheet_id;
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date('Y-m-d H:i:s');

        if ($order->save()) {
            
            foreach ($req->bases as $base) {
                $base_id = $this->setBaseOrder($base, $order->id);

                foreach ($base['toppings'] as $topping) {
                    $this->setToppingOrder($topping, $base_id, $order->id);
                }
            }

            return new OrderResource($order);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    private function setBaseOrder($base, $id) {
        $base_order = new Base_Order;

        $base_order->order_id = $id;
        $base_order->base_id = $base['base_id'];
        $base_order->created_at = date('Y-m-d H:i:s');
        $base_order->updated_at = date('Y-m-d H:i:s');

        if ($base_order->save()) {
            return $base_order->id;
        }
        return false;
    }

    private function setToppingOrder($topping, $id, $order_id) {
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

    /**
     * @OA\Put(
     *     path="/v1/orders/{id}/delivered",
     *     tags={"Orders"},
     *     summary="Order is delivered.",
     *     operationId="orderDelivered",
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
     * Update delivered value api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deliverdOrder($id) {
        $order = Order::find($id);

        if ($order == null) {
           return ErrorHelper::notFound('order', $id);
        }

        if ($order->deliverd) {
            $message = 'This order is already delivered.';
            return ErrorHelper::exceptions($message, 500);
        }

        $order->deliverd = true;

        if ($order->save()) {
            return new OrderResource($order);
        }
    }

   	/**
     * @OA\Get(
     *     path="/v1/orders/{id}",
     *     tags={"Orders"},
     *     summary="Get order by id.",
     *     operationId="orderId",
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
     * Get order by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
   	public function getOrderById($id) {
   		$order = Order::find($id);

        if ($order == null) {
           return ErrorHelper::notFound('order', $id);
        }

        if (!empty($order)) {
            return new OrderResource($order);
        }
   	}

    /**
     * @OA\Get(
     *     path="/v1/orderes/{role}/{id}",
     *     tags={"Orders"},
     *     summary="Get order by role id.",
     *     operationId="roleOrder",
     *     security={{"bearerAuth":{}}},
     *     
     *     @OA\Parameter(
     *         name="role",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ), 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="filter",
     *         description="Filter by date when the order needs to be deliverd",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="today, yesterday, week, month, year" 
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
     * Get order by employee id
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getOrdersByUser($role, $id, Request $req) {
        date_default_timezone_set('Europe/Amsterdam');

        if ($req->filter == 'year' || empty($req->filter)) {
            $from = date('Y-m-d', strtotime(date('Y-01-01')));
            $to = date('Y-m-d', strtotime(date('Y-12-31')));
        } else if ($req->filter == 'month') {
            $from = date('Y-m-d', strtotime('first day of this '.$req->filter));
            $to = date('Y-m-d', strtotime('first day of +1 '.$req->filter));
        } else if ($req->filter == 'week') {
            $from = date('Y-m-d', strtotime('this '.$req->filter));
            $to = date('Y-m-d', strtotime('next '.$req->filter));
        } else {
            if (!strtotime($req->filter)) {
                $message = 'There was no result with the given filter.';
                return ErrorHelper::exceptions($message, 400);
            }
            $from = date('Y-m-d', strtotime($req->filter));
        }

        if (isset($to)) {
            $orders = Order::all()->where($role.'_id', $id)->whereBetween('timesheet.date', [$from, $to]);
        } else {
            $orders = Order::all()->where($role.'_id', $id)->where('timesheet.date', $from);
        }

        if (count($orders)) {
            return new OrderCollection($orders);
        }

        return ErrorHelper::notFound('order', $id, $role);
    }

    /**
     * @OA\Delete(
     *     path="/v1/orders/{id}",
     *     tags={"Orders"},
     *     summary="Delete order by id.",
     *     operationId="deleteOrder",
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
     * Delete order by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
   	public function deleteOrderById($id) {
        $order = \App\Order::select('employees.user_id AS employee_id', 'suppliers.user_id AS supplier_id')
                    ->where('orders.id', '=', $id)
                    ->join('employees', 'employees.id', 'employee_id')
                    ->join('suppliers', 'suppliers.id', 'supplier_id')
                    ->first();

        $authorizate = ['admin'];
        if (!AuthorizationHelper::checkId($order->employee_id, $authorizate) && !AuthorizationHelper::checkId($order->supplier_id, $authorizate)) {
            $message = "You are unauthorized to make this call.";
            return ReturnHelper::sendfail($message, 401);
        }

        $deleted = \App\Order::where('orders.id', '=', $id)
                        ->delete();

        if ($deleted) {
            $message = 'The order with id \''.$id.'\' is successfully deleted.';
            return ReturnHelper::sendSuccess($message, true);
        }

        $message = 'There was no order found with id \''.$id.'\'.';
        return ReturnHelper::sendfail($message, 404);
    }
}
