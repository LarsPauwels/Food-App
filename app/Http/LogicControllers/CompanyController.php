<?php

namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Company;
use App\User_Company;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\UserController as LogicUser;
use App\Http\LogicControllers\DetailController as LogicDetail;

class CompanyController {
   	
    /* GET ALL COMPANIES */
   	public static function getCompanies(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

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

        $companies = Company::select('companies.*')
            ->join('details', 'companies.detail_id', '=', 'details.id')
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

        if (count($companies)) {
            return $companies;
        }
        return null;
   	}

   	/* GET COMPANY BY ID */
   	public static function getCompanyById(Request $req, $id) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $employees = filter_var($req->employees, FILTER_VALIDATE_BOOLEAN);

        $company = Company::has('user')->find($id);

        if (is_null($company)) {
           return ErrorHelper::notFound('company', $id);
        }

        if (!$employees || empty($employees)) {
            $company->employees = [];
        }

        if (!empty($company)) {
            return $company;
        }
        return null;
    }

    /* CREATE A NEW COMPANY */
    public static function createCompany(Request $req) {
        $req->request->add([
            'role_id' => 2
        ]);

        $user = LogicUser::createUser($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        $detail = LogicDetail::createDetail($req);

        if (is_a($detail, 'Illuminate\Http\JsonResponse')) {
            return $detail;
        }

        $company = new Company;

        $company->detail_id = $detail->id;
        $company->created_at = date('Y-m-d H:i:s');
        $company->updated_at = date('Y-m-d H:i:s');

        if ($company->save()) {
            $userCompany = new User_Company;

            $userCompany->user_id = $user->id;
            $userCompany->company_id = $company->id;
            $userCompany->created_at = date('Y-m-d H:i:s');
            $userCompany->updated_at = date('Y-m-d H:i:s');

            if ($userCompany->save()) {
                return $company;
            }
            return null;
        }
        return null;
    }

    /* UPDATE COMPANY BY ID */
    public static function updateCompanyById(Request $req, $id) {
        $company = Company::find($id);

        if (is_null($company)) {
           return ErrorHelper::notFound('company', $id);
        }

        $detail = LogicDetail::updateDetailById($req, $company->detail_id);

        if (is_a($detail, 'Illuminate\Http\JsonResponse')) {
            return $detail;
        }

        return $company;
    }

    /* DELETE COMPANY BY ID */ 
    public static function deleteCompanyById($id) {
        $company = Company::with('user')->find($id);
        
        if (is_null($company)) {
           return ErrorHelper::notFound('company', $id);
        }

        foreach ($company->user as $user) {
            $user = LogicUser::deleteUserById($user->id);

            if (is_a($user, 'Illuminate\Http\JsonResponse')) {
                return $user;
            }
        }
        
        return $company;
    }
}
