<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Tbluser;

use App\Helpers\Helper;

use Illuminate\Support\Facades\Input;

use DB;


use App\Http\Controllers\Controller;

class UserController extends Controller

{

	/*============================= controller constructor ===============================*/

	public function __construct()
	{

    }
    public function index(Request $request)
    {
        return view('dashboard.users');
    }


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
        $query_value = $request->query();
        $query_resulted = $query_value['value'];
        $sEcho =$request->get('sEcho');
        $start = $request->get('iDisplayStart');
        $limit = $request->get('iDisplayLength');
        $search = $request->get('sSearch');
        $ord = $request->get('sSortDir_0');
        $ord_col = $request->get('iSortCol_0');
//        dd($sEcho, $start, $limit,$search, $ord, $ord_col);
        if ($ord_col == '0'){
            $ord_col = "id";
        }
        elseif ($ord_col == '1'){
            $ord_col = "country";
        }
//      elseif ($ord_col == '3'){
//            $ord_col = 'booking';
//        } elseif ($ord_col == '4'){
//            $ord_col = 'last_booking';
//        } elseif ($ord_col == '5'){
//            $ord_col = 'total';
//        }
//        $order_by = $ord_col."','".$ord;
        $order_col = $ord_col;
        $orderby = $ord;
        $data = array();
        $users = Tbluser::users($order_col ,$orderby ,$limit,$start, $search,$query_resulted);
        $display = count($users);

        $counter = $start;
        foreach ($users as $i =>  $user) {
                    $data[$i]['id']='<a href="' .url("admin/viewUser") ."/".$user['id']. '">'.$user['userName'].'</a>';
                    $data[$i]['country'] =$user['location'];
                    $data[$i]['booking'] = $user['totalBooking'];
                    $data[$i]['last_booking'] = Helper::priceFormate($user['lastBooking']);
                    $data[$i]['total'] = Helper::priceFormate($user['totalBookingPrice']);
                    if($user["status"] == 1) {
                        $temp = 'Active'; 
                    }else{
                        $temp= "Deactive";
                    }
                    if ($user["status"] == 1){
                        $temp2 = '<a onclick="userAction(\'deactive\', '.$user['id'].')">Deactive</a>';
                    }  else{
                        $temp2 =  '<a onclick="userAction(\'active\', '.$user['id'].')">Active</a>';
                    }
                        $data[$i]['status'] = '<div class="approve-decline btn-group">
                                                <span class="apprDec" data-toggle="dropdown" style="cursor:pointer";>'. $temp.'</span>
                                                 <ul role="menu" class="dropdown-menu animated fadeInLeft">
                                                    <li>'.$temp2 .'</li>
                                                    <li><a href="#">Email Client</a> </li>
                                                    <li><a href="#" onclick="deleteuser('.$user['id'].')" >Delete</a></li>
                                                </ul>
                                              </div>';

//                    $data[$i]['status'] = $user['status'];

        }

        $results = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => (int) $display,
            "iTotalDisplayRecords" => (int) $display,
            "aaData"=>$data);
        echo json_encode($results);

	}
  public function deleteUser(Request $request){
         $id = $request->id;
         $user = Tbluser::find($id);
         $user->delete();

  }
	public function viewUser($id){

	    $user = Tbluser::find($id);
//        dd($user);
	    if(!$user){
	        return "user not exists";
        }
        else{
           $customers = DB::select('SELECT tblpending_requests . * , tblusers . *  FROM tblpending_requests
           INNER JOIN tblusers ON tblpending_requests.user_id = tblusers.id
           WHERE tblusers.id ='.$user->id .' order by tblpending_requests.request_id desc');
             if(!$customers){
                 return view('dashboard.view_customer', compact('user','obj','array'));
             }
             $sum = 0;
             $counter =1;
             $obj = array();


                    $obj['last_order'] = $customers[0]->created_at;
                    $obj['last_order'] = '';
        $array = array();
            foreach ($customers as $customer){
                $sum = $sum + $customer->total_amount;

                $obj['location'] = $customer->hotel_city;
                $obj['hotel_address'] = $customer->hotel_address;
                $obj['total_ammount'] = $customer->total_amount;
                $obj['information'] = $customer->bookingDate;
                $obj['request_id'] = $customer->request_id;
                $array[] = $obj;
                $counter++;
             }
           
              $obj['allorders'] = count($customers);

              $order = count($customers)-1;
              $last_order = $customers[$order];
              $obj['last_order_time'] = $last_order->created_at;
              $obj['userType'] = $user->userType;
              $obj['average_order'] = $sum/$counter;
              $obj['tota_sum'] = $sum;
              $obj['userName'] = $user->first_name.' '. $user->last_name;
              $obj['discount'] = $user->discount;
              $obj['email']  = $user->email;
              $obj['country'] = $user->country;
              $obj['phoneNumber'] = $user->phoneNumber;
              $obj['id'] =$user->id;

            return view('dashboard.view_customer', compact('obj','array'));
          }
  }

  public function editUser($id){

	    $user = Tbluser::find($id);

	    return view('dashboard.edit_user', compact('user'));

  }

    public function updateUser($id, Request $request){

        $user = Tbluser::find($id);
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

	/*======================= end function to load view to display all users =============*/



	/*=========================== function to disable a user =============================*/

	public function LockScreen(Request $req)
   {
       $req->session()->set('isLock', 'true');
       $req->session()->save();
       return \Redirect::back();
   }
      public function ShowLockScreen(){

             return view('dashboard.Lock_user');

      }
	 public function disableUser(Request $request)

    {


		$status =  $request->input("status");

		$id =  $request->input("id");



		if($status == "active")

		{


			$sts = 1;

			$users = Tbluser::where("id","=",$id)->update(["status"=>$sts]);


      }

		elseif($status=="deactive")

		{



			$sts = 0;

			$users = Tbluser::where("id","=",$id)->update(["status"=>$sts]);



		}

	}


	public function insertUser(Request $request){

        $validator = \Validator::make($request->all(), [

            'fname' => 'required|max:255',
            'email' => 'required|email|min:5',
            'address'=>'required',
            'country'=>'required',

         ]);

        if ($validator->fails()) {
            return redirect('admin/create/customer')
                ->withErrors($validator)
                ->withInput();
        }

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
              $title = $request->title;
              if($title==1){
                  $title ='Mr';
              }
              elseif($title==0){
                  $title = 'Mrs';
              }
              $user->title = $title;
              $user->password= \Hash::make($request->pass);
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
