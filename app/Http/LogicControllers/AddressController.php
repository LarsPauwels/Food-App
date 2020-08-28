<?php
namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Address;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class AddressController {
    
    /* CREATE A NEW ADDRESS */ 
    public static function createAddress(Request $req) {
        $validation = ValidationHelper::address($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $address = new Address;

        $address->street = $req->street;
        $address->number = $req->number;
        $address->province = $req->province;
        $address->city = $req->city;
        $address->country = $req->country;
        $address->created_at = date('Y-m-d H:i:s');
        $address->updated_at = date('Y-m-d H:i:s');

        if ($address->save()) {
            return $address;
        }
        return null;
    }

    /* UPDATE ADDRESS BY ID */
    public static function updateAddressById(Request $req, $id) {
        $validation = ValidationHelper::address($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $address = Address::find($id);

        $address->street = $req->street;
        $address->number = $req->number;
        $address->province = $req->province;
        $address->city = $req->city;
        $address->country = $req->country;
        $address->updated_at = date('Y-m-d H:i:s');

        if ($address->save()) {
            return $address;
        }
        return null;
    }
}