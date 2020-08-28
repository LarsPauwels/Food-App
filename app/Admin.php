<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    /**
     * Get the user for the admin
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}
