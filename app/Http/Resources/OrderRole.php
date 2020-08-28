<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderBase as OrderBaseResource;
use App\Base;

class OrderRole extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'date' => $this->delivery_date,
            'employee' => $this->employee->firstname ? $this->employee->firstname." ".$this->employee->lastname : null,
            'restaurant' => $this->supplier->detail->name,
            'products' => OrderBaseResource::collection($this->base_orders)
        ];
    }

    public function with($request) {
        return WithTemplate::with();
    }
}
