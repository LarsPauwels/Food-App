<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the toppings for the currency
     */
    public function toppings() {
        return $this->hasMany('App\Topping');
    }

    /**
     * Get the bases for the currency
     */
    public function bases() {
        return $this->hasMany('App\Base');
    }
}
