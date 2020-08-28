<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Address as AddressResource;
use App\Http\Resources\Timesheet as TimesheetResource;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Resources\OrderRole as OrderRoleResource;
use App\Address as AddressModel;
use App\Order;

use App\Http\Helpers\ResourceHelper;

class OrderCompany extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {

        return [
            'id' => $this->id,
            'name' => $this->detail->name,
            'address' => new AddressResource(AddressModel::find($this->detail->address_id)),
            'phone' => $this->detail->phone,
            'timesheets' => TimesheetResource::collection($this->timesheets),
            'orders' => OrderRoleResource::collection(Order::where('company_id', $this->id)->where('supplier_id', $this->supplier)->where('delivery_date', $this->date)->get())
        ];
    }

    public function with($request) {
        return WithTemplate::with();
    }
}
