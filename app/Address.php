<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'street', 'number', 'city', 'province', 'country'
    ];

    /**
     * Get the detail for the address.
     */
    public function details() {
        return $this->hasOne('App\Detail');
    }
}
