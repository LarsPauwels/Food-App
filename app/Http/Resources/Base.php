<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Topping as ToppingResource;

class Base extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'isAvailable' => intval($this->isAvailable),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'currency' => $this->currency,
            'toppings' => ToppingResource::collection($this->toppings)
        ];
    }

    public function with($request) {
        return WithTemplate::with();
    }
}
