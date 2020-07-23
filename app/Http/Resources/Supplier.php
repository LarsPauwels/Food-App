<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Address as AddressResource;
use App\Http\Resources\Timesheet as TimesheetResource;
use App\Address as AddressModel;

class Supplier extends JsonResource {
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
            'phone' => $this->detail->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                'user_id' => $this->user_id,
                'email' => $this->user->email
            ],
            'address' => new AddressResource(AddressModel::find($this->detail->address_id)),
            'timesheet' => TimesheetResource::collection($this->timesheets)
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}
