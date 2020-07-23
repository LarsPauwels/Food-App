<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
   	protected $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'detail_id'
    ];

    /**
     * Get the user for the supplier
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the detail for the supplier
     */
    public function detail() {
        return $this->belongsTo('App\Detail');
    }

    /**
     * Get the timesheets for the supplier
     */
    public function timesheets() {
        return $this->belongsToMany('App\Timesheet', 'timesheet__suppliers');
    }

    /**
     * Get the orders for the supplier
     */
    public function orders() {
        return $this->hasMany('App\Order');
    }
}
