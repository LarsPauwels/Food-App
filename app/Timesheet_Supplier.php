<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet_Supplier extends Model
{
    protected $table = 'timesheet__suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timesheet_id', 'supplier_id'
    ];

    /**
     * Get the supplier for the timesheet_suppliers
     */
    public function supplier() {
        return $this->belongsTo('App\Supplier');
    }

    /**
     * Get the timesheet for the timesheet_suppliers
     */
    public function timesheet() {
        return $this->belongsTo('App\Timesheet');
    }
}
