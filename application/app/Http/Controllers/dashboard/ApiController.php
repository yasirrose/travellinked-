<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use App\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller

{

	/*============================= controller constructor ===============================*/

	public function __construct()

	{}

	/*============================= function to load add api view ========================*/

	public function Api(Request $request)

	{

		$title = 'Add New Api';


		return view('dashboard.api_detail',compact('title','obj'));

	}

	/*============================= end function to load add api view ====================*/

	

	/*============================= function to add new api record =======================*/

	public function addApi(Request $request)

	{

		Api::create($request->all());

		return redirect()->to("admin/showApi")->with("success","api detail added successfully !");

	}

	/*========================= end function to add new api record =======================*/

	

	/*============================= function to show all apis ============================*/

	public function showApi()

	{

		$title = 'All Apis';


		$api_detail = Api::all();

        $activeID = 'api';

        return view("dashboard.show_api",compact("api_detail","title",'activeID'));

	}

	public function updateApiStatus(Request $request){

        $id = $request->Id ;

        $result = DB::table('api_detail')->update(array('is_active' => 0));



        $api = API::find($id);

        $api->is_active = 1;
        $api->save();


        return redirect()->to('admin/showApi')->with("success", "Successfully updated the deal status.");

    }

	/*============================= function to show all apis ============================*/

	

	/*========================== function to get info of selected api ====================*/

	public function editApi(Request $request, $id)

	{

		$title = 'Edit Api';

		$api = Api::where("id",$id)->first();

		return view("dashboard.edit_api",compact("api","title"));

	}

	/*====================== end function to get info of  selected api ===================*/

	

	/*========================== function to update selected api =========================*/

	public function updateApi(Request $request, $id)

	{

		Api::where("id",$id)->update($request->except("_token"));

		return redirect()->to("admin/showApi")->with("success","Api detail has been successfully updated !");

	}

	/*========================== end function to update selected api ====================*/

	

	/*========================== function to delete selected api ========================*/

	public function deleteApi($id)

	{

		Api::where("id",$id)->delete();

		return redirect()->back()->with("success","Api detail has been successfully deleted");

	}

	/*========================== end function to delete selected api ====================*/

/*========================== end ApiController ==========================================*/

}

