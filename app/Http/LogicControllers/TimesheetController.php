<?php

namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Timesheet;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class TimesheetController {
    /* CREATE MULTIPLE TIMESHEETS*/
    public static function createTimesheets($companyId, $supplierId) {
        $days = array('Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday', 'Sunday');

        $timesheets = [];
        for ($i=0; $i < 7; $i++) { 
            $timesheet = new Timesheet;

            $timesheet->company_id = $companyId;
            $timesheet->supplier_id = $supplierId;
            $timesheet->day = $days[$i];
            $timesheet->from = null;
            $timesheet->until = null;
            $timesheet->active = false;
            $timesheet->created_at = date('Y-m-d H:i:s');
            $timesheet->updated_at = date('Y-m-d H:i:s');

            if ($timesheet->save()) {
                array_push($timesheets, $timesheet);
            }
        }

        return $timesheets;
    }

    /* UPDATE TIMESHEET BY ID */
    public static function updateTimesheetById(Request $req, $id) {
        $validation = ValidationHelper::timesheet($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $timesheet = Timesheet::find($id);

        if (is_null($timesheet)) {
           return ErrorHelper::notFound('timesheet', $id);
        }

        $timesheet->active = $req->active;
        $timesheet->day = $req->day;
        $timesheet->from = $req->from;
        $timesheet->until = $req->until;
        $timesheet->updated_at = date('Y-m-d H:i:s');

        if ($timesheet->save()) {
            return $timesheet;
        }
        return null;
    }

    /* DELETE TIMESHEET BY ID*/
    public static function deleteTimesheetById($id) {
        $timesheet = Timesheet::find($id);

        if (is_null($timesheet)) {
           return ErrorHelper::notFound('timesheet', $id);
        }

        if ($timesheet->delete()) {
            return $timesheet;
        }
        return null;
    }

    /* DELETE MULTIPLE TIMESHEETS*/
    public static function deleteTimesheets($companyId, $supplierId) {
        $timesheets = Timesheet::where('supplier_id', $supplierId)
            ->where('company_id', $companyId)
            ->delete();

        if (is_null($timesheets)) {
           return ErrorHelper::notFound('timesheet', $companyId);
        }

        return $timesheets;
    }
}
