<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Crypt;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Tbluser;
use Session;
use Validator;
use Socialite;
use Illuminate\Support\Facades\Input;
require_once(base_path('/vendor/Facebook/autoload.php') );

class RegisterController extends Controller

{

	/*============================= controller constructor ===============================*/

	public function __construct()

	{}

	/*============================= create user function ================================*/



	public function user_register(Request $request)

	{

		$exist = Tbluser::where('email','=',$request->input('email'))->first();

		if ($exist == null)

		{

			$array = explode('@', $request->input("email"));

			$last_insert_id= Tbluser::create([

				'first_name' => $array[0],

				'role'=> 1,

				'email' => $request->input("email"),

				'password' => '',

				'is_activated' =>0,

                'status' => 1,

			]);

			$id = Crypt::encrypt($last_insert_id->id);

			$url = url('set-password').'/'.$id;

			return response()->json(['error'=>0,'msg'=>'','url'=>$url]);

		}

		else

		{

			return response()->json(['error'=>1,'msg'=>'Email already taken please try another']);

		}

	}

	/*============================== Facebook Signup Functions ============================*/

	public function fromfacebook(Request $request){

		$max_age = 0;
		session_start();
		$fb = new \Facebook\Facebook([
		  'app_id'                => '453266958395346',
		  'app_secret'            => '0ed42354451f42126427c0374461a445',
		  'default_graph_version' => 'v2.3',
		]);
		$helper = $fb->getRedirectLoginHelper();

		if(isset( $_GET['code'])){

		  try {

		    $access_token = $helper->getAccessToken();

		    $helper->getPersistentDataHandler()->set('access_token',$access_token);

		  }catch(Exception $e){

		    // error occured

		  }

		}

		$access_token = $helper->getPersistentDataHandler()->get( 'access_token' );

		if ($access_token && !$access_token->isExpired()){

			$fb->setDefaultAccessToken($access_token);

			try {

				$response = $fb->get('/me?fields=id,name,first_name,last_name,email,hometown,birthday,age_range');
			  
				  

			}
           
			catch( Exception $e ) {

				echo $e->getMessage();

				exit;

			}
			

			$me = $response->getGraphUser();

		   
          
		   	if(!isset($me['email']))

			{

				return redirect()->to('error');

			}
			

			$email = $me['email'];

			$id = $me['id'];

			$fname = $me['first_name'];

			$lname = $me['last_name'];

			
                

		   if(isset($me['birthday'])){
			$location = $me['hometown']['name'];

			$birthday = $me['birthday']->format('Y-m-d');
          
		    }
		
			 else
			   {
				$location = '';

				 $birthday = '';
		  
		  	   }	    

			  if(isset($me['age_range']['min'])){
			   $min_age = $me['age_range']['min'];
		      }
			  else{
			        $min_age = 0;
					}

					
		   
		     if(isset($me['age_range']['max'])){
               $max_age = $me['age_range']['max'];
		     }    
			 else{
				 $max_age =0;
			 }
			 
			 
			  
			
            
			
           
			$exist = Tbluser::where(array('email'=>$email,'fb_id'=>$id))->first();

			

			if ($exist == null)

			{
              
				$image = 'https://graph.facebook.com/'.$id.'/picture?type=square&width=150&height=150';
				
				

				$last_insert_id = Tbluser::create([

					'first_name' => $fname,

					'last_name' => $lname,

					'role'=> 1,

					'email' => $email,

					'birthday' => $birthday ,

					'password' => '',

					'img_url' => $image,

					'fb_id' => $id,

					'status' => 1,

					'is_activated' =>0,

					 'country' => $location,

					 'min_age' => $min_age,
					 
					 'max_age' => $max_age

					 

				
				]);
			
				

				$userObj = new \StdClass();

				$userObj->email = $last_insert_id->email;

				$userObj->body = 'please cllick on below link and activate your account to get full features';

				$userObj->id = Crypt::encrypt($last_insert_id->id);

				$userObj->flag = 'register';

				/*==== Mail function for users confirmation=====*/

				\Mail::send('mails.account', array('userInfo' => $userObj), function($message) use ($last_insert_id)

				{

					$message->from('info@travellinked.com', 'Travel Linked');

					$message->to($last_insert_id->email,$last_insert_id->first_name)->subject('Account created');

				});

				/*==== End Mail function for users confirmation=====*/

				$request->session()->set('userEmail',$last_insert_id->email);

				$request->session()->set('userRole',$last_insert_id->role);

				$request->session()->set('userName',$last_insert_id->first_name);

				$request->session()->set('lastName',$last_insert_id->last_name);

				$request->session()->set('userLogin',1);

				$request->session()->set('userId',$last_insert_id->id);

				$request->session()->set('userStatus',$last_insert_id->is_activated);

				$request->session()->set('userImage',$last_insert_id->img_url);

				$request->session()->save();

				return redirect()->to('/');

			}

			else

			{
				

				$request->session()->set('userEmail',$exist->email);

				$request->session()->set('userRole',$exist->role);

				$request->session()->set('userName',$exist->first_name);

				$request->session()->set('lastName',$exist->last_name);

				$request->session()->set('userLogin',1);

				$request->session()->set('userId',$exist->id);

				$request->session()->set('userStatus',$exist->is_activated);

				$request->session()->set('userImage',$exist->img_url);

				$request->session()->save();

				return redirect()->to('/');

			}

		}

	}

