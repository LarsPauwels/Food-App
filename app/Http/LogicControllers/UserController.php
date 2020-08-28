<?php
namespace App\Http\LogicControllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Gate;
use Hash;

use App\User;
use App\Employee;
use App\Supplier;
use App\User_Company;
use App\User_Supplier;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection as UserCollection;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\UserController as LogicUser;

class UserController {

    /* GET ALL USERS */
    public static function getUsers(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);
        $active = filter_var($req->active, FILTER_VALIDATE_BOOLEAN);

        if (is_null($active)) {
            $active = true;
        }

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        if ($active) {
            return User::with('supplier', 'company', 'employee')
                ->where('email', 'LIKE', "%".$search."%")
                ->orderBy('email', $sort)
                ->paginate($size);
        } else {
            return User::withTrashed()
                ->with('admin', 'employee', 'company', 'supplier')
                ->where('email', 'LIKE', "%".$search."%")
                ->orderBy('email', $sort)
                ->paginate($size);
        }
    }

    /* GET USER BY ID */
    public static function getUserById($id) {
        return User::find($id);
    }

    /* CREATE A NEW USER */
    public static function createUser(Request $req) {
        $validation = ValidationHelper::user($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $user = new User;

        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->firstname = $req->firstname;
        $user->lastname = $req->lastname;
        $user->role_id = $req->role_id;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($user->save()) {
            return $user;
        }
        return null;
    }

    /* CREATE A NEW COMPANY USER*/
    public static function createUserCompany(Request $req) {
        $req->request->add([
            'role_id' => 2
        ]);

        $user = LogicUser::createUser($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        $userCompany = new User_Company;
        
        $userCompany->user_id = $user->id;
        $userCompany->company_id = $req->company_id;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($userCompany->save()) {
            return $user;
        }
        return null;
    }

    /* CREATE A NEW SUPPLIER USER*/
    public static function createUserSupplier(Request $req) {
        $req->request->add([
            'role_id' => 4
        ]);

        $user = LogicUser::createUser($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        $userSupplier = new User_Supplier;
        
        $userSupplier->user_id = $user->id;
        $userSupplier->supplier_id = $req->supplier_id;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($userSupplier->save()) {
            return $user;
        }
        return null;
    }

    /* UPDATE USER BY ID */
    public static function updateUserById(Request $req, $id) {
        $validation = ValidationHelper::user($req->all(), $id);

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $user = User::find($id);

        if (is_null($user)) {
            return new ErrorResource(ErrorHelper::notFound('user', $id));
        }

        $user->email = $req->email;
        $user->firstname = $req->firstname;
        $user->lastname = $req->lastname;
        $user->password = Hash::make($req->password);
        $user->updated_at = date('Y-m-d H:i:s');

        if ($user->save()) {
            return $user;
        }
        return null;
    }

    /* DELETE AN USER BY ID */
    public static function deleteUserById($id) {
        $user = User::withTrashed()->find($id);

        if (is_null($user)) {
            return ErrorHelper::notFound('user', $id);
        }

        if ($user->delete()) {
            return $user;
        }
        return null;
    }

    /* RESTORE AN USER BY ID */
    public static function restoreUserById($id) {
        $user = User::withTrashed()->find($id);

        if (is_null($user)) {
            return ErrorHelper::notFound('user', $id);
        }

        if ($user->restore()) {
            return $user;
        }
        return null;
    }
}