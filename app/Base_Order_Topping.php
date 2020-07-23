<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base_Order_Topping extends Model {
    protected $table = 'base__order__toppings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'base_order_id', 'topping_id'
    ];

    /**
     * Get the order for the base_order_topping
     */
    public function order() {
        return $this->belongsTo('App\Base_Order');
    }

    /**
     * Get the topping for the base_order_topping
     */
    public function topping() {
        return $this->belongsTo('App\Topping');
    }
}
