<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\User;
use Validator;
class SiteController extends Controller
{
	/*============================= controller constructor ===============================*/
	public function __construct()
	{}
	/*============================= site login view ======================================*/
	public function index(Request $request)
	{
		return view('auth.login');
	}
	/*============================= end site login view ==================================*/
	/*============================= site login function ==================================*/
	public function validateLogin(Request $request)
	{
		session_start();
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:3'
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails())
		{
			return redirect()->to('login')->with('error','Please provide username and password');
		}
		else
		{
			$check = DB::table("users")->where("email",$request->input("email"))->select("name","email","password","id","role","status")->first();
			if($check == null)
			{
				return redirect()->to('login')->with('error','Username password combination is wrong!');	
			}
			$passFlag = \Hash::check($request->input("password"),$check->password);
			if($check->status == 1)
			{
				if($check->email == $request->input("email") && $passFlag)
				{
					$request->session()->set('user_login',$check->email);
					$request->session()->set('ser_role',$check->role);
					$request->session()->set('user_name',$check->name);
					$request->session()->set('siteLogin',1);
					$request->session()->set('user_id',$check->id);
					$request->session()->save();
                    $_SESSION["USERID"] = $check->id;
					return redirect()->to('/');
				}
				else
				{        
					return redirect()->to('login')->with('error','Username password combination is wrong!');
				}
			}
			else
			{
				return redirect()->to('login')->with('error','This user has blocked by admin');
			}
		}
	}
	/*============================= end user login function ===============================*/
	
	/*============================= user logout function =================================*/
	public function user_logout()
	{
		session_start();
		session_destroy();
		session_unset();
		unset($_SESSION["user_login"]);
		return redirect()->to("/");	 
	}
	/*============================= end user logout function =============================*/
/*============================= end RegisterController ===================================*/
}
