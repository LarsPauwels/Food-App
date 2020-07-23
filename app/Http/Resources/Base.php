<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Topping as ToppingResource;
use App\Currency as CurrencyModel;
use App\Base_Order_Topping as BaseOrderToppingModel;

class Base extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        //return BaseOrderToppingModel::with('topping')->where('base_order_id', $this->base_order_id)->get()->pluck('topping');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'currency' => CurrencyModel::find($this->currency_id)->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'toppings' => ToppingResource::collection(BaseOrderToppingModel::with('topping')->where('base_order_id', $this->base_order_id)->get()->pluck('topping'))
        ];
    }
}
