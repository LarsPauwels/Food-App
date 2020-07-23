<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Timesheet as TimesheetResource;
use App\Http\Resources\Base as BaseResource;
use App\Http\Resources\Address as AddressResource;

class Order extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        for ($i=0; $i < count($this->bases); $i++) { 
            $this->bases[$i]->base_order_id = $this->base_orders[$i]->id;
        }

        return [
            'id' => $this->id,
            'delivered' => $this->delivered,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'orders' => BaseResource::collection($this->bases),
            'timesheet' => new TimesheetResource($this->timesheet),
            'supplier' => [
                'id' => $this->supplier->id,
                'firstname' => $this->supplier->detail->name,
                'phone' => $this->supplier->detail->phone,
                'address' => new AddressResource($this->supplier->detail->address),
                'created_at' => $this->supplier->created_at,
                'updated_at' => $this->supplier->updated_at,
            ],
            'employee' => [
                'id' => $this->employee->id,
                'firstname' => $this->employee->firstname,
                'lastname' => $this->employee->lastname,
                'created_at' => $this->employee->created_at,
                'updated_at' => $this->employee->updated_at,
                'company' => [
                    'name' => $this->employee->company->detail->name,
                    'phone' => $this->employee->company->detail->phone,
                    'created_at' => $this->employee->company->created_at,
                    'updated_at' => $this->employee->company->updated_at,
                    'address' => new AddressResource($this->employee->company->detail->address)
                ]
            ]
        ];
    }
}
