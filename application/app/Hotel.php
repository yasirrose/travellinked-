<?php



namespace App;



use Illuminate\Foundation\Auth\User as Authenticatable;



class Hotel extends Authenticatable

{

    protected $table = 'hotel';

	protected $fillable = [];



    /**

     * The attributes that should be hidden for arrays.

     */

    protected $hidden = [];

}

