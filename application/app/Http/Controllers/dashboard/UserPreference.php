<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Tbluser;
use App\Reservation;
use App\Destinations;
class UserPreference extends Controller
{
	private $APiUser ;
	private $ApiPassword;
	public function __construct()
	{
		//$this->APiUser = "luxVarTest_Xml";
		//$this->ApiPassword = "9kun3WP22K6GYuJ8";
		$this->APiUser = "luxVaRLive_xml";
		$this->ApiPassword = "ZGMA4bE2MBSh89qe";
	}
	public function TripSetting(Request $request){
		$activeID = 'Trip';
		return view('UserPreference.trip')->with('activeID', $activeID);
	}
	public function BillInformation(Request $request){
		$activeID = 'billing';
		return view('UserPreference.BillInformation')->with('activeID', $activeID);
	}
	public function MyProfile(Request $request){
		$activeID = 'profile';
		$user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
		return view('UserPreference.profile', compact('activeID', 'user'));

	}
	public function updateProfile(Request $request){
		$user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
		$user->title = $request->input('title');
		$user->location = $request->input('location');
		$user->first_name = $request->input('firstname');
		$user->last_name = $request->input('lastname');
		$user->phoneNumber = $request->input('phoneNumber');
		$user->email = $request->input('email');
		$user->userType = $request->input('type');

		if($request->input('year')!='-1' && $request->input('month')!='-1' && $request->input('day')!='-1'){
			$year = $request->input('year');
			$month = $request->input('month');
			$day = $request->input('day');
			$date = Carbon::createFromDate($year, $month, $day, 'America/Vancouver');
			$user->birthday = $date;
		}

		$user->save();
		return redirect('/user/profile');
	}
	public function deactivateAccount(Request $request){
		$user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
		$user->is_activated = 0;
		$user->save();
		return redirect('/user_logout');
	}
	public function Travelers(Request $request){
		$activeID = 'travelers';
		return view('UserPreference.Travelers')->with('activeID', $activeID);
	}

    public function AllReservations(){

        $activeID = 'reservation';
        $user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
        $reservations = DB::table('tblbooking')
            ->join('hotel', 'tblbooking.hotelCode', '=', 'hotel.hotelCode')
            ->join('tblpending_requests' , 'tblpending_requests.request_id','=','tblbooking.request_id')
            ->select('tblbooking.*', 'hotel.*', 'tblpending_requests.total_amount')
            ->where('tblpending_requests.user_id','=', $user->id)
            ->get();

         return view('UserPreference.reservation', compact('activeID','reservations'));

    }

    private static function getTravelerName($id){
        $row = DB::table('traveler_info')->where('request_id', '=', $id)->first();
        return $row->traveler_fname.' '.$row->traveler_lname;
    }
	public function ChangePassword(Request $request){
    $activeID = 'password';
		return view('UserPreference.password')->with('activeID', $activeID);
	}
	public function BillingInformation(Request $request){

	}
	public function History(Request $request){
		$activeID = 'history';
		return view('UserPreference.History')->with('activeID', $activeID);
	}
	public function CancelBooking($bookingID){

		$user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
    $deduction_ammount = 500;
	  $user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
    $record = DB::select('SELECT tblpending_requests . * , tblbooking.booking_status,tblbooking.booking_id, tblbooking.is_canceled FROM tblbooking INNER JOIN tblpending_requests ON tblpending_requests.request_id = tblbooking.request_id WHERE tblbooking.booking_id = '.$bookingID);
		$record = $record[0];
    $record->deduction_ammount = $deduction_ammount;
		$url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$record->hotelCode;
    $result1 = @file_get_contents($url1);
		$hotelPolicy = simplexml_load_string($result1);

		if($user->id == $record->user_id){
	  return view('UserPreference.CancelPolicy', compact("record","hotelPolicy"));
	}
	else  {
		return redirect('user/reservations');
	     }
 }
 public function viewBooking($booking_id){

	 $user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
	 $record = DB::select('SELECT tblpending_requests . * , tblbooking.booking_status,tblbooking.booking_id, tblbooking.is_canceled FROM tblbooking INNER JOIN tblpending_requests ON tblpending_requests.request_id = tblbooking.request_id WHERE tblbooking.booking_id = '.$booking_id);
   $record = $record[0];
   $url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$record->hotelCode;
   $result1 = @file_get_contents($url1);
	 $hotelPolicy = simplexml_load_string($result1);
	 $rating = $hotelPolicy->hotel->starRating;
	 $address = $hotelPolicy->hotel->address;
	 $hotels['image'] = (String)$hotelPolicy->hotel->images->image[0];
   $image  =      $hotels["image"];
	 $phone = $hotelPolicy->hotel->phone;
	 $description = $hotelPolicy->hotel->description;
	 $fax= $hotelPolicy->hotel->fax;
	 $facilities = $hotelPolicy->hotel->facilities;
	 $policy = $hotelPolicy->hotel->cancelPolicies;
	 $limitation_policy = $hotelPolicy->hotel->limitationPolicies;
   if($user->id == $record->user_id){
		 return view("UserPreference.viewBooking", compact("record","limitation_policy","facilities","image","rating","address","phone","fax","description","policy"));
	 }
	 else {
	   return false;
	 }
}
   public function UpdatePassword(Request $request){

		 $user = Tbluser::where('email', '=', session()->get('userEmail'))->first();
		 $rules = array(
        'currentPassword' => 'required|min:6',
        'password'         => 'required|min:6',
        'confirmPassword'   => 'required|min:6'
     );
    $validator = \Validator::make($request->all(), $rules);
	  if ($validator->fails()) {
     $messages = $validator->messages();
    return redirect('user/password')
			  		 ->withErrors($validator);
   }
	     $flag =  \Hash::check($request->currentPassword ,$user->password);
      if($flag){
				   $password =   \Hash::make($request->password);
           $checked =  \Hash::check($request->confirmPassword ,$password);
           if ($checked){
            $user->password = $password;
						$user->save();
						return redirect('user/password')->with('message', 'Password is Successfully Updated');
					}
					else {
						return redirect('user/password')->with('message', ' is not changed, Fill all fields correctly ');
					}
			}
			else {
				return redirect('user/password')->with('message', 'is not changed, Fill all fields correctly ');
			}

 }

