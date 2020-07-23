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
        'user_id', 'detail_id'
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
     * Get the user for the company
     */
    public function user() {
        return $this->belongsTo('App\User');
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
}
