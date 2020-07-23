<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model {
    protected $table = 'toppings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'currency_id'
    ];

    /**
     * Get the currency for the topping
     */
    public function currency() {
        return $this->belongsTo('App\Currency');
    }

    /**
     * Get the orders for the topping
     */
    public function orders() {
        return $this->belongsToMany('App\Order', 'base__order__toppings', 'topping_id', 'base_order_id');
    }

    /**
     * Get the bases for the topping
     */
    public function bases() {
        return $this->belongsToMany('App\Base', 'base__order__toppings', 'topping_id', 'base_order_id');
    }
}
