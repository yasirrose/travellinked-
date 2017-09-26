<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;
use App\Tbluser;

use App\Helpers\Helper;
use Carbon\Carbon;

use App\Http\Controllers\Controller;



class BookingController extends Controller

{
    private $APiUser;

    private $ApiPassword;

    private $provider;

    /*============================= controller constructor ===============================*/

    public function __construct()

    {
        $this->APiUser = Helper::api()->api_user;

        $this->provider = Helper::api()->api_provider;

        $this->ApiPassword = Helper::api()->api_password;

    }

    /*============================ function to cancel booking by admin ===================*/

    public function cancellation($id)

    {



        $today_date = date("Y-m-d");


        $data = DB::select("SELECT tp.*,tb.*,rb.* FROM tblpending_requests tp INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.request_id = '$id'");

        $data = $data[0];

        //$date = Carbon::parse($data->bookingDate)->format('Y-m-d');



        if ($today_date >= $data->chekIn) {

          return \Redirect::back()->withErrors(["Booking can not be Canceled on current date", 'The Message']);
        }

        else {
            $transID = $data->bookingID;

            $bookID = $data->booking_id;

            $timeStamp = date("YmdTh:i:s");

            $xml = '<?xml version="1.0" encoding="utf-8" ?>

		<cancellationRequest timestamp="' . $timeStamp . '">

		<control>

		<userName>' . Helper::api()->api_user . '</userName>

		<passWord>' . Helper::api()->api_password . '</passWord>

		</control>

		<supplierReferenceNo>' . $data->booking_reference_no . '</supplierReferenceNo>

		<cancellationReason/>

		<cancellationNotes>selected a different hotel.</cancellationNotes>

		</cancellationRequest>';

    $url = $this->provider . "bonotelapps/bonotel/reservation/GetCancellation.do";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

            $result = curl_exec($ch);


            $xmlCancel = @simplexml_load_string($result);


            if (empty($xmlCancel)) {

                return redirect()->to("500");

            }

            $stdObj = json_decode(json_encode($xmlCancel));

            $status = "";

            foreach ($stdObj as $item) {

                if ($item->status) {

                    $status = $item->status;

                    break;

                }

            }
            $status = "Y";



            if ($status == "N") {

                $stats = $status;

                $errorCode = $xmlCancel->errors->code;

                $errorDesc = $xmlCancel->errors->description;




                return redirect()->to("admin/bookings")->with("error", "Booking failed. Error Description :" . $errorDesc[0]);

            } elseif ($status == "Y") {


                \Mail::send('mails.cancel',array('bookingDetail' => $data), function($message)

                {

                    $message->from('info@travellinked.com', 'Travel Linked');

                    $message->to('techleadz.cfm@gmail.com')->subject('Booking Cancel Notification');

                });


                $stdObj = json_decode(json_encode($xmlCancel));



                DB::table("tblbooking")->where("request_id", "=", $id)
                    ->update(["cancellationNo" => $stdObj->cancellationNo, "is_canceled" => 1]);


            } else {

                return redirect()->back()->with("error", "Booking Cancellation unknown error, please try again!");

                }
              }
            }



    public function refund($id)
    {

//        $check = DB::table("room_booking")
//            ->where("request_id", "=", $id)
//            ->select('is_refunded')->get();
//        if ($check->is_refunded) {
//            return redirect()->back()->with("success", "Booking order is successfully  refunded");
//
//        } else {

            try {

                $data = DB::select("SELECT tp.*,tb.*,rb.* FROM tblpending_requests tp INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.request_id = '$id'");
       

                $data = $data[0];

                $transID = $data->bookingID;

                \Stripe\Stripe::setApiKey("sk_test_5UDILxpSajcREGk3jpGpbD44");

                $re = \Stripe\Refund::create(array(
                    "charge" => $transID . ''
                ));

                if ($re->status == "succeeded") {



                    DB::table("room_booking")->where("request_id", "=", $id)
                        ->update(["refund_id" => $re->id, "is_refunded" => 1]);

                    \Mail::send('mails.refund',array('bookingDetail' => $data), function($message)use ($data)

                    {

                        $message->from('info@travellinked.com', 'Travel Linked');

                        $message->to($data->booking_email)->subject('Booking refund Notification');

                    });


                    return redirect()->back()->with("success", "Booking order is successfully  refunded");

                }
            }
            catch (\Exception $e){

               return  \Redirect::back()->withErrors([$e->getMessage(), 'The Message']);
            }

        }


