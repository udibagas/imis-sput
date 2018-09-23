<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'super_admin', 'active',
        'api_token', 'last_login', 'customer_id', 'contractor_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public static function getRoles()
    {
        return [
            'Admin', 'Engineering', 'Operation', 'Plant',
            'SM', 'SHE', 'FAT', 'HCGS', 'Management', 'Customer'
        ];
    }

    public function authorizations() {
        return $this->hasMany(Authorization::class);
    }

    public function mealLocatins() {
        return $this->hasMany(MealLocation::class);
    }
}
