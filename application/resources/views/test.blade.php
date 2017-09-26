<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Linked</title>
    <link rel="shortcut icon" type="image/png" href="{{url('/assets/images/favicon.png')}}"/>
    <link href="{{url('/assets/css/ionicons.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}">
    <link href="{{url('/assets/css/style.css')}}?v={{ uniqid()}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/jquery-ui.css')}}">
    <link href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
    <link href="{{url('/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/daterangepicker.css')}}?v={{ uniqid()}}">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
    <?php
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (stripos( $user_agent, 'Chrome') !== false)
        {}
        elseif(stripos( $user_agent, 'Safari') !== false)
        {
			$url = url('/assets/css/safari.css');
			echo '<link href="'.$url.'?v='.uniqid().'" rel="stylesheet">';
		}
		?>
</head>

<body>
	<div class="signup-page" style="display:none">
		<div class="signup-page-inner">
			<div class="signup-page-logo">
				<a href="#">
					<img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png"> 
				</a>
			</div>
			<div class="signup-page-form" style="display:none;">
				<div class="signup-wizard-links">
					<ul>
						<li class="active"></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</div>
				<div class="signup-form-head">
					<h1>What's Your Location</h1>
					<p>What is the purpose of your account, and how do you plan to use Travel Linked?</p>
				</div>
				<div class="signup-form-btm">
					<div class="signup-form-row">
						<div class="icon-control">
							<select class="signup-form-field">
								<option disabled selected>Country</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
							</select>
							<span class="ion ion-arrow-down-b"></span>
						</div>
					</div>
					<div class="signup-form-row">
						<input type="text" class="signup-form-field" placeholder="Street Address 1">
					</div>
					<div class="signup-form-row">
						<input type="text" class="signup-form-field" placeholder="Street Address 2">
					</div>
					<div class="signup-form-row">
						<div class="signup-w-120">
							<input type="text" class="signup-form-field" placeholder="City">
						</div>
						<div class="signup-w-80">
							<div class="icon-control">
								<select class="signup-form-field">
									<option disabled selected>State</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
								</select>
								<span class="ion ion-arrow-down-b"></span>
							</div>
						</div>
						<div class="signup-w-100">
							<input type="text" class="signup-form-field" placeholder="Zip Code">
						</div>
					</div>
					<div class="signup-form-btn">
						<button>Confirm Billing Address</button>
					</div>
				</div>
			</div>
			<div class="signup-page-welcome" style="display:none;">
				<div class="signup-page-welcome-inner">
					<h2>Welcome To The Club</h2>
					<p>Hosts on Airbnb are real people with real homes. That's why you'll have to confirm a few, quick details to activate your account.</p>
					<button>Next - 4 steps left</button>
				</div>
			</div>
			<div class="signup-page-form" style="display:none;">
				<div class="signup-wizard-links">
					<ul>
						<li></li>
						<li class="active"></li>
						<li></li>
						<li></li>
					</ul>
				</div>
				<div class="signup-form-head">
					<h1>Confirm Your Phone Number</h1>
					<p>This is so we can connect with you that way we can ensure your always accommodated.</p>
				</div>
				<div class="signup-form-btm">
					<div class="signup-form-row phone-num">
						<label>Phone Number</label>
						<input type="text" class="signup-form-field" >
						<em>+1</em>
					</div>
					<div class="signup-form-btn">
						<button>Confirm Phone Number</button>
					</div>
				</div>
			</div>
			<div class="signup-page-form" style="display:none;">
				<div class="signup-wizard-links">
					<ul>
						<li></li>
						<li></li>
						<li class="active"></li>
						<li></li>
					</ul>
				</div>
				<div class="signup-form-head">
					<h1>Check Your Email</h1>
					<p>Tap the link in the email we sent you. Confirming your email address helps us send you trip information.</p>
				</div>
				<div class="signup-form-btm">
					<div class="signup-form-row change-email-field">
						<label>Email Address</label>
						<input type="text" class="signup-form-field" value="testemail@travelinked.com">
					</div>
					<div class="signup-form-btn change-email-link">
						<button>Resend Email</button>
						<a href="#">Change Email Address</a>
					</div>
				</div>
			</div>
			<div class="signup-page-form" >
				<div class="signup-wizard-links">
					<ul>
						<li></li>
						<li></li>
						<li></li>
						<li class="active"></li>
					</ul>
				</div>
				<div class="signup-form-head">
					<h1>Tell us a little more about you</h1>
					<p>What is the purpose of your account, and how do you plan to use Travel Linked?s</p>
				</div>
				<div class="signup-form-btm">
					<div class="signup-form-row">
						<label>Account Type</label>
						<div class="icon-control">
							<select class="signup-form-field">
								<option disabled selected>Select Who You Are</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
							</select>
							<span class="ion ion-arrow-down-b"></span>
						</div>
					</div>
					<div class="signup-form-row">
						<label>How Did You Hear About Us?</label>
						<div class="icon-control">
							<select class="signup-form-field">
								<option disabled selected>Select Source</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
								<option>aaa</option>
							</select>
							<span class="ion ion-arrow-down-b"></span>
						</div>
					</div>
					<div class="signup-form-btn">
						<button>Ready To Go</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="become-member-page" style="display:none;">
		<div class="become-member-left">
			<div class="bm-logo">
				<a href="#">
					<img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png"> 
				</a>
			</div>
			<div class="bm-content">
				<h2>Start Your Journey</h2>
				<p>Join Millions of Travelers Today and save up to 70% with these members only rates</p>
			</div>
		</div>
		<div class="become-member-right">
			<div class="become-member-right-inner">
				<h1>Become A Member</h1>
				<div class="become-member-fb">
					<a href="#"><span><i class="fa fa-facebook"></i></span>Join with Facebook</a>
				</div>
				<div class="become-member-or">
					<span>Or</span>
				</div>
				<div class="become-member-form">
					<div class="signup-form-row">
						<input class="signup-form-field" placeholder="Email Address" type="text">
					</div>
					<div class="signup-form-row">
						<input class="signup-form-field" placeholder="First Name" type="text">
					</div>
					<div class="signup-form-row">
						<input class="signup-form-field" placeholder="Last Name" type="text">
					</div>
					<div class="signup-form-row">
						<input class="signup-form-field" placeholder="Create a Password" type="text">
					</div>
					<div class="signup-form-row birthday-date-row">
						<p>Birthday <span>To become part of the club, you must be 18 or older.</span></p>
						<div class="signup-w-120">
							<div class="icon-control">
								<select class="signup-form-field">
									<option disabled="" selected="">Month</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
								</select>
								<span class="ion ion-arrow-down-b"></span>
							</div>
						</div>
						<div class="signup-w-70">
							<div class="icon-control">
								<select class="signup-form-field">
									<option disabled="" selected="">Day</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
								</select>
								<span class="ion ion-arrow-down-b"></span>
							</div>
						</div>
						<div class="signup-w-90">
							<div class="icon-control">
								<select class="signup-form-field">
									<option disabled="" selected="">Year</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
									<option>aaa</option>
								</select>
								<span class="ion ion-arrow-down-b"></span>
							</div>
						</div>
					</div>
					<div class="become-member-terms">By signing up, I agree to Travel Linked's <a href="#">Website Terms of Use</a>, <a href="#">Property Policies</a>, <a href="#">Occupancy Restrictions</a>, <a href="#">Payments Terms of Service</a>, <a href="#">Privacy Policy</a>, and <a href="#">Refund Policy</a>.</div>
					<div class="signup-form-btn">
						<button>Join Now</button>
					</div>
					<div class="members-login-link">
						<span>Are you already a member? <a href="#">Log in</a></span>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<div class="page-forgot-pass forgot-popup" style="display:none;">
		<div class="page-forgot-pass-inner">
			<div class="page-forgot-pass-logo">
				<a href="#">
					<img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png"> 
				</a>
			</div>	
			<div class="popup-inner">
				<div class="popup-body">
					<h3>Forgot your password? Don’t Panic<span>Enter the email address associated with your account, and we’ll email you a link to reset your password.</span></h3>
					<form method="post">
						<input name="_token" value="3TqLE5trDT1HrwID4oqS2VIKvUzWKnfj6xfmmvj4" type="hidden">
						<div class="login-fields">
							<div class="login-fields-holder">
								<input class="login-field" placeholder="Email Address" name="email" type="text">
							</div>
						</div>
						<div class="login-submit">
							<button class="forgot-to-confirmation" type="submit">Send Reset Link</button>
						</div>
					</form>
				</div>
				<div class="popup-foot">
					<p>Ready to log in? <a href="javascript:void(0)" class="forgot-to-login">Go back</a></p>
				</div>
			</div>

		</div>
	</div>
	<div class="page-forgot-pass page-login">
		<div class="page-forgot-pass-inner">
			<div class="page-forgot-pass-logo">
				<a href="#">
					<img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png"> 
				</a>
			</div>	
			<div class="popup-inner"> 
				<form method="post">
					<div class="popup-body">
						<h2>Welcome back!</h2>
						<div class="fb-login"> <a class="fb-btn" href="http://travellinked.com/travellinked/facebooklogin"><span><i class="fa fa-facebook"></i></span> Log in with Facebook</a> </div>
						<div class="or-divider"><span>Or</span></div>
						<div class="login-fields">
							<div class="login-fields-holder">
								<input class="login-field" placeholder="Email Address" name="email" type="text">
							</div>
							<div class="login-fields-holder">
								<input class="login-field" placeholder="Password" name="password" type="password">
							</div>
						</div>
						<div class="login-remember">
							<div class="remember-check">
								<div class="rating-check">
									<input type="checkbox">
									<i class="icon ion-checkmark-round"></i> 
								</div>
								<label>Remember me</label>
							</div>
						<a href="javascript:void(0)" class="login-to-forgot">Forgot Password?</a> </div>
						<div class="login-submit">
							<button type="submit" id="user_login">Log In</button>
						</div>
					</div>
				</form>
				<div class="popup-foot">
					<p>Need an account? <a href="javascript:void(0)" class="login-to-signup">Sign up now!</a></p>
				</div>
			</div>
		</div>
	</div>
	
	
<script src="{{url('/assets/js/jquery.min.js')}}?v={{ uniqid() }}"></script>
<script src="{{url('/assets/js/jquery.mCustomScrollbar.concat.min.js')}}?v={{ uniqid() }}"></script>
<script>
	(function($){
		$(window).on("load",function(){
			$(".become-member-right").mCustomScrollbar({
				axis:'y',
				mouseWheel:true
			});
		});
	})(jQuery);

</script>	
</body>
</html>