<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {
    use HasAPITokens, Notifiable, SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname', 'lastname', 'role_id'
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
     * Get the role for the user
     */
    public function role() {
        return $this->belongsTo('App\Role');
    }

    /**
     * Get the admin for the user
     */
    public function admin() {
        return $this->hasOne('App\Admin');
    }

    /**
     * Get the companies for the user
     */
    public function company() {
        return $this->belongsToMany('App\Company', 'user_company');
    }

    /**
     * Get the suppliers for the user
     */
    public function supplier() {
        return $this->belongsToMany('App\Supplier', 'user_supplier');
    }

    /**
     * Get the employee for the user
     */
    public function employee() {
        return $this->hasOne('App\Employee');
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin() {
       return $this->role()->where('name', 'Admin')->exists();
    }
}
