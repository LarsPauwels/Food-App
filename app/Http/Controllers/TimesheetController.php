<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Timesheet as TimesheetResource;
use App\Http\Resources\TimesheetCollection as TimesheetCollection;

use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\TimesheetController as LogicTimesheet;

class TimesheetController extends Controller {
    /**
     * @OA\Put(
     *     path="/v1/timesheet/{id}",
     *     tags={"Timesheets"},
     *     summary="Update a timesheet.",
     *     operationId="timesheetUpdate",
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
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="day", type="string"),
     *             @OA\Property(property="from", type="string"),
     *             @OA\Property(property="until", type="string"),
     *             @OA\Property(property="active", type="string"),
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
     * Update a timesheet api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateTimesheetById(Request $req, $id) {
        $timesheet = LogicTimesheet::updateTimesheetById($req, $id);

        if (is_a($timesheet, 'Illuminate\Http\JsonResponse')) {
            return $timesheet;
        }

        if (!is_null($timesheet)) {
            return new TimesheetResource($timesheet);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Post(
     *     path="/v1/timesheets",
     *     tags={"Timesheets"},
     *     summary="Create Multiple timesheet.",
     *     operationId="timesheetCreate",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\Parameter(
     *         name="companyId",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="supplierId",
     *         in="query",
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
     * Create multiple timesheet api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function createTimesheets(Request $req) {
        $timesheets = LogicTimesheet::createTimesheets($req->companyId, $req->supplierId);

        if (is_a($timesheets, 'Illuminate\Http\JsonResponse')) {
            return $timesheets;
        }

        if (count($timesheets)) {
            return new TimesheetCollection($timesheets);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Put(
     *     path="/v1/timesheets",
     *     tags={"Timesheets"},
     *     summary="Update multiple timesheet.",
     *     operationId="TimesheetsUpdate",
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
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="timesheets",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="day", type="string"),
     *                     @OA\Property(property="from", type="string"),
     *                     @OA\Property(property="until", type="string"),
     *                     @OA\Property(property="active", type="string"),
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
     * )
     *  
     * Update multiple timesheet api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updateTimesheets(Request $req) {
        $timesheets = [];
        foreach ($req->timesheets as $timesheet) {
            $timesheet = LogicTimesheet::updateTimesheetById(new Request($timesheet), $timesheet['id']);

            if (is_a($timesheet, 'Illuminate\Http\JsonResponse')) {
                return $timesheet;
            }

            array_push($timesheets, $timesheet);
        }

        if (!is_null($timesheets)) {
            return new TimesheetCollection($timesheets);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/timesheet/{id}",
     *     tags={"Timesheets"},
     *     summary="Delete timesheet by id.",
     *     operationId="TimesheetDelete",
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
     * Delete timesheet by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteTimesheetById() {
        $timesheet = LogicTimesheet::deleteTimesheetById($id);

        if (is_a($timesheet, 'Illuminate\Http\JsonResponse')) {
            return $timesheet;
        }

        if (!is_null($timesheet)) {
            return new TimesheetResource($timesheet);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }

    /**
     * @OA\Delete(
     *     path="/v1/timesheets",
     *     tags={"Timesheets"},
     *     summary="Delete multiple timesheets.",
     *     operationId="TimesheetsDelete",
     *     security={{"bearerAuth":{}}},
     *      
     *     @OA\Parameter(
     *         name="supplierId",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="companyId",
     *         in="query",
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
     * Delete timesheet by id api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function deleteTimesheets(Request $req) {
        $timesheet = LogicTimesheet::deleteTimesheets($req->companyId, $req->supplierId);

        if (is_a($timesheet, 'Illuminate\Http\JsonResponse')) {
            return $timesheet;
        }

        if (!is_null($timesheet)) {
            return new TimesheetCollection($timesheet);
        }

        $message = 'Something went wrong! Try again later.';
        return ErrorHelper::exceptions($message, 500);
    }
}