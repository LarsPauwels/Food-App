<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Address as AddressResource;
use App\Address as AddressModel;

class Company extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        if (!empty($this->employees)) {
            foreach ($this->employees as $employee) {
                unset($employee->company_id);
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->detail->name,
            'phone' => $this->detail->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                'user_id' => $this->user_id,
                'email' => $this->user->email
            ],
            'address' => new AddressResource(AddressModel::find($this->detail->address_id)),
            'employees' => $this->employees
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}