	/*============================ end function to cancel booking by admin ===============*/

	

	/*============================ function to display all bookings ======================*/

	public function notification_alarm(){

	    $alram_data = DB::table('tblpending_requests')
            ->select('*')
            ->where('is_read','=',0)->get();

	    $data = count($alram_data);

        $obj = array();
         foreach ($alram_data as $datas){

             $data = array();
             $data['id'] = $datas->request_id;
             $data['hotel_name'] = $datas->hotel_name;
             $data['chekIn'] = Carbon::parse($datas->chekIn)->format('F jS  ');
             $data['hotel_city'] = $datas->hotel_city;
             $data['total_ammount'] = $datas->total_amount;
             $obj[] = $data;

         }

        echo json_encode($obj);
        exit;

       }
       public function mute_notification($id){

           DB::table('tblpending_requests')
               ->where('request_id','=',$id)
               ->update(array('is_read' => 1));
          return redirect('admin/booking/detail/'.$id);

        }

	public function Bookings()
	{

		return view("dashboard.pending_booking",compact("allBooking","title",'activeID'));
	}

	public function bookingDetails(Request $request){
        $query_value = $request->query();
        $query_resulted = $query_value['value'];
        $sEcho =$request->get('sEcho');
        $start = $request->get('iDisplayStart');
        $limit = $request->get('iDisplayLength');
        $search = $request->get('sSearch');
        $ord = $request->get('sSortDir_0');
        $ord_col = $request->get('iSortCol_0');
        if ($ord_col == '0'){
            $ord_col = "booking_id";
        }
        elseif ($ord_col == '1'){
            $ord_col = "booking_id";
        }elseif ($ord_col == '6'){
            $ord_col = "amountWithTax";
        }
        $order_col = $ord_col;
        $orderby = $ord;
        $data = array();
        $bookings = $this->BookingJson($order_col ,$orderby ,$limit,$start, $search,$query_resulted);
        $display =  count($bookings);
        foreach ($bookings as $i => $booking){
            $data[$i]['check'] = '<i class="fa fa-check"></i>';
            $data[$i]['booking_id'] = $booking->request_id;
            $data[$i]['booking_date'] = \Carbon\Carbon::parse($booking->booking_date)->format('F jS, Y');
            if(isset($booking->name)){
                $data[$i]['booking_email'] = $booking->name;
            }else{
                $data[$i]['booking_email'] = $booking->traveler_fname . " " . $booking->traveler_lname;
            }
            if($booking->is_pending == 1 && $booking->is_deleted == 0){
                $data[$i]['status'] = '<span class="pending-status">Pending</span>';
            }elseif($booking->is_deleted == 1 && $booking->is_refunded == 1){
                $data[$i]['status'] =  '<span>Decline</span>';
            }elseif($booking->is_refunded == 1 && $booking->is_deleted == 0){
                $data[$i]['status'] =  '<span>Refund</span>';
            }elseif($booking->is_pending == 0 && $booking->is_deleted == 0){
                $data[$i]['status'] =  '<span>Paid</span>';
            }
            if($booking->is_canceled == 0 && $booking->is_pending == 0){
                $data[$i]['full_fillment']= '<div class="approve-decline btn-group">
                        <span class="apprDec" data-toggle="dropdown" style="cursor:pointer;"> Confirmed</span>
                        <ul role="menu" class="dropdown-menu animated fadeInLeft"><li>
                        <a href="' .url("admin/cancel") . "/" . $booking->request_id .'
                        "onclick="return confirm("Do you want to cancel?")">Cancel booking</a>
                            </li>
                            <li><a href="#">Email Client</a></li>
                            </ul>
                          </div>';
            }elseif($booking->is_canceled == 1){
                $data[$i]['full_fillment'] = ' <div class="approve-decline btn-group">
                                  <span class="apprDec" data-toggle="dropdown"style="cursor:pointer;"> Canceled</span>
                                  <ul role="menu" class="dropdown-menu animated fadeInLeft">
                                      <li>
                                  <a href="' .url("admin/refund"). "/" .$booking->request_id .' 
                                  "onclick="return confirm("Are you want to refund?")"> Refund </a>
                                        </li>
                                        <li><a href="#">Email Client</a></li>
                                    </ul>
                                </div>';
            }elseif($booking->is_deleted == 1){
                $data[$i]['full_fillment'] = '<p class="book-canceled">Declined</p>';
            }else{
                $data[$i]['full_fillment'] = '<div class="approve-decline btn-group">
                        <span class="apprDec" data-toggle="dropdown" style="cursor:pointer;">Approve / Decline <b class="caret"></b></span>
                          <ul role="menu" class="dropdown-menu animated fadeInLeft">
                            <li>
                            <a href="' .url("admin/approve"). "/" .$booking->request_id. '">Approve
                                                Booking</a></li>
                                        <li><a href="' .url("admin/decline") . "/" .$booking->request_id. '"
                                               onclick="return confirm(\'Do you want to decline?\')">Decline
                                                Booking</a></li>
                                        <li><a href="#">Email Client</a></li>
                                    </ul>
                                </div>';
            }
            $data[$i]['amountWithTax'] = Helper::priceFormate($booking->amountWithTax);
            $data[$i]['action'] = '<div class="approve-decline btn-group"><em class="fa fa-check-square-o apprDec"
                                                                           data-toggle="dropdown"
                                                                           style="cursor:pointer;"></em></span>
                                    <ul role="menu" class="dropdown-menu animated fadeInLeft">
                                        <li><a onclick="getdelete('.$booking->request_id.')">Delete Booking</a></li>
                                        <li><a href="#">Email Client</a></li>
                                    </ul>
                                </div>';
        }
        $results = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => (int) $display,
            "iTotalDisplayRecords" => (int) $display,
            "aaData"=>$data);
        echo json_encode($results);
    }

    public function BookingJson($order_col ,$orderby ,$limit, $start, $search,$query_resulted)
    {
        $allBooking = '';
        if($query_resulted == 'all'){
            if($search != ''){
                $regBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 AND tp.is_delete = 0 AND tp.request_id LIKE '%$search%' OR u.first_name LIKE '%$search%' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                $gestBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 AND tp.is_delete = 0 AND tp.request_id LIKE '%$search%' OR t.traveler_fname LIKE '%$search%' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
            }else{
                $regBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 AND tp.is_delete = 0 ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                $gestBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 AND tp.is_delete = 0 ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
            }
        }else{
            if($query_resulted == 'confirm'){
                if($search != ''){
                    $regBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 AND tp.is_delete = 0 AND tb.booking_status = 'Confirmed' AND tp.request_id LIKE '%$search%' OR u.first_name LIKE '%$search%'   ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                    $gestBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 AND tp.is_delete = 0 AND tb.booking_status = 'Confirmed' AND tp.request_id LIKE '%$search%' OR t.traveler_fname LIKE '%$search%' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                }else{
                    $regBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 AND tp.is_delete = 0 AND tb.booking_status = 'Confirmed' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                    $gestBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 AND tp.is_delete = 0 AND tb.booking_status = 'Confirmed' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                }

            }elseif ($query_resulted == 'pending'){
                if($search != ''){
                    $regBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 AND tp.is_delete = 0 AND tb.booking_status = 'pending' AND tp.request_id LIKE '%$search%' OR u.first_name LIKE '%$search%' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                    $gestBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 AND tp.is_delete = 0 AND tb.booking_status = 'pending' AND tp.request_id LIKE '%$search%' OR t.traveler_fname LIKE '%$search%'  ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                }else{
                    $regBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 AND tp.is_delete = 0 AND tb.booking_status = 'pending' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                    $gestBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 AND tp.is_delete = 0 AND tb.booking_status = 'pending' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                }
            }elseif ($query_resulted == 'cancel'){
                if($search != ''){
                    $regBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 AND tp.is_delete = 0 AND tb.booking_status = 'canceled' AND tp.request_id LIKE '%$search%' OR u.first_name LIKE '%$search%'  ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                    $gestBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 AND tp.is_delete = 0 AND tb.booking_status = 'canceled' AND tp.request_id LIKE '%$search%' OR t.traveler_fname LIKE '%$search%'  ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                }else{
                    $regBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 AND tp.is_delete = 0 AND tb.booking_status = 'canceled' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                    $gestBooking = DB::select("SELECT tp.apiRoomRate, tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 AND tp.is_delete = 0 AND tb.booking_status = 'canceled' ORDER BY $order_col $orderby LIMIT $limit OFFSET $start");
                }

            }
        }

        /*==== merge both table data====*/

        $collection = collect($regBooking);
        $merged = $collection->merge($gestBooking);
        $allBooking = $merged->all();
        return $allBooking;
    }

	public function deleteBooking(Request $request){
            $id = $request->id;
           DB::table('tblbooking')
            ->where('request_id','=',$id)
            ->limit(1)
            ->update(array('is_delete' => 1));

           DB::table('tblpending_requests')
            ->where('request_id','=',$id)
            ->limit(1)
            ->update(array('is_delete' => 1));

           DB::table('room_booking')
            ->where('request_id','=',$id)
            ->limit(1)
            ->update(array('is_delete' => 1));



    }

	/*=========================== end function to display all bookings ===================*/

	

	/*======================== function to display selected booking detail ===============*/

	public function bookingDetail($id)

    {


        $bookingDetail1 = DB::select("SELECT tp.*,tb.*,rb.* FROM tblpending_requests tp INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.request_id = '$id'");
        if ($bookingDetail1) {


            $bookingDetail = $bookingDetail1[0];

            $url1 = "http://api.bonotel.com/index.cfm/user/" . $this->APiUser . "/action/hotel/hotelCode/" . $bookingDetail->hotelCode;

            $result1 = @file_get_contents($url1);

            $hotelPolicy = simplexml_load_string($result1);

            $policy = $hotelPolicy->hotel->cancelPolicies;


            $information = '';
            $user = new \stdClass();

            if (count($bookingDetail1) > 0 && $bookingDetail->is_visitor == 0) {

                $users = DB::table("tblusers")->where("id", "=", $bookingDetail->user_id)->select("id", "first_name", "last_name", "email", "location", "country", "city", "state", "zip_code", "phoneNumber", "discount")->first();


                $billing_information = DB::table('billing_info')
                    ->select('billing_address1', 'billing_country', 'billing_city', 'billing_state', 'billing_zipcode')
                    ->where('request_id', '=', $id)->first();


                $user->fname = $users->first_name;

                $user->lname = $users->last_name;

                $user->billing_address1 = $billing_information->billing_address1;

                $user->city = $billing_information->billing_city;

                $user->country = $billing_information->billing_country;

                $user->zip_code = $billing_information->billing_zipcode;

                $user->state = $billing_information->billing_state;

                $user->location = $users->location;

                $user->last_name = $users->last_name;

                $user->email = $users->email;

                $user->phone = $users->phoneNumber;

                $user->discount = $users->discount;

            } else {


                $users = DB::table("traveler_info")->where("request_id", "=", $id)->select("traveler_fname", "traveler_lname", "traveler_email")->first();

                $information = DB::table("billing_info")->where("request_id", "=", $id)->select("billing_country", "billing_address1", "billing_city", "billing_state", "billing_zipcode")->get();

               
                $information = $information[0];

                $user->fname = $users->traveler_fname;

                $user->lname = $users->traveler_lname;

                $user->email = $users->traveler_email;

                $user->discount = 0;


            }


            $orders = DB::table('tblpending_requests')
                ->select('tblpending_requests.request_id', 'tblpending_requests.user_id')
                ->where('tblpending_requests.user_id', '=', $bookingDetail->user_id)->get();
            $total_orders = count($orders);

            $hotel = DB::table("hotel")->where("hotelCode", $bookingDetail->hotelCode)->select("name", "address", "city", "state", "phone")->first();

            $title = 'Booking Detail';


            return view("dashboard.booking_detail", compact("user", "bookingDetail", "information", "hotel", "title", "policy", "total_orders"));

        }
        else{
            return redirect('admin/bookings');
        }
    }


	public function changenotes(Request $request){

	    $notes = $request->notes;

	    $id = $request->ID;
       $reference_number = '';
	     DB::table('tblbooking')
             ->where('request_id','=',$id)
             ->limit(1)
            ->update(array('notes' => $notes));

       $data = DB::table('tblbooking')
           ->where('tblbooking.request_id','=',$id)
           ->select('booking_reference_no')
           ->get();
         $value = $data[0];
         if($value->booking_reference_no){
             $reference_number = $value->booking_reference_no;
         }
         else{
             $reference_number='';
         }
         $timeStamp = date("YmdTh:i:s");

	      $xml = '<?xml version="1.0" encoding="utf-8" ?>
                    <modifyReservationRequest>
                    <control>
                    <userName>'. Helper::api()->api_user .'</userName>
                    <passWord>'. Helper::api()->api_password .'</passWord>
                    </control>
                    <modifyReservationDetails timeStamp="'.$timeStamp.'" modifyType="amendNotes">
                    <referenceNo>' . $reference_number .'</referenceNo>
                        <confirmationType>CON</confirmationType>
                    <newComment> 
                    <customer>'.$notes.'</customer>
                    </newComment>		
                    </modifyReservationDetails>
                    </modifyReservationRequest>';


         $url = $this->provider . "bonotelapps/bonotel/reservation/GetModifyReservation.do";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        $result = curl_exec($ch);

        $xmlNotes = @simplexml_load_string($result);


        if (empty($xmlNotes)) {

            return redirect()->to("500");

        }
        $att = $xmlNotes->attributes();

         if($att['status']=='Y'){
              $obj = array();
              $obj['status'] = true;
              $obj['alert'] = "Notes are added successfully to system";
             echo json_encode($obj);
             exit;
         }

         elseif($att['status']=='N'){
             $obj = array();
             $obj['status'] = true;
             $obj['alert'] = "Notes are not added  to system";
             echo json_encode($obj);
             exit;
         }



    }

	/*==================== end function to display selected booking detail ===============*/

	

	/*======================== function to approve a booking ============================*/

	public function approved(Request $request,$id){
        $today_date = date("Y-m-d");
        /*==== get data from db for reservation against users====*/
        $bookingDetail = DB::table("tblpending_requests")->where("tblpending_requests.request_id", "=", $id)->select("tblpending_requests.*")->first();
//        dd($today_date, $bookingDetail->chekIn);
        if ($today_date > $bookingDetail->chekIn) {
            return redirect()->to("admin/bookings")->with("error","Date passed booking can not be approved now");
        }else{
            /*==== request to APi for booking====*/
            $roomDate = "";
            $Adltocopancy = "";
            $Childocopancy = "";
            $requestXml = "";
            $checkIn = date("d-M-Y", strtotime($bookingDetail->chekIn));
            $checkOut = date("d-M-Y", strtotime($bookingDetail->checkOut));
            /*======= this for revervation the rooms====*/
            $timeStamp = date("Ymd") . "T" . date("h:i:s");
            $requestXml = '<?xml version="1.0" encoding="utf-8" ?>
		<reservationRequest>
		<control>
		<userName>' . Helper::api()->api_user . '</userName>
		<passWord>' . Helper::api()->api_password . '</passWord>
		</control>
		<reservationDetails timeStamp = "' . $timeStamp . '">
		<confirmationType>CON</confirmationType>
		<tourOperatorOrderNumber>123456</tourOperatorOrderNumber>
		<checkIn>' . $checkIn . '</checkIn>
		<checkOut>' . $checkOut . '</checkOut>
		<noOfRooms>' . $bookingDetail->no_rooms . '</noOfRooms>
		<noOfNights>' . $bookingDetail->no_nights . '</noOfNights>
		<hotelCode>' . $bookingDetail->hotelCode . '</hotelCode>';
            $count = 0;
            $totalRate = 0;
            $totalTax = 0;
            $requestXml1 = "";
            $rNoArr = explode(",", $bookingDetail->roomNo);
            $rTypeCode = explode(",", $bookingDetail->roomTypeCode);
//            $rTypeArr = explode(",", $bookingDetail->roomTypeCode);
            $roomeCode = explode(",", $bookingDetail->roomCodes);
            $bedTypeCode = explode(",", $bookingDetail->bedTypeCode);
            $ratePlanCode = explode(",", $bookingDetail->ratePlanCode);
            $adults = explode(",", $bookingDetail->adults);
            $children = explode(",", $bookingDetail->children);
            $totalTax = explode(",", $bookingDetail->tax);
            $tTax = 0;
            foreach ($totalTax as $tax) {
                $tTax += $tax;
            }
            for ($j = 0; $j < $bookingDetail->no_rooms; $j++) {
                $requestXml1 .= '<roomData>
			<roomNo>' . $rNoArr[$j] . '</roomNo>
			<roomCode>' . $roomeCode[$j] . '</roomCode>
			<roomTypeCode>' . $rTypeCode[$j] . '</roomTypeCode>
			<bedTypeCode>' . $bedTypeCode[$j] . '</bedTypeCode>
			<ratePlanCode>' . $ratePlanCode[$j] . '</ratePlanCode>';
                $requestXml1 .= '<noOfAdults>' . $adults[$j] . '</noOfAdults>';
                $co = $adults[$j];
                for ($ad = 1; $ad <= $co; $ad++) {
                    $Adltocopancy .= '<guest>
				<title>Mr</title>
				<firstName>adult' . $ad . 'fname</firstName>  
				<lastName>adult' . $ad . 'lname</lastName>
				</guest>';
                }
                $requestXml1 .= '<noOfChildren>' . $children[$j] . '</noOfChildren>';
                $chkchild = $children[$j];
                if ($chkchild > 0) {
                    for ($l = 1; $l <= $chkchild; $l++) {
                        $Childocopancy .= '<guest>
					<title>child' . $l . '</title>
					<firstName>child' . $l . 'fname</firstName>
					<lastName>child' . $l . 'lname</lastName>
					<age>' . $l . '</age>
					</guest>';
                    }
                }
                $requestXml1 .= '<occupancy>' . $Adltocopancy . $Childocopancy;
                $requestXml1 .= '</occupancy>
			</roomData>';
                $Adltocopancy = "";
                $Childocopancy = "";
            }
            $requestXml .= '<total currency = "USD">' . $bookingDetail->apiRoomRate . '</total>

		<totalTax currency = "USD">' . $tTax . '</totalTax>' . $requestXml1;

            $requestXml .= '<comment>
		<hotel>'.$bookingDetail->hotel_name.'</hotel>
		<customer>guest</customer>
		</comment>
		</reservationDetails>
		</reservationRequest>';

            //echo $requestXml; exit;

            $url = $this->provider . 'bonotelapps/bonotel/reservation/GetReservation.do';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml);

            $results = curl_exec($ch);

            $xmlObj = @simplexml_load_string($results);

            if (empty($xmlObj)) {

                return redirect()->to("500");

            }

            $stdObj = json_decode(json_encode($xmlObj));
            $status = "";

            foreach ($stdObj as $item) {
                if ($item->status) {
                    $status = $item->status;
                    break;

                }
            }
            if ($status == "N") {
                $stats = $status;
                $errorCode = $xmlObj->errors->code;
                $errorDesc = $xmlObj->errors->description;
                return redirect()->to("admin/bookings")->with("error", "Booking failed. Error Description :" . $errorDesc[0]);

            } elseif ($status == "Y") {
                $stats = $status;
                $referencNo = $xmlObj->referenceNo;
                $RoomRerenceNo = "";
                foreach ($xmlObj->roomReferenceDetails as $ref) {
                    if (count($ref->roomReferenceNo) > 1) {
                        foreach ($ref as $r) {
                            $RoomRerenceNo .= $r . ',';
                        }
                    } else {
                        $RoomRerenceNo .= $ref->roomReferenceNo . ',';
                    }
                }
                /********* update data into booking table ***********/

                $bookdate = date("Y-m-d H:i:s");

                $statusCon = "Confirmed";

                DB::table("tblbooking")->where("request_id", "=", $id)->update(["booking_date" => $bookdate,

                    "booking_reference_no" => $referencNo, "booking_room_reference_no" => $RoomRerenceNo, "booking_status" => $statusCon]);

                /********* insert data into pending booking table ***********/

                DB::table("tblpending_requests")->where("request_id", "=", $bookingDetail->request_id)->update(["is_pending" => 0]);

                /*===== send email to the users to approval=====*/

                $emailObj = "";

                $email = new \stdClass();

                if ($bookingDetail->is_visitor == 0) {

                    $emailObj = DB::table("tblusers")->select("*")->where('id', $bookingDetail->user_id)->first();

                    $email->mailName = $emailObj->first_name;

                    $email->mailEmail = $emailObj->email;

                } else {

                    $emailObj = DB::table("traveler_info")->select("*")->where('request_id', $id)->first();

                    $email->mailName = $emailObj->traveler_fname . " " . $emailObj->traveler_lname;

                    $email->mailEmail = $emailObj->traveler_email;

                }

                \Mail::send('mails.approval', array('reffrence' => $referencNo), function ($message) use ($email) {
                    $message->from('info@travellinked.com', 'Travel Linked');

                    $message->to($email->mailEmail, $email->mailName)
                        ->subject('Booking request approved!');

                });

                return redirect()->back()->with("success", "Booking has been approved successfully!");

            } else {

                return redirect()->back()->with("error", "Unknown error please try again!");

            }

        }
    }

	/*======================== end function to approve a booking =======================*/

	

	/*======================== function to decline a booking ===========================*/

	public function bookingDecline($id)

	{
		$decline = DB::select("SELECT tp.*,tb.*,rb.* FROM tblpending_requests tp INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.request_id = '$id'");

		$decline = $decline[0];

		$transID = $decline->bookingID;

		$bookID = $decline->booking_id;	


		/*====================== refund payment also ============================*/

		\Stripe\Stripe::setApiKey("sk_test_5UDILxpSajcREGk3jpGpbD44");

		$re = \Stripe\Refund::create(array(
				"charge" => $transID.''
		));

		if($re->status == "succeeded")
		{

			DB::table("room_booking")->where("request_id","=",$id)

				->update(["refund_id"=>$re->id,"is_refunded"=>1,"is_deleted"=>1]);

			

			DB::table("tblbooking")->where("request_id","=",$id)

				->update(["is_canceled"=>1,"is_deleted"=>1, "booking_status"=>'canceled']);

             DB::table("room_booking")->where('request_id',$id)
                 ->update(["status"=>'canceled']);

			DB::table("tblpending_requests")->where("request_id","=",$id)

				->update(["is_deleted"=>1]);

			return redirect()->back()->with("success","Booking order is successfully canceled and payment also refunded");

		}

		else
		{
			return redirect()->back()->with("error","Failed to refund and ".$result->message);

		}

	}

	/*======================== end function to decline a booking ================*/

	

	/*============================ function to get filtered records ======================*/

	public function get_bookings_filtered(Request $request)
    {

	    $user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
        $status = $request->Filter;


        if($status=='Canceled'){


            $allBooking = DB::table('tblbooking')
                ->join('tblpending_requests', 'tblbooking.request_id', '=', 'tblpending_requests.request_id')
                ->select('tblpending_requests.*', 'tblbooking.*')
                ->where('tblbooking.booking_status', '=', 'canceled')
                ->get();
            
            $html = Helper::getFilterBookingsRecord($allBooking);


            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;
             }
        elseif($status=='Pending'){

             $allBooking = DB::table('tblbooking')
                ->join('tblpending_requests', 'tblbooking.request_id', '=', 'tblpending_requests.request_id')
                ->select('tblpending_requests.*', 'tblbooking.*')
                ->where('tblbooking.booking_status', '=', 'pending')
                ->get();


            $html = Helper::getFilterBookingsRecord($allBooking);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;

        }
        elseif($status=='Approved'){

            $allBooking = DB::table('tblbooking')
                ->join('tblpending_requests', 'tblbooking.request_id', '=', 'tblpending_requests.request_id')
                ->select('tblpending_requests.*', 'tblbooking.*')
                ->where('tblbooking.booking_status', '=', 'Confirmed')
                ->get();
            $html = Helper::getFilterBookingsRecord($allBooking);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;

        }
        else{

            $allBooking = DB::table('tblbooking')
                ->join('tblpending_requests', 'tblbooking.request_id', '=', 'tblpending_requests.request_id')
                ->select('tblpending_requests.*', 'tblbooking.*')
                ->get();

            $html = Helper::getFilterBookingsRecord($allBooking);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;
        }






	}

	/*=========================== end function to get filtered records ===================*/



	/*======================== function to decline a booking ===========================*/

	public function createBooking(Request $request)

	{

		$title = 'Create Booking';

		return view('dashboard.createbooking',compact('title'));

	}

	/*======================== end function to decline a booking ================*/	

}









