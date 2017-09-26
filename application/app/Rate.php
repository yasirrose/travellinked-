<?php



namespace App;



use Illuminate\Foundation\Auth\User as Authenticatable;



class Rate extends Authenticatable

{

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

       'global_type', 'global_name','global_value','global_discount','created_at','updated_at','margin_status','margin','markup_status','markup','tax_status','tax','discount_status','discount','status'

    ];

    protected  $primaryKey = 'global_id';



    /**

     * The attributes that should be hidden for arrays.

     *

     * @var array

     */

   protected $table ="tblglobalsetting";

}

