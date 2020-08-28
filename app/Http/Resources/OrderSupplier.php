<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Timesheet as TimesheetResource;
use App\Http\Resources\Base as BaseResource;
use App\Http\Resources\Address as AddressResource;

use App\Company;
use App\Http\Resources\OrderCompany as OrderCompanyResource;
use App\Order;
use App\Http\Resources\Order as OrderResource;

use App\Http\Helpers\ResourceHelper;

class OrderSupplier extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $data = [];
        foreach ($this as $key => $value) {
            $id = null;
            $date = null;
            $companies = [];
            foreach ($value as $k => $v) {
                $id = $v->id;
                $date = $v->delivery_date;
                $companyById = Company::find($v->company_id);
                $companyById->supplier = $v->supplier_id;
                $companyById->date = $v->delivery_date;
                $company = new OrderCompanyResource($companyById);

                if (!in_array($company, $companies)) {
                    array_push($companies, $company);
                }
            }

            $data += [
                'id' => $id,
                'date' => $date,
                'companies' => $companies
            ];
        }
        return $data;
    }

    public function with($request) {
        return WithTemplate::with();
    }
}
