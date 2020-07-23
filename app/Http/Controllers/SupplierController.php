<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Route;

use App\Supplier;

use App\Http\Resources\Supplier as SupplierResource;
use App\Http\Resources\SupplierCollection as SupplierCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

class SupplierController extends Controller {
    /**
     * @OA\Get(
     *     path="/v1/suppliers",
     *     tags={"Suppliers"},
     *     summary="Get all suppliers with/without timesheet.",
     *     operationId="supplier",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="timesheet",
     *         description="Disable/Enable the timesheet return.",
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
     * Get all suppliers api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getSuppliers(Request $req) {
        $suppliers = Supplier::has('user')->get();

        if ($req->timesheet === 'false' || empty($req->timesheet)) {
            foreach ($suppliers as $supplier) {
                $supplier->timesheets = [];
            }
        }

        if (count($suppliers)) {
            return new SupplierCollection($suppliers);
        }

        return ErrorHelper::notFound('suppliers');
    }

    /**
     * @OA\Get(
     *     path="/v1/suppliers/{id}",
     *     tags={"Suppliers"},
     *     summary="Get supplier by id with/without timesheet.",
     *     operationId="supplierId",
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
     *         name="timesheet",
     *         description="Disable/Enable the timesheet return.",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="true/false" 
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
     * Get supplier by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getSupplierById($id, Request $req) {
        $supplier = Supplier::has('user')->find($id);

        if ($req->timesheet === 'false' || empty($req->timesheet)) {
            $supplier->timesheets = [];
        }

        if ($supplier == null) {
           return ErrorHelper::notFound('supplier', $id);
        }

        if (!empty($supplier)) {
            return new SupplierResource($supplier);
        }
    }

    /**
     * @OA\Delete(
     *     path="/v1/suppliers/{id}",
     *     tags={"Suppliers"},
     *     summary="Delete supplier by id.",
     *     operationId="deleteSupplier",
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
     * Delete supplier by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteSupplierById($id, Request $req) {
        $supplier = Supplier::with(['user' => function ($q) {
            $q->withTrashed();
        }])->find($id);

        if ($supplier == null) {
            return ErrorHelper::notFound('supplier', $id);
        }

        $userId = $supplier->user_id;
        $token = $req->bearerToken();

        $request = Request::create('/api/v1/users/'.$userId, 'DELETE');
        $request->headers->set('Authorization', 'Bearer '.$token);

        if (Route::dispatch($request)) {
            return new SupplierResource($supplier);
        }
    }

    private function dataFormat($supplier, $tBoolean) {
        $data = [
            'user' => [
                'user_id' => $supplier[0]->user_id,
                'supplier_id' => $supplier[0]->id,
                'name' => $supplier[0]->name,
                'email' => $supplier[0]->email,
                'phone' => $supplier[0]->phone,
                'created_at' => $supplier[0]->created_at,
                'timesheets' => [

                ]
            ]
        ];

        if ($tBoolean === "false") {
            return $data;
        }

        foreach ($supplier as $timesheet) {
        	if (!$timesheet->timesheet_id) {
        		return $data;
        	}

        	array_push($data['user']['timesheets'], [
        		'timesheet_id' => $timesheet->timesheet_id,
        		'date' => $timesheet->date,
        		'time' => $timesheet->time
        	]);
        }

        return $data;
    }
}
