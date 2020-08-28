<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Company as CompanyResource;

use App\Http\Helpers\ResourceHelper;

class Employee extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'email' => $this->user->email,
            'orders' => ResourceHelper::amountOrders($this->id),
            'profit' => $this->profit ? $this->profit : ResourceHelper::employeeProfit($this->id, 'today'),
            'average_price' => ResourceHelper::averagePrice($this->id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'company' => new CompanyResource($this->company)
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}
