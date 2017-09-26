<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use App\Deals;

use App\Destinations;
use App\Helpers\Helper;

use App\Http\Controllers\Controller;

class DealsController extends Controller

{

	/*============================= controller constructor ===============================*/

	public function __construct()

	{

		// $this->APiUser = "luxVarTest_Xml";

		// $this->ApiPassword = "9kun3WP22K6GYuJ8";

		$this->APiUser = Helper::api()->api_user;


		$this->ApiPassword = Helper::api()->api_password;

		

	}



	/*============================= function to load admin dashboard =====================*/

  private static function getFormatedData($deals){
    $data = array();
    foreach($deals as $item){
      $obj = array();
      $obj['deal_status'] = $item->is_active;
      $obj['id'] = $item->id;
      $obj['hotelName'] = $item->HotelName;
      $obj['location'] = DB::table('hotel')->where('hotelCode', '=', $item->HotelID)->first();
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


	public function index(Request $request)
	{
		return view('dashboard.alldeals');
	}

	public function loadDeals(Request $request){
//      dd($request->query());
//      dd(str_replace($request->url(), '',$request->fullUrl()));
        $query_value = $request->query();
         $query_resulted = $query_value['value'];
        $sEcho =$request->get('sEcho');
        $start = $request->get('iDisplayStart');
        $limit = $request->get('iDisplayLength');
        $search = $request->get('sSearch');
        $ord = $request->get('sSortDir_0');
        $ord_col = $request->get('iSortCol_0');
       if ($ord_col == '2'){
            $ord_col = 'HotelID';
       } elseif ($ord_col == '3'){
            $ord_col = 'HotelID';
       } elseif ($ord_col == '4'){
            $ord_col = 'created_at';
       }
        $order_col = $ord_col;
        $orderby = $ord;
        $data = array();
        $deals = Deals::loadDeals($order_col,$orderby,$limit,$start, $search,$query_resulted);
        $display =  $deals['totalRecords'];
//        dd($display);
//        $num =  $deals['count'];
        $counter = $start;
        foreach ($deals['alldeals'] as $i => $r) {
                $data[$i]['check'] = '<i class="fa fa-check"></i>';
                $data[$i]['priority'] = ++$counter;
                $data[$i]['HotelID'] = $r['hotelName'];
                $data[$i]['HotelID'] = $r['location'];
                $data[$i]['created_at'] = \Carbon\Carbon::parse($r['created_at'])->format('F jS,  Y');
                $data[$i]['CustomerSpecialCode'] = $r['dealName'];
                if ($r['deal_status'] == 0) {
                    $data[$i]['status'] = '<span class="text-danger">Inactive</span>';
                } else {
                    $data[$i]['status'] = '<span class="text-success">Active</span>';
                }
                $data[$i]['checkbox'] = '<form method="post" action=""><div class="checkbox c-checkbox"></div><input type="checkbox"></form>';
        }
        $results = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => (int) $display,
            "iTotalDisplayRecords" => (int) $display,
            "aaData"=>$data);
//        echo json_encode(array('aaData' => $data, 'iTotalDisplayRecords' => $display, 'iTotalRecords' => $display, 'sEcho' => $sEcho));
        echo json_encode($results);
    }

    public function getPaginatedModel($deals){
        $data = array();
        $data['totalPages'] = $deals->total();
        $data['currentPage'] = $deals->currentPage();
        $data['recordPerPage'] = $deals->perPage();
        $data['path'] = $deals->url($deals->currentPage() + 1);
        $data['data'] = Self::getFormatedData($deals);
        return $data;
    }

	/*============================= end function to load admin dashboard =================*/



	/*============================= function to load bonotel deals view ==================*/

	public function bonotelDeals(Request $request)

	{

		$title = 'Upload Bonotel Deals';

		return view('dashboard.bonoteldeals',compact('title'));

	}

	/*============================= end function to load bonotel deals view ==============*/



	/*============================= function to update deals in db =======================*/

	public function updateBonotelDeals(Request $request)

	{

		$timeStart = microtime(true);

		$url = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/specials";

		$result = @file_get_contents($url);

		if(empty($result))

		{

			return redirect()->to('admin/bonoteldeals')->with("error","Unable to retrieve deals from bonotel. please try again");

		}

		else

		{

			Deals::truncate();

			$xml = simplexml_load_string($result,'SimpleXMLElement', LIBXML_NOCDATA);

			$spArr = json_decode(json_encode($xml), true);

			foreach($spArr['special'] as $deal)

			{

				$dealObj = new Deals;

				$startObj = new \DateTime($deal['startDate1']);

				$endObj = new \DateTime($deal['endDate1']);

				$startDate = $startObj->format('Y-m-d');

				$endDate = $endObj->format('Y-m-d');

				$dealObj->hotel_code = $deal['hotelCode'];

				$dealObj->hotel_name = $deal['name'];

				$dealObj->deal_name = $deal['specialName'];

				$dealObj->deal_description = $deal['specialDescription'];

				$dealObj->deal_details = implode($deal['specialDetails']);

				$dealObj->deal_startdate = $startDate;

				$dealObj->deal_enddate = $endDate;

				$dealObj->deal_basedon = $deal['basedOn1'];

				$dealObj->save();

			}

			return redirect()->to('admin/bonoteldeals')->with("success","Successfully updated deals from bonotel");

		}

	}

	/*============================= end function to update deals in db ===================*/



	/*============================= function to update deals status in db ================*/

	public function getupdateDealStatus(Request $request, $id)

	{

		$dealObj = Deals::find($id);


  		if($dealObj->is_active == 1)

		{

			$dealObj->is_active = 0;
            $dealObj->save();

		}


    else

		{

			$dealObj->is_active = 1;
            $dealObj->save();

		}



    }
    public function updateDealStatus(Request $request)

    {


        $dealId = $request->input('record_id');

        $dealObj = Deals::find($dealId);

        if($dealObj->is_active == 1)

        {

            $dealObj->is_active = 0;
            $dealObj->save();

        }

        else

        {

            $dealObj->is_active = 1;
            $dealObj->save();
        }

        if($dealObj->save())

        {

            return redirect()->to('admin/deals')->with("success","Successfully updated the deal status.");

        }

        else

        {

            return redirect()->to('admin/deals')->with("error","Unable to update deal status. please try again");

        }

    }
	/*============================ end function to update deals status in db =============*/



	/*============================= function to load create deal view ====================*/

	public function createDeal(Request $request)

	{

		$title = 'Create Deal';
        $activeID = "createdeal";

		return view('dashboard.create_deal',compact('title','activeID'));

	}

	/*============================= end function to load create deal view ================*/



	/*============================= function to insert new deal in db ====================*/

	public function insertDeal(Request $request)

	{

		$dealObj = new Deals;

		$startObj = new \DateTime($request->input('start_date'));

		$endObj = new \DateTime($request->input('end_date'));

		$startDate = $startObj->format('Y-m-d');

		$endDate = $endObj->format('Y-m-d');

		$dealObj->hotel_code = $request->input('hotel_code');

		$dealObj->hotel_name = $request->input('hotel_name');

		$dealObj->deal_name = $request->input('deal_name');

		$dealObj->deal_description = $request->input('deal_desc');

		$dealObj->deal_details = '';

		$dealObj->deal_startdate = $startDate;

		$dealObj->deal_status = $request->input('deal_status');

		$dealObj->is_custom = 1;

		$dealObj->deal_enddate = $endDate;

		$dealObj->deal_basedon = $request->input('deal_basedon');

		if($dealObj->save())

		{

			return redirect()->back()->with("success","Deal successfully saved");

		}

		else

		{

			return redirect()->back()->with("error","Deal not saved try again");

		}

	}

	/*============================= end function to insert new deal in db ================*/



	/*================== function to retrive hotels for autocomplete =====================*/

	public function getallHotels(Request $request)

	{

		$search = $request->input("name");

		$hotels = DB::table("hotel")->select("name","hotelCode")->where('name', 'LIKE', $search.'%')->get();



		$array = array();

		foreach($hotels as $hotel)

		{

			$array[] = $hotel;

		}

		echo json_encode($array);

		exit;

	}

	/*================= end function to retrive hotels for autocomplete ==================*/



	/*================== function to load all hotel group codes view =====================*/

    public function allDestinationPage(){
        $title = 'Destinations';
        $activeID =  "destinations";
        return view('dashboard.alldestinations',compact('alldests','title','activeID'));
    }

	public function allDestinations(Request $request)
	{
        $query_value = $request->query();
        $query_resulted = $query_value['value'];
        $sEcho =$request->get('sEcho');
        $start = $request->get('iDisplayStart');
        $limit = $request->get('iDisplayLength');
        $search = $request->get('sSearch');
        $ord = $request->get('sSortDir_0');
        $ord_col = $request->get('iSortCol_0');
        if ($ord_col == '0'){
            $ord_col = "hotelgroupcode";
        }
        elseif($ord_col == '0'){
            $ord_col = "hotelgroupcode";
        }
        elseif ($ord_col == '3'){
            $ord_col = "hotelgroupname";
        }
        $order_col = $ord_col;
        $orderby = $ord;
        $data = array();
        $dests = Deals::allDestinations($order_col ,$orderby ,$limit,$start, $search,$query_resulted);
        $display = $dests['total'];
        $counter = $start;
        foreach ($dests['alldests'] as $i => $r) {
            $data[$i]['check'] = '<i class="fa fa-check"></i>';
            $data[$i]['priority'] = ++$counter;
            $data[$i]['hotelgroupcode'] = $r->hotelgroupcode;
            $data[$i]['hotelgroupname'] = $r->hotelgroupname;
            if(!empty($r->hotelgroupimage)) {
                $data[$i]['hotelgroupimage'] = '<img width="80" src="' . url('/') . '/' . $r->hotelgroupimage . '">';
            }else{
                $data[$i]['hotelgroupimage']= '';
            }
            $data[$i]['hotelgroupimage'].= '<form method="post" id="update_image_form'.$i.'" class="all'.$i.'" enctype="multipart/form-data"><input onchange="submitform('.$i.')" type="file" id="file'.$i.'" name="destImage" class="all'.$i.'"><input type="hidden" name="record_id" value="'.$r->groupId.'"></form>';
            if($r->status == 1){
                $data[$i]['status'] = '<span class="book-confirm">Active</span>';
            }else{
                $data[$i]['status'] = '<span class="book-confirm">Inactive</span>';
            }
            if ($r->status == 0) {
                $data[$i]['checkbox'] = '<form method="post" action="'.url("admin/update-destination-status").'" id="update_box" class="all'.$i.'"><input type="hidden" name="_token" value=" '.csrf_token().'" /><input type="hidden" id="record_id'.$i.'" name="record_id" value="'.$r->groupId.'"><div data-toggle="tooltip" class="checkbox c-checkbox"><label><input id="all'.$i.'" name="destId" type="checkbox" onclick="updateBox('.$i.')" value="0"> <span class="fa fa-check"></span></label></div></form>';
            } else {
                $data[$i]['checkbox'] = '<form method="post" action="'.url("admin/update-destination-status").'" id="update_box" class="all'.$i.'"><input type="hidden" name="_token" value=" '.csrf_token().'" /><input type="hidden" id="record_id'.$i.'" name="record_id" value="'.$r->groupId.'"><div data-toggle="tooltip" class="checkbox c-checkbox"><label><input id="all'.$i.'" name="destId" onclick="updateBox('.$i.')" type="checkbox" checked="checked" value="1"><span class="fa fa-check"></span></label></div></form>';
            }

        }
//        dd($data);
        $results = array("sEcho" => $sEcho, "iTotalRecords" => (int)$display, "iTotalDisplayRecords" => (int) $display,
            "aaData"=>$data);
        echo json_encode($results);
	}

   public function get_all_destination_deals(Request $request){
   
      $status = $request->Filter;  
      if($status==1){
	  $alldests = DB::table('tblhotelgroupcodes')
	             ->select('*')
				 ->where('tblhotelgroupcodes.status','=',$status)->get();
			
			$html = Helper::getFilterDestinations($alldests);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;

		 }
		 if($status==2){
			  $alldests = DB::table('tblhotelgroupcodes')
	             ->select('*')
				 ->where('tblhotelgroupcodes.status','=',0)->get();
            
			$html = Helper::getFilterDestinations($alldests);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;
         
             
		 }
		 if($status==0){
              
          $alldests = DB::table('tblhotelgroupcodes')->select('*')->get();
           $html = Helper::getFilterDestinations($alldests);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;
         
		 }
	    
   }
   
	/*=================== end function to load all hotel group codes view =================*/



	/*======================== function to update destination status in db ================*/

	public function updateDestinationStatus(Request $request)
	{
		$destId = $request->input('record_id');
		$destObj = Destinations::find($destId);
		$check_status = $request->input('checkbox');
		if($check_status == 0) {
			$destObj->status = 1;
			$destObj->save();
			return "active";
		}
		else {
			$destObj->status = 0;
            $destObj->save();
            return "in-active";
		}
	}

	/*======================= end function to update destination status in db =============*/



	/*======================== function to update destination status in db ================*/

	public function updateDestinationImage(Request $request)

	{
		$destId = $request->input('record_id');
		$destObj = Destinations::find($destId);
//        dd($request->all(),$request->file('image'));
			if ($request->file('image')) {
				if(!empty($destObj->hotelgroupimage))
				{
					if(\File::exists($destObj->hotelgroupimage))
					{
						\File::delete($destObj->hotelgroupimage);
					}
				}
				$imageSize = $request->file('image');
                $width = 0;
                $height = 0;
                list($width,$height) = getimagesize($imageSize);
                if($width <= 450 && $height >= 550){
                    $destinationPath = 'assets/dashboard/images/destinations/';
                    $extension = $request->file('image')->getClientOriginalExtension();
                    if($extension == 'png' || $extension == "jpg" || $extension == "jpeg") {
                        $fileName = uniqid() . '_cover.' . $extension;
                        $request->file('image')->move($destinationPath, $fileName);
                        $fullName = $destinationPath . $fileName;
                        $destObj->hotelgroupimage = $fullName;
                        if ($destObj->save()) {
//					return response()->json(['error'=>0,'msg'=>'Successfull updated destination image']);
                            return "success";
                        } else {
                            return "fail";
//					return response()->json(['error'=>1,'msg'=>'Unable to update destination image']);
                        }
                    }
                    else{
                        return "Chosse PNG, JPEG or JPG images only";
                    }
                }
                elseif ($width >= 550 && $height <= 350){
                    $destinationPath = 'assets/dashboard/images/destinations/';
                    $extension = $request->file('image')->getClientOriginalExtension();
                    if($extension == 'png' || $extension == "jpg" || $extension == "jpeg") {
                        $fileName = uniqid() . '_cover.' . $extension;
                        $request->file('image')->move($destinationPath, $fileName);
                        $fullName = $destinationPath . $fileName;
                        $destObj->hotelgroupimage = $fullName;
                        if ($destObj->save()) {
//					return response()->json(['error'=>0,'msg'=>'Successfull updated destination image']);
                            return "success";
                        } else {
                            return "fail";
//					return response()->json(['error'=>1,'msg'=>'Unable to update destination image']);
                        }
                    }
                    else{
                        return "Chosse PNG, JPEG or JPG images only";
                    }
                }
                else{
                    return "under_size";
                }

			}
			else {
				return "no_image";
			}
    }
    public function get_deals_filtered(Request $request){

        $status = $request->Filter ;



        if($status==0){
            $alldeals = Self::getFormatedData(Deals::groupby('HotelID')->get());
            $html = Helper::getFilterDealsRecord($alldeals);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;
        }

        if($status==2){

            $inactivedeals = Self::getFormatedData(Deals::groupby('HotelID')->where('is_active', '=', 0)->get());


            $html = Helper::getFilterDealsRecord($inactivedeals);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;

        }

        if($status==1){

            $activedeals = Self::getFormatedData(Deals::groupby('HotelID')->where('is_active', '=', 1)->get());

            $html = Helper::getFilterDealsRecord($activedeals);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;
        }

        if($status==3){

            $admindeals = Self::getFormatedData(Deals::groupby('HotelID')->where('is_custom', '=', 1)->get());

            $html = Helper::getFilterDealsRecord($admindeals);
            $obj = array();
            $obj['status'] = true;
            $obj['html'] = $html;

            echo json_encode($obj);
            exit;

        }




    }

	/*======================= end function to update destination status in db =============*/



/*============================= end DashboardController ==================================*/

}
