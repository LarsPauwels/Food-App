<?php

namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Admin;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\UserController as LogicUser;

class AdminController {

    /* GET ALL ADMINS */
    public static function getAdmins(Request $req) {
        $validation = ValidationHelper::attributes($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $size = (int)$req->page_size;
        $sort = strtolower($req->sort);
        $search = strtolower($req->search);

        if (is_null($req->page_size)) {
            $size = 50;
        }

        if (is_null($req->sort)) {
            $sort = 'asc';
        }

        return Admin::has('user')
            ->where('firstname', 'LIKE', "%".$search."%")
            ->orderBy('firstname', $sort)
            ->paginate($size);
    }

    /* GET ADMIN BY ID */
    public static function getAdminById($id) {
        return Admin::has('user')->find($id);
    }

    /* CREATE A NEW ADMIN */
    public static function createAdmin(Request $req) {
        $req->request->add([
            'role_id' => 1
        ]);

        $user = LogicUser::createUser($req);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        $admin = new Admin;

        $admin->user_id = $user->id;
        $admin->created_at = date('Y-m-d H:i:s');
        $admin->updated_at = date('Y-m-d H:i:s');

        if ($admin->save()) {
            return $admin;
        }
        return null;
    }

    /* UPDATE ADMIN BY ID */
    public static function updateAdminById(Request $req, $id) {
        $req->request->add([
            'role_id' => 1
        ]);

        $admin = Admin::find($id);

        if (is_null($admin)) {
           return ErrorHelper::notFound('admin', $id);
        }

        $user = LogicUser::updateUserById($req, $admin->user_id);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        $admin->user_id = $admin->user_id;
        $admin->updated_at = date('Y-m-d H:i:s');

        if ($admin->save()) {
            return $admin;
        }
        return null;
    }

    /* DELETE ADMIN BY ID */
    public static function deleteAdminById($id) {
        $admin = Admin::with('user')->find($id);
        
        if (is_null($admin)) {
           return ErrorHelper::notFound('admin', $id);
        }

        $user = LogicUser::deleteUserById($admin->user_id);

        if (is_a($user, 'Illuminate\Http\JsonResponse')) {
            return $user;
        }

        return $admin;
    }
}
