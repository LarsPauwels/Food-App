<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Topping as ToppingResource;
use App\Base;
use App\Base_Order;

class OrderBase extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $base = Base::find($this->base_id);
        $baseOrder = Base_Order::with('toppings')->find($this->id);
        
        return [
            'id' => $base->id,
            'name' => $base->name,
            'description' => $base->description,
            'price' => $base->price,
            'isAvailable' => intval($base->isAvailable),
            'created_at' => $base->created_at,
            'updated_at' => $base->updated_at,
            'currency' => $base->currency,
            'toppings' => ToppingResource::collection($baseOrder->toppings)
        ];
    }

    public function with($request) {
        return WithTemplate::with();
    }
}
