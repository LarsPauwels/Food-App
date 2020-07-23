<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model {
    protected $table = 'timesheets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'time'
    ];

    /**
     * Get the suppliers for the timesheet
     */
    public function suppliers() {
        return $this->belongsToMany('App\Supplier', 'timesheet__suppliers');
    }

    /**
     * Get the order for the timesheet
     */
    public function orders() {
        return $this->hasMany('App\Order');
    }
}
