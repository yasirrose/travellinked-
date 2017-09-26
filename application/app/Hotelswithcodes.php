<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Hotelswithcodes extends Authenticatable
{
    protected $table = 'tblhotelswithcodes';
	protected $primaryKey = 'id';
	protected $fillable = [
        'hotelgroupcode', 'hotelid', 'hotelname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];
}
