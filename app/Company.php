<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'detail_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'active'
    ];

    /**
     * Get the users for the company
     */
    public function user() {
        return $this->belongsToMany('App\User', 'user_company')->withTrashed();
    }

    /**
     * Get the employees for the company
     */
    public function employees() {
        return $this->hasMany('App\Employee');
    }

    /**
     * Get the detail for the company
     */
    public function detail() {
        return $this->belongsTo('App\Detail');
    }

    /**
     * Get the orders for the company
     */
    public function orders() {
        return $this->hasMany('App\Order');
    }

    /**
     * Get the timesheets for the company
     */
    public function timesheets() {
        return $this->hasMany('App\Timesheet');
    }
}
