<?php
namespace App\Http\LogicControllers;

use Illuminate\Http\Request;

use App\Detail;

use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

use App\Http\LogicControllers\AddressController as LogicAddress;

class DetailController {
    
    /* CREATE A NEW DETAIL */
    public static function createDetail(Request $req) {
        $validation = ValidationHelper::detail($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $address = LogicAddress::createAddress($req);

        if (is_a($address, 'Illuminate\Http\JsonResponse')) {
            return $address;
        }

        $detail = new Detail;

        $detail->name = $req->name;
        $detail->phone = $req->phone;
        $detail->address_id = $address->id;
        $detail->created_at = date('Y-m-d H:i:s');
        $detail->updated_at = date('Y-m-d H:i:s');

        if ($detail->save()) {
            $detail->address = $address;
            return $detail;
        }
        return null;
    }

    /* UPDATE DETAIL BY ID */ 
    public static function updateDetailById(Request $req, $id) {
        $validation = ValidationHelper::detail($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }
        
        $detail = Detail::find($id);

        if (is_null($detail)) {
           return ErrorHelper::notFound('detail', $id);
        }

        $address = LogicAddress::updateAddressById($req, $detail->address_id);

        if (is_a($address, 'Illuminate\Http\JsonResponse')) {
            return $address;
        }

        $detail->name = $req->name;
        $detail->phone = $req->phone;
        $detail->updated_at = date('Y-m-d H:i:s');

        if ($detail->save()) {
            $detail->address = $address;
            return $detail;
        }
        return null;
    }
}