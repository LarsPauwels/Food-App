<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base_Order extends Model {
    protected $table = 'base__orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'base_id'
    ];

    /**
     * Get the order for the base_order
     */
    public function order() {
        return $this->belongsTo('App\Order');
    }

    /**
     * Get the order for the base_order
     */
    public function base() {
        return $this->belongsTo('App\Base');
    }

    /**
     * Get the orders for the base_order
     */
    public function orders() {
        return $this->belongsToMany('App\Order', 'base__orders');
    }

    /**
     * Get the toppings for the base_order
     */
    public function toppings() {
        return $this->belongsToMany('App\Topping', 'base__order__toppings', 'base_order_id');
    }
}
