<?php
namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Tbluser;
use Validator;
class RegisterController extends Controller
{
    /*============================= controller constructor ===============================*/
	public function __construct()
	{}
	/*============================= function to load admin login view ====================*/
	public function AdminLogin()
	{
		$title = 'Admin Login';
		return view("auth.admin_login",compact('title'));
	}
	/*============================= end function to load admin login view ================*/
	
	/*============================= function to load admin register view =================*/
	public function adminRegister()
	{
		$title = 'Create User';
		return view("auth.admin_register",compact('title'));
	}
	/*============================ end function to load admin register view ==============*/
    
	/*============================= function to create new admin user ====================*/
	public function admin_register(Request $request)
	{
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:3'
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}
		else
		{
			User::create([
				'name' => "Admin",
				'role' => 1,
				'is_admin' => 1,
				'email' => $request->input("password"),
				'password' => bcrypt($request->input("password")),
			]);
			$userdata = array(
				'email' => $request->input("email"),
				'password' => $request->input("password"),
				'role' => 1,
				'is_admin' => 1
			);
			if (\Auth::attempt($userdata))
			{
				return redirect()->to("admin");
			}
			else
			{
				return redirect()->back()->with("error", "sorry there was some errors, please try again");
			}
		}
	}
	/*============================= end function to create new admin user ====================*/
	
	/*============================= function to validate admin login =========================*/
	public function admin_login(Request $request)
	{
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:3'
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails())
		{
			return redirect()->to('admin/login')->with('error','Please provide username and password');
		}
		else
		{
			$check = Tbluser::with('role')->where("email",'=',$request->input("email"))->where("role",'=',2)->first();
			if($check == null)
			{
				return redirect()->to('admin/login')->with('error','Username password combination is wrong!');	
			}
			$passFlag = \Hash::check($request->input("password"),$check->password);
			if($check->status == 1)
			{
				if($check->email == $request->input("email") && $passFlag)
				{
					$request->session()->set('adminEmail',$check->email);
					$request->session()->set('adminRole',$check->role);
					$request->session()->set('adminName',$check->name);
					$request->session()->set('adminLogin',1);
					$request->session()->set('adminId',$check->id);
					$request->session()->save();
					return redirect()->to('admin/');
				}
				else
				{        
					return redirect()->to('admin/login')->with('error','Username password combination is wrong!');
				}
			}
			else
			{
				return redirect()->to('login')->with('error','This user has blocked');
			}
		}
	}
	/*============================= end function to validate admin login ======================*/
    
	/*============================= function to logout admin =================================*/
	public function admin_logout(Request $request)
	{
		$request->session()->forget('adminEmail');
		$request->session()->forget('adminRole');
		$request->session()->forget('adminName');
		$request->session()->forget('adminLogin');
		$request->session()->forget('adminId');
		return redirect()->to('admin/login');
    }
	/*============================= end function to logout admin ============================*/
}
