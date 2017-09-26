<?php



namespace App;



use Illuminate\Foundation\Auth\User as Authenticatable;



class Deals extends Authenticatable

{

    protected $table = 'bonotel_deals';

	protected $fillable = [];



    /**

     * The attributes that should be hidden for arrays.

     */

    protected $hidden = [];


    public static function loadDeals($order_col,$orderby,$limit,$start, $search,$query_resulted){
        $total = '';
        $result= array();
        if($query_resulted == 'all'){
            $deals = Self::orderBy($order_col,$orderby)->offset($start)->take($limit)->where('HotelName', 'LIKE', '%' . $search . '%')->orwhere('created_at', 'LIKE', '%' . $search . '%')->get();
           $total = Deals::count();
//            $total = count($deals);
            $result['totalRecords'] = $total;
        }else{
            if($query_resulted == 'active'){
                $filter_query =  1;
                if($search != '') {
                    $deals = Self::orderBy($order_col, $orderby)->offset($start)->take($limit)->where('is_active', '=', 1)->orwhere('HotelName', 'LIKE', '%' . $search . '%')->orwhere('created_at', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $deals = Self::orderBy($order_col, $orderby)->offset($start)->take($limit)->where('is_active', '=', 1)->get();
                }
               $total = Deals::where('is_active', '=', 1)->get()->count();
                $result['totalRecords'] = $total;
//                $total = count($deals);
            }
            elseif($query_resulted == 'in-active'){
                $filter_query = 0;
                if($search != ''){
                    $deals = Self::orderBy($order_col,$orderby)->offset($start)->take($limit)->where('is_active', '=', 0)->orwhere('HotelName', 'LIKE', '%' . $search . '%')->orwhere('created_at', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $deals = Self::orderBy($order_col, $orderby)->offset($start)->take($limit)->where('is_active', '=', 0)->get();
                }
               $total = Deals::where('is_active', '=', 0)->count();
                $result['totalRecords'] = $total;
            }
            elseif ($query_resulted == 'admin_created'){
                if($search != ''){
                    $deals = Self::orderBy($order_col,$orderby)->offset($start)->take($limit)->where('is_custom', '=', 1)->orwhere('HotelName', 'LIKE', '%' . $search . '%')->orwhere('created_at', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $deals = Self::orderBy($order_col,$orderby)->offset($start)->take($limit)->where('is_custom', '=', 1)->get();
                }
                $total = Deals::where('is_custom', '=', 1)->count();
                $result['totalRecords'] = $total;
            }
        }
        $allDeals = Self::getFormatedData($deals, $search);

        $result['alldeals'] = $allDeals;
        return $result;
    }
    private static function getFormatedData($deals,$search){
        $data = array();
        foreach($deals as $item){
            $obj = array();
            $obj['deal_status'] = $item->is_active;
            $obj['id'] = $item->id;
            $obj['hotelName'] = $item->HotelName;
            $obj['location'] = \DB::table('hotel')->where('hotelCode', '=', $item->HotelID)->orwhere('country', 'LIKE', '%' . $search . '%')->orwhere('city', 'LIKE', '%' . $search . '%')->orwhere('state', 'LIKE', '%' . $search . '%')->first();
            if($obj['location']==null){
                $obj['location'] = 'New Location';
            }
            else{
                $obj['location'] = $obj['location']->city.', '.$obj['location']->state;
            }
            $obj['dealName'] = $item->CustomerSpecialCode;
            $obj['created_at'] = $item->created_at;
            $data[] = $obj;
        }
        return $data;
    }
    public static function allDestinations($order_col ,$orderby ,$limit,$start, $search,$query_resulted){
        $result= array();
        $total = '';
        if($query_resulted == 'all'){
                $alldests = \DB::table('tblhotelgroupcodes')->orderby($order_col, $orderby)->offset($start)->take($limit)->orwhere('hotelgroupcode', 'LIKE', '%' . $search . '%')->orwhere('hotelgroupname', 'LIKE', '%' . $search . '%')->get();
                $total = \DB::table('tblhotelgroupcodes')->count();
                $result['total'] = $total;
        }else{
            if($query_resulted == 'active'){
                if($search !=''){
                    $alldests = \DB::table('tblhotelgroupcodes')->orderby($order_col, $orderby)->offset($start)->take($limit)->where('status', '=', 1)->orwhere('hotelgroupcode', 'LIKE', '%' . $search . '%')->orwhere('hotelgroupname', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $alldests = \DB::table('tblhotelgroupcodes')->orderby($order_col, $orderby)->offset($start)->take($limit)->where('status', '=', 1)->get();
                }
                $total = \DB::table('tblhotelgroupcodes')->where('status', '=', 1)->count();
                $result['total'] = $total;
            }elseif($query_resulted == 'in_active'){
                if($search != ''){
                    $alldests = \DB::table('tblhotelgroupcodes')->orderby($order_col, $orderby)->offset($start)->take($limit)->where('status', '=', 0)->orwhere('hotelgroupcode', 'LIKE', '%' . $search . '%')->orwhere('hotelgroupname', 'LIKE', '%' . $search . '%')->get();
                }else{
                    $alldests = \DB::table('tblhotelgroupcodes')->orderby($order_col, $orderby)->offset($start)->take($limit)->where('status', '=', 0)->get();
                }
                $total = \DB::table('tblhotelgroupcodes')->where('status', '=', 0)->count();
                $result['total'] = $total;
            }
        }
        $result['alldests'] = $alldests;
        return $result;
    }

}

