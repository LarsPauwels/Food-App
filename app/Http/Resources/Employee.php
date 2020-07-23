<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Company as CompanyResource;

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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                'user_id' => $this->user_id,
                'email' => $this->user->email
            ],
            'company' => new CompanyResource($this->company)
        ];
    }

    public function with($request) {
       return WithTemplate::with();
    }
}
