<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Address as AddressResource;
use App\Http\Resources\Timesheet as TimesheetResource;
use App\Http\Resources\Base as BaseResource;
use App\Http\Resources\User as UserResource;
use App\Address as AddressModel;

use App\Http\Helpers\ResourceHelper;

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
            'address' => new AddressResource(AddressModel::find($this->detail->address_id)),
            'invited' => intval($this->status),
            'phone' => $this->detail->phone,
            'products' => (isset($this->bases) ? BaseResource::collection($this->bases) : []),
            'locked' => ResourceHelper::locked($this->id),
            'revenue' => ResourceHelper::revenue($this->id),
            'timesheets' => TimesheetResource::collection($this->timesheets),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                UserResource::collection($this->user)
            ],
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}