	/*============================== End Facebook Signup Functions============================*/



	/*============================= password set for user view function ==================*/

	public function set_password(Request $request,$id)

	{

		try

		{

			$userId = Crypt::decrypt($id);
			dd($userId);
			$userObj = Tbluser::where('id','=',$userId)->first();

		}

		catch(\Exception $e)

		{

			echo "Invalid data. please check your url";

			exit;

		}

		if($userObj == null)

		{

			echo "Your link is not a valid link";

			exit;

		}

		else

		{

			return view('frontend.activate_account',compact('id'));

		}

	}

	/*============================ end password set for user view function ===============*/



	/*============================= password set for user view function ==================*/

	public function RegisterUser(Request $request){
        $check = Tbluser::where("email",'=',$request->email)->first();
        if($check!=null){
            return 1;
        }
        else{
            $confirmation_code = str_random(30);
            $user = new Tbluser;
            $user->first_name= $request->fname;
            $user->last_name = $request->lname;
            $year = $request->year;
            $month =$request->month;
            $day=$request->day;
            $birthday = $year . '-' . $month . '-' . $day;
            $user->birthday = $birthday;
            $user->email = $request->email;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->zip_code = $request->zip;
            $user->status = 1;
            if($request->facebook_id != null) {
                $user->is_activated = 1;
            }else{
                $user->is_activated = 0;
            }
            $user->role =1;
            $user->code = $confirmation_code;
            $user->phoneNumber = $request->phone;
            $user->password= \Hash::make($request->password);
            $user->facebook_id= $request->facebook_id;
            $user->save();
            $mail = \Mail::send('mails.verify_email', ['data' => $user], function ($m) use ($user) {
                $m->to($user->email , $user->first_name)->subject('Account registration!');
            });
            if($request->facebook_id != null){
                $user->code = '';
                $user->update();
                return 'fb_user_done';
            }
            if($mail){
                return 2;
            }

        }

    }

    public function verifyUser($confirmation_code){

       $code = Tbluser::where('code','=',$confirmation_code)->first();
        if($code){
            $id = $code->id;
            return view('signup.tell_us', compact('id'));
        }
    }
    public function ConfiremAccountByEmail(Request $request){
        $id = $request->id;
        $about = $request->about;
        $source = $request->source;
        $user = Tbluser::find($id);
        $user->code =null;
        $user->is_activated = 1;
        $user->about=$about;
        $user->source = $source;
        $user->save();
        return 1;
    }
    public function resetlogin(){
        return view('signup.reset-pass');
    }
	
