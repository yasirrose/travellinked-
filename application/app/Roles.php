<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Roles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'tbluser_roles';
    protected $fillable = ['role_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
