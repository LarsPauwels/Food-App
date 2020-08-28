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
        'detail_id'
    ];

    /**
     * Get the users for the supplier
     */
    public function user() {
        return $this->belongsToMany('App\User', 'user_supplier')->withTrashed();
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
        return $this->hasMany('App\Timesheet');
    }

    /**
     * Get the orders for the supplier
     */
    public function orders() {
        return $this->hasMany('App\Order');
    }
}