    public function newLogin($type){
        //===== if user already login then please redirect to home page.
		if(!empty(session()->get('userLogin')) || session()->get('userLogin') != 0){
			return redirect()->to('/');
		}
        if($type == 'simple'){
            session()->set('SM_redirect', $type);
            session()->save();
            return view('signup.newlogin', compact('type'));
        }elseif($type == 'facebook'){
            return Socialite::driver('facebook')->redirect();
        }elseif(intval($type ) > 0){
            return view('signup.newlogin', compact('type'));
        }elseif($type == 'room'){
            $link = session()->get('SM_redirect_RD');
            return view('signup.newlogin', compact('type' ,'link'));
        }
    }
	
	public function user_login(Request $request){
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:3'
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()){
			echo json_encode($validator->getMessageBag()->toArray());
			exit;
		}else{
			$check = Tbluser::with('role')->where("email",'=',$request->input("email"))->where("role",'=',1)->first();
			if($check == null){
				echo json_encode(0);
				exit;
			}
			$passFlag = \Hash::check($request->input("password"),$check->password);
			if($check->status == 1){
				if($check->email == $request->input("email") && $passFlag) {
                    $request->session()->set('userEmail', $check->email);
                    $request->session()->set('userRole', $check->role);
                    $request->session()->set('userName', $check->first_name);
                    $request->session()->set('lastName', $check->last_name);
                    $request->session()->set('userLogin', 1);
                    $request->session()->set('userId', $check->id);
                    $request->session()->set('userStatus', $check->is_activated);
                    if ($check->img_url != null) {
                        $request->session()->set('userImage', $check->img_url);
                    }
                    $request->session()->save();
                    echo json_encode(1);
                    exit;
				}else {
					echo json_encode(0);
					exit;
				}
			}else{
				echo json_encode(2);
				exit;
			}
		}
	}
	
	public function handleProviderCallback(){
        $user = Socialite::driver('facebook')->user();
        $user_id =   $user->getId();
        $user_nickName = $user->getNickname();
        $user_name = $user->getName();
        $fbname = explode(" ",$user_name);
        $user_email =  $user->getEmail();
        $user_image  = $user->getAvatar();
        $checkUser = Tbluser::where("email",'=',$user_email)->where('facebook_id', '=', $user_id)->first();
        if($checkUser) {
            $password = $checkUser->password;
            $rules = array(
                'email' => 'required|email',
                'password' => 'required|min:3'
            );
            $check = Tbluser::with('role')->where("email", '=', $user_email)->where("role", '=', 1)->first();
            if ($check == null) {
                echo json_encode(0);
                exit;
            }
            $passFlag = $password;
            if ($check->status == 1) {
                if ($check->email == $user_email && $passFlag) {
                    session()->set('userEmail', $check->email);
                    session()->set('userRole', $check->role);
                    session()->set('userName', $check->first_name);
                    session()->set('lastName', $check->last_name);
                    session()->set('userLogin', 1);
                    session()->set('userId', $check->id);
                    session()->set('userStatus', $check->is_activated);
                    if ($check->img_url != null) {
                        session()->set('userImage', $check->img_url);
                    }
                    $roomCode = '';
                    if (session()->get('SM_redirect') == 'simple' || empty(session()->get('SM_redirect'))) {
                        session()->set('userImage', -1);
                        session()->save();
                        return redirect()->to('/');
                    }elseif(session()->get('SM_redirect') == 'room'){
                        return redirect()->to(session()->get('SM_redirect_RD'));
                    }else{
                        return redirect()->to('payment/'.session()->get('SM_redirect'));
                    }
                }
            }
        }
        else{
            return view('signup.userSignup',compact('user_id','user_name','user_email','fbname'));
        }
    }
	
	public function activate_account(Request $request,$id){

		try

		{

			$userId = Crypt::decrypt($id);

			$userObj = Tbluser::where('id','=',$userId)->first();

		}

		catch(\Exception $e)

		{

			echo "Invalid data. please check your url that sent in email";

			exit;

		}

		if($userObj == null)

		{

			echo "Your link is not a valid link";

			exit;

		}

		elseif($userObj->is_activated == 1)

		{

			echo "Your link has been expired";

			exit;

		}

		else

		{

			$userObj->is_activated = 1;

			if($userObj->save())

			{

				$request->session()->set('userStatus',$userObj->is_activated);

				$request->session()->save();

				echo '<h2>Congrats! Your account is activated</h2>';

				exit;

			}

			else

			{

				echo '<h2>Oops! Unable to activate your account, try again</h2>';

				exit;

			}

		}

	}

	/*============================ end password set for user view function ===============*/



	/*============================= update user password function ========================*/

	public function update_activation(Request $request)

	{

		$userObj = new Tbluser;

		try

		{

			$userId = Crypt::decrypt($request->input('uid'));



			$userObj = Tbluser::find($userId);

		}

		catch(\Exception $e)

		{

			return response()->json(['error'=>1,'msg'=>'Unable to create your account']);

			exit;

		}

		if($userObj == null)

		{

			return response()->json(['error'=>1,'msg'=>'Unable to create your account']);

			exit;

		}

		$userObj->password = bcrypt($request->input('password'));

		if($userObj->save())

		{

			$userObjMail = new \StdClass();

			$userObjMail->email = $userObj->email;

			$userObjMail->body = 'please cllick on below link and activate your account to get full features';

			$userObjMail->id = Crypt::encrypt($userObj->id);

			$userObjMail->flag = 'register';

            /*==== Mail function for users confirmation=====*/

			\Mail::send('mails.account', array('userInfo' => $userObjMail), function($message) use ($userObj)

			{

				$message->from('info@travellinked.com', 'Travel Linked');

				$message->to($userObj->email,$userObj->first_name)->subject('Account created');

			});

			/*==== End Mail function for users confirmation=====*/

			$request->session()->set('userEmail',$userObj->email);

			$request->session()->set('userRole',$userObj->role);

			$request->session()->set('userName',$userObj->first_name);

			$request->session()->set('lastName',$userObj->last_name);

			$request->session()->set('userLogin',1);

			$request->session()->set('userId',$userObj->id);

			$request->session()->set('userStatus',$userObj->is_activated);

			$request->session()->set('userImage',$userObj->img_url);

			$request->session()->save();

			$url = url('/');

			return response()->json(['error'=>0,'msg'=>'','url'=>$url]);

			exit;

		}

		else

		{

			return response()->json(['error'=>1,'msg'=>'Unable to create your account']);

			exit;

		}

	}


	/*============================= end create user function =============================*/

	/*============================= send mail to reset password function ================*/

	public function send_mail_reset_password(Request $request)

	{

		$userObj = Tbluser::where('email','=',$request->input('email'))->first();

		if($userObj == null)

		{

			echo json_encode(1);

			exit;

		}

		else

		{

			$userObj1 = new \StdClass();

			$userObj1->email = $userObj->email;

			$userObj1->body = 'You have forgot your password, dont worry. Please click on below link to change your password';

			$userObj1->id = Crypt::encrypt($userObj->id.'&&**&&88**&&'.$userObj->password);

			$userObj1->flag = 'forget';

            /*==== Mail function for users confirmation=====*/

			\Mail::send('mails.account', array('userInfo' => $userObj1), function($message) use ($userObj)

			{

				$message->from('info@travellinked.com', 'Travel Linked');

				$message->to($userObj->email,$userObj->first_name)->subject('Forgot password');

			});

			/*==== End Mail function for users confirmation=====*/

			echo json_encode(0);

			exit;

		}

	}

	/*============================ end send mail to reset password function ==============*/



	/*============================= password change for user view function ==================*/

	public function forget_password(Request $request,$id)

	{

		try

		{

			$userId = Crypt::decrypt($id);

						$user = explode('&&**&&88**&&', $userId);
			// dd($userId);
			$userId = $user[0];
			// dd($user);

			$userObj = Tbluser::where('id','=',$userId)->first();

		}

		catch(\Exception $e)

		{
			dd($e);
			echo "Invalid data. please check your url that sent in email";

			exit;

		}

		if($userObj == null)

		{

			echo "Your link is not a valid link";

			exit;

		}

		else

		{
			$id = Crypt::encrypt($user[0]);
			return view('frontend.forget_password',compact('id'));

		}

	}

	/*========================= end password change for user view function ===============*/



	/*============================= user login function ==================================*/

	public function signupUser(){

        return view('signup.userSignup');
    }
	/*======================= resend confirmation for user view function ==================*/

	public function resend_confirmation(Request $request)

	{

		return view('frontend.resend-email');

	}

	public function check_lock_password(Request $request){

        $check = Tbluser::where([["email",'=',session()->get('adminEmail')], ["role",'=',2]])->first();




        $passFlag = \Hash::check($request->input("password"),$check->password);
        if($passFlag){

            \Session::forget('isLock');
            return redirect('admin');
        }
       else{
           return redirect('admin/showLockScreen');
       }
    }

	/*====================== end resend confirmation for user view function ===============*/

	

	/*============================= user resend email function ============================*/

	public function resend_email(Request $request)

	{

		$check = Tbluser::where("email",'=',$request->input("email"))->first();

		if($check == null)

		{

			return response()->json(['error'=>1,'msg'=>'Sorry! No registered user found with entered email']);

			exit;

		}

		else

		{

			if($check->is_activated == 1)

			{

				return response()->json(['error'=>1,'msg'=>'You have already confirmed your account']);

				exit;

			}

			else

			{

				$userObj = new \StdClass();

				$userObj->email = $check->email;

				$userObj->body = 'please click on below link and activate your account to get full features';

				$userObj->id = Crypt::encrypt($check->id);

				$userObj->flag = 'register';

				/*==== Mail function for users confirmation=====*/

				\Mail::send('mails.account', array('userInfo' => $userObj), function($message) use ($check)

				{

					$message->from('info@travellinked.com', 'Travel Linked');

					$message->to($check->email,$check->first_name)->subject('Resend Confirmation Email');

				});

				/*==== End Mail function for users confirmation=====*/

				return response()->json(['error'=>0,'msg'=>'Confirmation email has been sent on your mail address']);

				exit;

			}	

		}

	}

	/*============================= end user resend email function =======================*/



	/*============================= user logout function =================================*/

	public function user_logout(Request $request){
		$request->session()->forget('userEmail');
		$request->session()->forget('userRole');
		$request->session()->forget('userName');
		$request->session()->forget('lastName');
		$request->session()->forget('userLogin');
		$request->session()->forget('userId');
		$request->session()->forget('userStatus');
		$request->session()->forget('userImage');
		$request->session()->forget('roomDetailDirectPayment');
		$request->session()->forget('urlforDirectPayment');
		$request->session()->forget('rooomHotelCodeDirectPayment');
		$request->session()->forget('roomDetail');
		$request->session()->forget('fullUrl');
		$request->session()->forget('rooomHotelCode');
		$request->session()->forget('currenthotelStatus');
		$request->session()->forget('viewHotelHomeDetail');
		$request->session()->forget('viewHotelfullUrl');
		$request->session()->forget('viewHotelrooomHotelCode');
        $request->session()->forget('SM_redirect');
        $request->session()->forget('SM_redirect_RD');
//		Session::flush();
//		Auth::logout();
		return redirect()->to("/");

	}

	/*============================= end user logout function =============================*/

/*============================= end RegisterController ===================================*/

}

