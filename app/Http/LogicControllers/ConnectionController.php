<?php

namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Supplier;
use App\Company;
use App\Company_Supplier;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;
use App\Http\Helpers\ResourceHelper;

use App\Http\LogicControllers\TimesheetController as LogicTimesheet;
use App\Http\LogicControllers\BaseController as LogicBase;

class ConnectionController {
    /* GET ALL SUPPLIERS BY COMPANY */
    public static function getSuppliers(Request $req, $companyId) {
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

        $suppliers = Supplier::select('suppliers.*', 'company_supplier.status as status')
            ->with('timesheets')
            ->join('details', 'details.id', '=', 'suppliers.detail_id')
            ->join('company_supplier', 'suppliers.id', '=', 'company_supplier.supplier_id')
            ->where('company_id', $companyId)
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

        if (!is_null($suppliers)) {
            return $suppliers;
        }
        return null;
    }

    /* GET ALL COMPANIES BY EMPLOYEE */
    public static function getCompanies(Request $req, $supplierId) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $orderBy = strtolower($req->orderBy);
        $date = strtolower($req->date);
        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);
        $employees = filter_var($req->employees, FILTER_VALIDATE_BOOLEAN);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        if (is_null($req->orderBy)) {
            $orderBy = 'name';
        }

        if (is_null($req->date)) {
            $date = 'today';
        }

        if ($orderBy == 'date') {
            $size = 3;
        }

        $companies = Company::select('companies.*')
            ->with('timesheets')
            ->join('details', 'companies.detail_id', '=', 'details.id')
            ->Join('company_supplier', 'companies.id', '=', 'company_supplier.company_id')
            ->where('company_supplier.supplier_id', $supplierId)
            ->whereHas('user', function ($query) {
                return $query->where('deleted_at', null);
            })
            ->where('details.name', 'LIKE', "%".$search."%")
            ->orderBy('details.name', $sort)
            ->paginate($size);

        if (!$employees || empty($employees)) {
            foreach ($companies as $company) {
                $company->employees = [];
            }
        }

        foreach ($companies as $key => $company) {
            $companies[$key]->profit = ResourceHelper::companyProfit($company->id, $req->date);

            foreach ($company->employees as $key => $employee) {
                $company->employees[$key]->profit = ResourceHelper::employeeProfit($employee->id, $req->date);
            }
        }

        if (!is_null($companies)) {
            if ($orderBy == 'name') {
                return $companies;
            }

            return $companies->setCollection(
                collect(
                    collect($companies->items())->sortByDesc('profit')
                )->values()
            );
        }
        return null;
    }

    /* SEND REQUEST TO COMPANY */ 
    public static function createConnection(Request $req, $id) {
        $company = Company::whereHas('user', function($q) use($req) {
                   $q->where('email', $req->email);
                })->first();  

        $companySupplier = new Company_Supplier;

        $companySupplier->company_id = $company->id;
        $companySupplier->supplier_id = $id;
        $companySupplier->status = 1;
        $companySupplier->created_at = date('Y-m-d H:i:s');
        $companySupplier->updated_at = date('Y-m-d H:i:s');

        if ($companySupplier->save()) {
            $timesheets = LogicTimesheet::createTimesheets($company->id, $id);

            if (is_a($timesheets, 'Illuminate\Http\JsonResponse')) {
                return $timesheets;
            }

            return $company;
        }
    }

    /* UPDATE SUPPLIER COMPANY CONNECTION */ 
    public static function updateConnection($id, $companyId) {
        $supplier = Company_Supplier::where('company_id', $companyId)
            ->where('supplier_id', $id)
            ->first();
        
        if (is_null($supplier)) {
           return ErrorHelper::notFound('supplier', $id);
        }

        $supplier->status = 0;
        $supplier->updated_at = date('Y-m-d H:i:s');

        if ($supplier->save()) {
            $supplier = Supplier::find($id);
            return $supplier;
        }
        return null;
    }

    /* DELETE SUPPLIER COMPANY CONNECTION */ 
    public static function deleteConnection($id, $companyId) {
        $supplier = Company_Supplier::where('company_id', $companyId)
            ->where('supplier_id', $id)
            ->first();
        
        if (is_null($supplier)) {
           return ErrorHelper::notFound('supplier', $id);
        }

        $timesheet = LogicTimesheet::deleteTimesheets($companyId, $id);

        if (is_a($timesheet, 'Illuminate\Http\JsonResponse')) {
            return $timesheet;
        }

        if ($supplier->delete()) {
            $supplier = Supplier::find($id);
            return $supplier;
        }
        return null;
    }
}
