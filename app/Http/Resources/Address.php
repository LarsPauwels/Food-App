<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Address extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'street' => $this->street,
            'number' => $this->number,
            'city' => $this->city,
            'province' => $this->province,
            'country' => $this->country
        ];
    }
}
