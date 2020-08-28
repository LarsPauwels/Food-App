<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model {
    protected $table = 'bases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'currency_id'
    ];

    /**
     * Get the currency for the base
     */
    public function currency() {
        return $this->belongsTo('App\Currency');
    }

    /**
     * Get the toppings for the base
     */
    public function toppings() {
        return $this->hasMany('App\Topping');
    }

    /**
     * Get the orders for the base
     */
    public function orders() {
        return $this->belongsToMany('App\Order', 'base__orders');
    }

    /**
     * Get the toppings orders for the base
     */
    public function toppingsOrder() {
        return $this->belongsToMany('App\Topping', 'base__order__toppings', 'base_order_id', 'base__orders', 'base_id');
    }
}
