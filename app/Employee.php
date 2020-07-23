<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'user_id', 'company_id'
    ];

    /**
     * Get the user for the employee
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the company for the employee
     */
    public function company() {
        return $this->belongsTo('App\Company');
    }

    /**
     * Get the orders for the user
     */
    public function orders() {
        return $this->hasMany('App\Order');
    }
}
