<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Tbluser;

use App\Helpers\Helper;


use DB;


use App\Http\Controllers\Controller;

class UserController extends Controller

{

	/*============================= controller constructor ===============================*/

	public function __construct()

	{}



	/*=========================== function to load view to display all users =============*/
	public function getFilteredRecords(Request $req){
		$filter = $req->Filter;
		$users = Tbluser::get();
		$data = array();
		if($filter=='repeatedCustomer'){
	        foreach($users as $user){
	            $obj = array();
	            $bookingDetail = DB::table('tblbooking')->join('tblpending_requests', 'tblbooking.request_id', '=',  'tblpending_requests.request_id')->where('tblpending_requests.user_id','=',$user->id)->orderBy('tblbooking.booking_date', 'DESC')->get();
	            $obj['userName'] = $user->first_name.' '.$user->last_name;
	            $obj['location'] = $user->country.', '.$user->state;
	            $obj['totalBooking'] = count($bookingDetail);
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
							if($obj['totalBooking'] > 0){
								$data[] = $obj;
							}
	         }
				 }
				 else if('AllCustomers'){
					 foreach($users as $user){
							 $obj = array();
							 $bookingDetail = DB::table('tblbooking')->join('tblpending_requests', 'tblbooking.request_id', '=',  'tblpending_requests.request_id')->where('tblpending_requests.user_id','=',$user->id)->orderBy('tblbooking.booking_date', 'DESC')->get();
							 $obj['userName'] = $user->first_name.' '.$user->last_name;
							 $obj['location'] = $user->country.', '.$user->state;
							 $obj['totalBooking'] = count($bookingDetail);
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
							 $data[] = $obj;
						}
				 }
				 else if('B2CCustomers'){

				 }
				 else if('B2BCustomers'){

				 }
				 else if('Prospects'){

				 }
				 $html = Helper::GetHtmlFromCustomers($data);
				 $obj = array();
				 $obj['status'] = true;
				 $obj['html'] = $html;

				 echo json_encode($obj);
				 exit;
	}
	public function users(Request $request)
    {

		$title = 'Customers';

        $users = Tbluser::get();


        //Temporary ViewModel


        $data = array();
        foreach($users as $user){
            $obj = array();
            $bookingDetail = DB::table('tblbooking')->join('tblpending_requests', 'tblbooking.request_id', '=',  'tblpending_requests.request_id')->where('tblpending_requests.user_id','=',$user->id)->orderBy('tblbooking.booking_date', 'DESC')->get();
            $obj['userName'] = $user->first_name.' '.$user->last_name;
            $obj['location'] = $user->country.', '.$user->state;
            $obj['totalBooking'] = count($bookingDetail);
            $obj['id'] = $user->id;
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


            $data[] = $obj;

         }

        return view('dashboard.users',compact("data","title"));

	}

	public function viewUser($id){

	    $user = Tbluser::find($id);
	    if(!$user){
	        return "user not exists";
        }
        else{
           $customers = DB::select('SELECT tblpending_requests . * , tblusers . *  FROM tblpending_requests
           INNER JOIN tblusers ON tblpending_requests.user_id = tblusers.id
           WHERE tblusers.id ='.$user->id .' order by tblpending_requests.request_id desc');
             $sum = 0;
             $counter =1;
             $obj = array();
            foreach ($customers as $customer){
                $sum = $sum + $customer->total_amount;
                $location = $customer->hote_city .''. $customer->hotel_state;
                $counter++;
                   }
            $obj['last_order'] = $customers[0]->created_at;
            $obj['average_order'] = $sum/$counter;
            $obj['tota_sum'] = $sum;
           // $obj['userName'] = $user->first_name.' '.$user->last_name;

            return view('dashboard.view_customer', compact('obj'));
          }
  }

	/*======================= end function to load view to display all users =============*/



	/*=========================== function to disable a user =============================*/


	public function disableUser(Request $request)

    {

		$status =  $request->input("status");

		$id =  $request->input("user_id");

		if($status == "on")

		{

			$sts = 1;

			$users = Tbluser::where("id","=",$id)->update(["status"=>$sts]);

			return redirect()->back()->with("success","User Activated successfully");

		}

		else

		{

			$sts = 0;

			$users = Tbluser::where("id","=",$id)->update(["status"=>$sts]);

			return redirect()->back()->with("error","User disable successfully");

		}

	}


	public function insertUser(Request $request){


              $user = new Tbluser();
              $user->userType    = $request->userType;
              $user->first_name  = $request->fname;
              $user->last_name   = $request->lname;
              $user->email       = $request->email;
              $user->phoneNumber = $request->phoneNumber;
              $user->location =   $request->address;
              $user->location =   $request->address2;
              $user->country =   $request->country;
              $user->city =      $request->city;
              $user->state =    $request->state;
              $user->zip_code = $request->zip;
              $user->notes = $request->notes;
              $user->role = 1;
              $user->status = 1;
              $user->is_activated=1;
              $user->discount= $request->discount;
              $user->save();
              return redirect('/admin');

    }
	/*=========================== end function to disable a user ==========================*/

/*=========================== end UserController ==========================================*/

}