 Public function getFilterRecord(Request $req){
	 $user = Tbluser::where('email', '=', session()->get('userEmail'))->first();

	 $status = $req->status;
	 $booking_id = $req->searchQuery;
	 $time = $req->time;
	 if($status=='0'){
		 if($booking_id==''){
			 $reservations = DB::table('tblbooking')
		 	->join('hotel', 'tblbooking.hotelCode', '=', 'hotel.hotelCode')
		 	->join('tblpending_requests' , 'tblpending_requests.request_id','=','tblbooking.request_id')
		 	->select('tblbooking.*', 'hotel.*', 'tblpending_requests.*')
		 	->where([['tblpending_requests.user_id','=', $user->id],['tblpending_requests.created_at', '>', Carbon::now()->subDays($time)]])
		 	->get();
		 }
		 else{
		 $reservations = DB::table('tblbooking')
	 	->join('hotel', 'tblbooking.hotelCode', '=', 'hotel.hotelCode')
	 	->join('tblpending_requests' , 'tblpending_requests.request_id','=','tblbooking.request_id')
	 	->select('tblbooking.*', 'hotel.*', 'tblpending_requests.*')
	 	->where([['tblpending_requests.user_id','=', $user->id],['tblpending_requests.created_at', '>', Carbon::now()->subDays($time)],['tblbooking.booking_id', 'like',$booking_id.'%']])
	 	->get();

		}
	 }
	 else if($booking_id==''){
		 $reservations = DB::table('tblbooking')
	 	->join('hotel', 'tblbooking.hotelCode', '=', 'hotel.hotelCode')
	 	->join('tblpending_requests' , 'tblpending_requests.request_id','=','tblbooking.request_id')
	 	->select('tblbooking.*', 'hotel.*', 'tblpending_requests.*')
	 	->where([['tblpending_requests.user_id','=', $user->id],['tblpending_requests.created_at', '>', Carbon::now()->subDays($time)], ['tblbooking.booking_status','=',$status]])
	 	->get();
	 }
	 else{
		 $reservations = DB::table('tblbooking')
		->join('hotel', 'tblbooking.hotelCode', '=', 'hotel.hotelCode')
		->join('tblpending_requests' , 'tblpending_requests.request_id','=','tblbooking.request_id')
		->select('tblbooking.*', 'hotel.*', 'tblpending_requests.*')
		->where([['tblpending_requests.user_id','=', $user->id],['tblpending_requests.created_at', '>', Carbon::now()->subDays($time)],['tblbooking.booking_id', 'like',$booking_id.'%'], ['tblbooking.booking_status','=',$status]])
		->get();
	 }

   $html = Helper::GetHtmlForReservation($reservations);
   $obj = array();
   $obj['status'] = true;
   $obj['html'] = $html;
   echo json_encode($obj);



 }

}
