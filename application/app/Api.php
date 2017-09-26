<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Api extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_user', 'api_password', 'api_name','api_provider'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   protected $table ="api_detail";
}
