<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company_Supplier extends Model
{
    protected $table = 'company_supplier';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'supplier_id', 'status'
    ];

    /**
     * Get the supplier for the company_supplier
     */
    public function supplier() {
        return $this->belongsTo('App\Supplier');
    }

    /**
     * Get the company for the company_supplier
     */
    public function company() {
        return $this->belongsTo('App\Supplier');
    }
}
