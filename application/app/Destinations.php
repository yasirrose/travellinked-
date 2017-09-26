<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Destinations extends Authenticatable
{
    protected $table = 'tblhotelgroupcodes';
	protected $primaryKey = 'groupId';
	protected $fillable = [
        'groupId', 'hotelgroupcode', 'hotelgroupname','hotelgroupimage','hotelgroupdescriptions','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];
}
