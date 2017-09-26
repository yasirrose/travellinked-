<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;
use App\Tbluser;

use App\Helpers\Helper;

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


		$data = DB::select("SELECT tp.*,tb.*,rb.* FROM tblpending_requests tp INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.request_id = '$id'");

		$data = $data[0];

		$transID = $data->bookingID;

		$bookID = $data->booking_id;

		$timeStamp = date("YmdTh:i:s");

		$xml = '<?xml version="1.0" encoding="utf-8" ?>

		<cancellationRequest timestamp="'.$timeStamp.'">

		<control>

		<userName>'.Helper::api()->api_user.'</userName>

		<passWord>'.Helper::api()->api_password.'</passWord>

		</control>

		<supplierReferenceNo>'.$data->booking_reference_no.'</supplierReferenceNo>

		<cancellationReason/>

		<cancellationNotes>selected a different hotel.</cancellationNotes>

		</cancellationRequest>';



		$url = $this->provider."bonotelapps/bonotel/reservation/GetCancellation.do";

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );

		curl_setopt( $ch, CURLOPT_POST, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml );

		$result = curl_exec($ch);

		$xmlCancel = @simplexml_load_string($result);

		if(empty($xmlCancel))

		{

			return redirect()->to("500");

		}

		$stdObj = json_decode(json_encode($xmlCancel));

		$status = "";

		foreach ($stdObj as $item)

		{

			if($item->status)

			{

				$status = $item->status;

				break;

			}

		}

		if($status == "N")

		{

			$stats = $status;

			$errorCode = $xmlCancel->errors->code;

			$errorDesc = $xmlCancel->errors->description;

			return redirect()->to("admin/bookings")->with("error","Booking failed. Error Description :".$errorDesc[0]);

		}

		elseif($status == "Y")

		{

			$stdObj = json_decode(json_encode($xmlCancel));

			DB::table("tblbooking")->where("request_id","=",$id)

				->update(["cancellationNo"=>$stdObj->cancellationNo,"is_canceled"=>1]);

			/*====================== refund payment also ============================*/

			\Stripe\Stripe::setApiKey("sk_test_5UDILxpSajcREGk3jpGpbD44");

			$re = \Stripe\Refund::create(array(
					"charge" => $transID.''
			));
			if($re->status == "succeeded")

			{

				DB::table("room_booking")->where("request_id","=",$id)

				->update(["refund_id"=>$re->id,"is_refunded"=>1]);

				return redirect()->back()->with("success","Booking order is successfully canceled and payment also refunded");

			}

			else

			{

				return redirect()->back()->with("success","Booking order is successfully canceled but transaction refund <failed></failed>");

			}

			/*====================== refund payment also ============================*/

		}

		else

		{

			return redirect()->back()->with("error","Booking Cancellation unknown error, please try again!");

		}

	}

	/*============================ end function to cancel booking by admin ===============*/

	

	/*============================ function to display all bookings ======================*/

	public function Bookings()

	{

		$regBooking = DB::select("SELECT tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,u.first_name as name,u.email,tb.*,rb.* FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 0 ORDER BY tb.booking_id DESC");



		$gestBooking = DB::select("SELECT tp.is_visitor,tp.request_id,tp.is_pending,tp.user_id,t.traveler_fname,t.traveler_lname,t.traveler_email

		,tb.*,rb.* FROM tblpending_requests tp INNER JOIN traveler_info t ON tp.request_id = t.request_id INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.is_visitor = 1 ORDER BY tb.booking_id DESC");

		/*==== merge both table data====*/		

		$collection = collect($regBooking);

		$merged = $collection->merge($gestBooking);

		$allBooking = $merged->all();

		$title = 'Bookings';

		return view("dashboard.pending_booking",compact("allBooking","title"));

	}

	/*=========================== end function to display all bookings ===================*/

	

	/*======================== function to display selected booking detail ===============*/

	public function bookingDetail($id)

	{

		$bookingDetail1 = DB::select("SELECT tp.*,tb.*,rb.* FROM tblpending_requests tp INNER JOIN tblbooking tb ON tp.request_id = tb.request_id JOIN room_booking rb ON tp.request_id = rb.request_id WHERE tp.request_id = '$id'");

		$bookingDetail = $bookingDetail1[0];

		$user =  new \stdClass();

		if(count($bookingDetail1) > 0 && $bookingDetail->is_visitor == 0)

		{			

			$users = DB::table("tblusers")->where("id","=",$bookingDetail->user_id)->select("first_name","email")->first();	

			$user->fname = 	$users->first_name;

			$user->lname =	"";

			$user->email = 	$users->email;

		}

		else

		{

			$users = DB::table("traveler_info")->where("request_id","=",$id)->select("traveler_fname","traveler_lname","traveler_email")->first();

			$user->fname = 	$users->traveler_fname;

			$user->lname =	$users->traveler_lname;

			$user->email = 	$users->traveler_email;				

		}			

		$hotel = DB::table("hotel")->where("hotelCode",$bookingDetail->hotelCode)->select("name","address","city","state","phone")->first();

		$title = 'Booking Detail';

		return view("dashboard.booking_detail",compact("user","bookingDetail","hotel","title"));

	}

	/*==================== end function to display selected booking detail ===============*/

	

	/*======================== function to approve a booking ============================*/

	public function approved(Request $request,$id)

	{	

		/*==== get data from db for reservation against users====*/

		$bookingDetail = DB::table("tblpending_requests")->where("tblpending_requests.request_id","=",$id)->select("tblpending_requests.*")->first();			

		/*==== request to APi for booking====*/

		$roomDate = "";

		$Adltocopancy = "";

		$Childocopancy = "";

		$requestXml = "";

		$checkIn = date("d-M-Y",strtotime($bookingDetail->chekIn));

		$checkOut = date("d-M-Y",strtotime($bookingDetail->checkOut));

		/*======= this for revervation the rooms====*/

		$timeStamp = date("Ymd")."T".date("h:i:s");

		$requestXml = '<?xml version="1.0" encoding="utf-8" ?>

		<reservationRequest>

		<control>

		<userName>'.Helper::api()->api_user.'</userName>

		<passWord>'.Helper::api()->api_password.'</passWord>

		</control>

		<reservationDetails timeStamp = "'.$timeStamp.'">

		<confirmationType>CON</confirmationType>

		<tourOperatorOrderNumber>123456</tourOperatorOrderNumber>

		<checkIn>'.$checkIn.'</checkIn>

		<checkOut>'.$checkOut.'</checkOut>

		<noOfRooms>'.$bookingDetail->no_rooms.'</noOfRooms>

		<noOfNights>'.$bookingDetail->no_nights.'</noOfNights>

		<hotelCode>'.$bookingDetail->hotelCode.'</hotelCode>';



		$count = 0;

		$totalRate = 0;

		$totalTax = 0;

		$requestXml1 = "";

		$rNoArr =  explode(",",$bookingDetail->roomNo);

		$rTypeCode =  explode(",",$bookingDetail->roomTypeCode);

		$rTypeArr = explode(",",$bookingDetail->roomTypeCode);

		$roomeCode = explode(",",$bookingDetail->roomCodes);

		$bedTypeCode = explode(",",$bookingDetail->bedTypeCode);

		$ratePlanCode = explode(",",$bookingDetail->ratePlanCode);

		$adults = explode(",",$bookingDetail->adults);

		$children  = explode(",",$bookingDetail->children);

		$totalTax = explode(",",$bookingDetail->tax);

		$tTax = 0;

		foreach($totalTax as $tax)

		{

			$tTax += $tax;

		}

		for($j = 0; $j < $bookingDetail->no_rooms;  $j++)

		{

			$requestXml1  .= '<roomData>

			<roomNo>'.$rNoArr[$j].'</roomNo>

			<roomCode>'.$roomeCode[$j].'</roomCode>

			<roomTypeCode>'.$rTypeCode[$j].'</roomTypeCode>

			<bedTypeCode>'.$bedTypeCode[$j].'</bedTypeCode>

			<ratePlanCode>'.$ratePlanCode[$j].'</ratePlanCode>'; 

			$requestXml1  .= '<noOfAdults>'.$adults[$j].'</noOfAdults>';

			$co = $adults[$j];

			for($ad = 1; $ad <= $co; $ad++)

			{

				$Adltocopancy  .= '<guest>

				<title>Mr</title>

				<firstName>adult'.$ad.'fname</firstName>

				<lastName>adult'.$ad.'lname</lastName>

				</guest>';

			}

			

			$requestXml1  .= '<noOfChildren>'.$children[$j].'</noOfChildren>';

			$chkchild = $children[$j];

			if($chkchild > 0)

			{

				for($l = 1; $l<= $chkchild; $l++)

				{	 

					$Childocopancy .= '<guest>

					<title>child'.$l.'</title>

					<firstName>child'.$l.'fname</firstName>

					<lastName>child'.$l.'lname</lastName>

					<age>'.$l.'</age>

					</guest>';

				}

			}

			$requestXml1  .=  '<occupancy>'.$Adltocopancy.$Childocopancy;

			$requestXml1 .= '</occupancy>

			</roomData>';

			$Adltocopancy = "";

			$Childocopancy = "";

		}

		$requestXml  .= '<total currency = "USD">'.$bookingDetail->total_amount.'</total>

		<totalTax currency = "USD">'.$tTax.'</totalTax>'.$requestXml1;

		$requestXml .= '<comment>

		<hotel></hotel>

		<customer></customer>

		</comment>

		</reservationDetails>

		</reservationRequest>';

		//echo $requestXml; exit;

		$url = $this->provider.'bonotelapps/bonotel/reservation/GetReservation.do';

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url);

		curl_setopt( $ch, CURLOPT_POST, true);

		curl_setopt( $ch, CURLOPT_HTTPHEADER,array('Content-Type: text/xml'));

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $requestXml);

		$results = curl_exec($ch);
		








		$xmlObj = @simplexml_load_string($results);

		if(empty($xmlObj))

		{

			return redirect()->to("500");

		}

		$stdObj = json_decode(json_encode($xmlObj));

		$status = "";

		foreach ($stdObj as $item)

		{

			if($item->status)

			{

				$status = $item->status;

				break;

			}

		}

		if($status == "N")

		{

			$stats = $status;

			$errorCode = $xmlObj->errors->code;

			$errorDesc = $xmlObj->errors->description;

			return redirect()->to("admin/bookings")->with("error","Booking failed. Error Description :".$errorDesc[0]);

			exit;

		}

		elseif($status == "Y")

		{

			$stats = $status;

			$referencNo = $xmlObj->referenceNo;

			$RoomRerenceNo = "";

			foreach($xmlObj->roomReferenceDetails as $ref)

			{ 

				if(count($ref->roomReferenceNo) > 1)

				{

					foreach($ref as $r)

					{

						$RoomRerenceNo .= $r.',';

					}

				}

				else

				{

					$RoomRerenceNo .= $ref->roomReferenceNo.',';

				}

			}

			/********* update data into booking table ***********/

			$bookdate = date("Y-m-d H:i:s");

			$statusCon = "Confirmed";

			DB::table("tblbooking")->where("request_id","=",$id)->update(["booking_date"=>$bookdate,

			"booking_reference_no"=>$referencNo,"booking_room_reference_no"=>$RoomRerenceNo,"booking_status"=>$statusCon]);

			/********* insert data into pending booking table ***********/

			DB::table("tblpending_requests")->where("request_id","=",$bookingDetail->request_id)->update(["is_pending"=>0]);

			/*===== send email to the users to approval=====*/

			$emailObj ="";

			$email = new \stdClass();

			if($bookingDetail->is_visitor == 0)

			{

				$emailObj = DB::table("tblusers")->select("*")->where('id',$bookingDetail->user_id)->first();

				$email->mailName = $emailObj->first_name;

				$email->mailEmail = $emailObj->email;

			}

			else

			{

				$emailObj = DB::table("traveler_info")->select("*")->where('request_id',$id)->first();

				$email->mailName = $emailObj->traveler_fname." ".$emailObj->traveler_lname;

				$email->mailEmail = $emailObj->traveler_email;

			}

			\Mail::send('mails.approval', array('reffrence' => $referencNo), function($message) use ($email)

			{   $message->from('info@travellinked.com', 'Travel Linked');

				$message->to($email->mailEmail,$email->mailName)

				->subject('Booking request approved!');

			});

			return redirect()->back()->with("success","Booking has been approved successfully!");

		}

		else

		{

			return redirect()->back()->with("error","Unknown error please try again!");

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

				->update(["is_canceled"=>1,"is_deleted"=>1]);

			

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









