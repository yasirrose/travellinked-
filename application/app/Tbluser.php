<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Tbluser extends Model
{
    /** The attributes that are mass assignable. **/
    protected $fillable = [
        'first_name', 'last_name', 'email','birthday','password','img_url','role','created_at','update_at' ,'is_remember' ,'status','is_activated','fb_id','country','min_age','max_age','discount'
    ];

    /** The attributes that should be hidden for arrays. **/
    protected $hidden = [];
	
	/** relation to roles model **/
	public function role()
    {
        return $this->hasOne('App\Roles','id','role');
    }

    public static function users($ordercol,$ordrBY,$limit,$start, $search,$query_resulted){

        $data = array();

        if($query_resulted == 'all'){
            $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
        }else{
            if($query_resulted == 'repeat'){
                if($search != ''){
                    $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
                }
            }elseif ($query_resulted == 'b2c'){
                if($search != null){
                    $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
                }
            }elseif($query_resulted == 'b2b'){
                if($search != null){
                    $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
                }
            }elseif($query_resulted == 'prospects'){
                if($search != ''){
                    $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $users = Tbluser::orderBY($ordercol , $ordrBY)->offset($start)->take($limit)->orwhere('first_name', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->get();
                }
            }

        }

        foreach($users as $user){
            $obj = array();
            $datas = array();
            $bookingDetail = \DB::table('tblbooking')
                ->join('tblpending_requests', 'tblbooking.request_id', '=',  'tblpending_requests.request_id')
                ->where('tblpending_requests.user_id','=',$user->id)
                ->orwhere('total_amount', 'LIKE', '%' . $search . '%')
                ->orderBy('tblbooking.booking_date', 'DESC')
                ->get();


//            $obj['userName'] = $user->first_name.' '.$user->last_name;
            $obj['userName'] = $user->first_name;
            $obj['location'] = $user->country.' '.$user->state;
            $obj['totalBooking'] = count($bookingDetail);
            $obj['id'] = $user->id;
            $obj['status'] = $user->status;
            $sum = 0;
            foreach($bookingDetail as $item){
                $sum = $sum + $item->total_amount;
            }
            if($bookingDetail==null){
                $obj['lastBooking'] = 'NA';
                $obj['totalBookingPrice'] = 'NA';
            }
            else{
                $obj['totalBookingPrice'] = $sum;
                $obj['lastBooking'] = $bookingDetail[0]->total_amount;
            }
//            $result= array();
//            $data['allusers'] = $allDeals;

            $data[] = $obj;

        }
//        $data['count'] = count($obj);
//        $data['totalRecords'] = Tbluser::count();
//        $data['activeID'] = 'allcustomers';


        return $data;

    }
}
