<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Supplier extends Model {
    protected $table = 'user_supplier';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'supplier_id'
    ];
}
