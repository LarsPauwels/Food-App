<?php
namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Base;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\ToppingController as LogicTopping;

class BaseController {

    /* GET ALL BASES BY SUPPLIER */
    public static function getAllBasesBySupplier(Request $req, $supplierId) {
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

        $bases = Base::with('currency')
            ->where('supplier_id', $supplierId)
            ->where('name', 'LIKE', "%".$search."%")
            ->orderBy('name', $sort)
            ->paginate($size);

        foreach ($bases as $key => $base) {
            $toppings = LogicTopping::getAllToppingsByBase($req, $base->id);

            if (is_a($toppings, 'Illuminate\Http\JsonResponse')) {
                return $toppings;
            }

            $bases[$key]->toppings = $toppings;
        }

        return $bases;
    }

    /* CREATE A NEW BASE BY SUPPLIER */
    public static function createBase(Request $req, $supplierId) {
        $validation = ValidationHelper::base($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $base = new Base;

        $base->name = $req->name;
        $base->description = $req->description;
        $base->price = $req->price;
        $base->isAvailable = $req->isAvailable;
        $base->supplier_id = $supplierId;
        $base->currency_id = 1;
        $base->created_at = date('Y-m-d H:i:s');
        $base->updated_at = date('Y-m-d H:i:s');

        if ($base->save()) {
            if (count($req->toppings)) {
                $toppings = LogicTopping::createTopping($req, $base->id);

                if (is_a($toppings, 'Illuminate\Http\JsonResponse')) {
                    return $toppings;
                }

                $base->toppings = $toppings;
            }

            return $base;
        }
        return null;
    }

    /* UPDATE BASE BY ID */
    public static function updateBaseById(Request $req, $id) {
        $validation = ValidationHelper::base($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $base = Base::with('toppings')->find($id);

        if (is_null($base)) {
           return ErrorHelper::notFound('base', $id);
        }

        $base->name = $req->name;
        $base->description = $req->description;
        $base->price = $req->price;
        $base->isAvailable = $req->isAvailable;
        $base->currency_id = 1;
        $base->updated_at = date('Y-m-d H:i:s');

        if ($base->save()) {

            if (count($base->toppings)) {
                $toppings = LogicTopping::deleteToppingByBase($id);

                if (is_a($toppings, 'Illuminate\Http\JsonResponse')) {
                    return $toppings;
                }
            }

            $toppings = LogicTopping::createTopping($req, $id);

            if (is_a($toppings, 'Illuminate\Http\JsonResponse')) {
                return $toppings;
            }

            $base->toppings = $toppings;

            return $base;
        }
        return null;
    }

    /* DELETE BASE BY ID */
    public static function deleteBaseById($id) {
        $base = Base::with('toppings')->find($id);
        
        if (is_null($base)) {
           return ErrorHelper::notFound('base', $id);
        }

        if (count($base->toppings)) {
            $toppings = LogicTopping::deleteToppingByBase($id);

            if (is_a($toppings, 'Illuminate\Http\JsonResponse')) {
                return $toppings;
            }
        
            $base->toppings = $toppings;
        }

        if ($base->delete()) {
            return $base;
        }
        return null;
    }
}