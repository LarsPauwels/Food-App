<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'supplier_id', 'timesheet_id'
    ];

    /**
     * Get the employee for the order
     */
    public function employee() {
        return $this->belongsTo('App\Employee');
    }

    /**
     * Get the supplier for the order
     */
    public function supplier() {
        return $this->belongsTo('App\Supplier');
    }

    /**
     * Get the timesheet for the order
     */
    public function timesheet() {
        return $this->belongsTo('App\Timesheet');
    }

    /**
     * Get the bases for the order
     */
    public function bases() {
        return $this->belongsToMany('App\Base', 'base__orders');
    }

    /**
     * Get the base_order for the order
     */
    public function base_orders() {
        return $this->hasMany('App\Base_Order');
    }
}
