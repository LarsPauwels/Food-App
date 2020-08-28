<?php
namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Topping;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class ToppingController {
    /* GET ALL TOPPINGS BY BASE */ 
    public static function getAllToppingsByBase(Request $req, $baseId) {
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

        return Topping::has('currency')
            ->where('base_id', $baseId)
            ->where('name', 'LIKE', "%".$search."%")
            ->orderBy('name', $sort)
            ->paginate($size);
    }

    /* CREATE MULTIPLE TOPPINGS BY BASE */
    public static function createTopping(Request $req, $baseId) {
        $validation = ValidationHelper::topping($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $toppings = null;
        foreach ($req->toppings as $key => $t) {
            $topping = new Topping;

            $topping->name = $t["name"];
            $topping->price = $t["price"];
            $topping->isAvailable = $t["isAvailable"];
            $topping->base_id = $baseId;
            $topping->currency_id = 1;
            $topping->created_at = date('Y-m-d H:i:s');
            $topping->updated_at = date('Y-m-d H:i:s');

            if ($topping->save()) {
                $toppings[$key] = $topping;
            }
        }

        return $toppings;
    }

    /* DELETE ALL TOPPINGS BY BASE */
    public static function deleteToppingByBase($baseId) {
        $toppings = Topping::where('base_id', $baseId)->get();
        
        if (!count($toppings)) {
            $message = 'There was no topping found with base_id '.$baseId.'.';
            return ErrorHelper::exceptions($message, 404);
        }

        foreach ($toppings as $topping) {
            $topping->delete();
        }

        return $toppings;
    }
}