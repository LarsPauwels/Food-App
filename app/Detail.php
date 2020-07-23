<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model {
    protected $table = 'details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'name', 'address_id'
    ];

    /**
     * Get the address for the detail.
     */
    public function address() {
        return $this->belongsTo('App\Address');
    }

    /**
     * Get the company for the detail.
     */
    public function company() {
        return $this->hasOne('App\Company');
    }

    /**
     * Get the supplier for the detail.
     */
    public function supplier() {
        return $this->hasOne('App\Supplier');
    }
}
