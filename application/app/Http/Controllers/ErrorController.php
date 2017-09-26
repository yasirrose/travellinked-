<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

class ErrorController extends Controller

{

	/**

	* Create a new controller instance.

	*/

	public function __construct()

	{

		//$this->middleware('auth');

	}

	public function index(Request $request)

	{
		
		return view('errors.500');
	}
	
	public function fbError(Request $request)

	{
		return view('errors.fb-error');
	}

	

}



