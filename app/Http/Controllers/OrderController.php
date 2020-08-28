<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderRoleCollection as OrderRoleCollection;
use App\Http\Resources\OrderSupplierCollection as OrderSupplierCollection;
use App\Http\Resources\OrderCollection as OrderCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\OrderController as LogicOrder;

class OrderController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/order/list",
     *     tags={"Orders"},
     *     summary="Get all orders.",
     *     operationId="orders",
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
     *         name="delivered",
     *         description="Return only undelivered/delivered orders.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="true, false, all" 
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
        $orders = LogicOrder::getOrders($req);

        if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
            return $orders;
        }

        if (count($orders)) {
            return new OrderCollection($orders);
        }

        return ErrorHelper::notFound('orders');
   	}

    /**
     * @OA\Get(
     *     path="/v1/supplier/{supplierId}/order/list",
     *     tags={"Orders"},
     *     summary="Get all orders by supplier.",
     *     operationId="ordersSupplier",
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
     *         name="delivered",
     *         description="Return only undelivered/delivered orders.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="true, false, all" 
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
     * Get all orders by supplier api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getOrdersBySupplier(Request $req, $supplierId) {
        $orders = LogicOrder::getOrdersBySupplier($req, $supplierId);

        if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
            return $orders;
        }

        if (count($orders)) {
            return new OrderSupplierCollection($orders);
        }

        return ErrorHelper::notFound('orders');
    }

    /**
     * @OA\Get(
     *     path="/v1/employee/{employeeId}/order/list",
     *     tags={"Orders"},
     *     summary="Get all orders by employee.",
     *     operationId="ordersEmployee",
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
     *         name="delivered",
     *         description="Return only undelivered/delivered orders.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="true, false, all" 
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
     * Get all orders by employee api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getOrdersByEmployee(Request $req, $employeeId) {
        $orders = LogicOrder::getOrderByRole($req, $employeeId, 'employee');

        if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
            return $orders;
        }

        if (count($orders)) {
            return new OrderRoleCollection($orders);
        }

        return ErrorHelper::notFound('orders');
    }

    /**
     * @OA\Get(
     *     path="/v1/company/{companyId}/order/list",
     *     tags={"Orders"},
     *     summary="Get all orders by employee.",
     *     operationId="ordersEmployee",
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
     *         name="delivered",
     *         description="Return only undelivered/delivered orders.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="true, false, all" 
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
     * Get all orders by employee api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getOrdersByCompany(Request $req, $companyId) {
        $orders = LogicOrder::getOrderByRole($req, $companyId, 'company');

        if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
            return $orders;
        }

        if (count($orders)) {
            return new OrderRoleCollection($orders);
        }

        return ErrorHelper::notFound('orders');
    }

    /**
     * @OA\Get(
     *     path="/v1/order/{id}",
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
        $order = LogicOrder::getOrderById($id);

        if (is_a($order, 'Illuminate\Http\JsonResponse')) {
            return $order;
        }

        if (!is_null($order)) {
            return new OrderResource($order);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Get(
     *     path="/v1/supplier/{id}/order",
     *     tags={"Orders"},
     *     summary="Get suppliers orders.",
     *     operationId="orderSupplier",
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
     *         name="date",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="today/week/month/year" 
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
     * Get suppliers orders api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getSupplierOrder(Request $req, $id) {
        $orders = LogicOrder::getSupplierOrder($req, $id, 'supplier');

        if (is_a($orders, 'Illuminate\Http\JsonResponse')) {
            return $orders;
        }

        if (count($orders)) {
            return new OrderCollection($orders);
        }

        return ErrorHelper::notFound('orders');
    }

    /**
     * @OA\Post(
     *     path="/v1/order",
     *     tags={"Orders"},
     *     summary="Create new order.",
     *     operationId="createOrder",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="timesheet_id", type="integer"),
     *             @OA\Property(
     *                 property="bases",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="base_id", type="integer"),
     *                     @OA\Property(
     *                         property="toppings",
     *                         type="array",
     *                         @OA\Items(
     *                             type="integer"
     *                         ),
     *                     )
     *                 ),
     *             )
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
    public function createOrder(Request $req) {
        $order = LogicOrder::createOrder($req);

        if (is_a($order, 'Illuminate\Http\JsonResponse')) {
            return $order;
        }

        if (!is_null($order)) {
            return new OrderResource($order);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/order/{id}/delivered",
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
        $order = LogicOrder::deliverdOrder($id);

        if (is_a($order, 'Illuminate\Http\JsonResponse')) {
            return $order;
        }

        if (!is_null($order)) {
            return new OrderResource($order);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/order/{id}",
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
        $order = LogicOrder::deleteOrderById($id);

        if (is_a($order, 'Illuminate\Http\JsonResponse')) {
            return $order;
        }

        if (!is_null($order)) {
            return new OrderResource($order);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}
