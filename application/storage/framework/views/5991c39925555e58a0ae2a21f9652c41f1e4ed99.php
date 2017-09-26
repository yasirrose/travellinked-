<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TRAVEL LINKED</title>
	<link rel="shortcut icon" type="image/png" href="<?php echo e(url('/assets/images/favicon.png')); ?>"/>
	<link href="<?php echo e(url('/assets/css/ionicons.min.css')); ?>" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo e(url('/assets/css/jquery.mCustomScrollbar.css')); ?>">
	<link href="<?php echo e(url('/assets/css/style.css')); ?>?v=<?php echo e(uniqid()); ?>" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo e(url('/assets/css/jquery-ui.css')); ?>">
	<link href="<?php echo e(url('/assets/css/jquery.mCustomScrollbar.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(url('/assets/css/font-awesome.min.css')); ?>" rel="stylesheet">
	<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo e(url('/assets/css/daterangepicker.css')); ?>?v=<?php echo e(uniqid()); ?>">
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
	<style>
		.signup-form-btm h4 {
			font-size: 12px;
			font-weight: normal;
		}
	</style>
</head>

<body>

<div class="signup-page" id="signup-page" style="display: none;">
	<div class="signup-page-inner">
		<div class="signup-page-logo">
			<a href="#">
				<img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png">
			</a>
		</div>

		<div class="signup-page-form" id="secondPage" style="display:none;">
			<div class="signup-wizard-links">
				<ul id="1">
					<li class="active" onClick="ShowSecondPage('secondPage','secondPage')"></li>
					<li onClick="ShowSecondPage('secondPage','phoneC')"><a href="#phoneC"></a></li>
					<li onClick="ShowSecondPage('secondPage','emailConfirm')"><a href="#emailConfirm"></a></li>
					<!-- <li onclick="ShowSecondPage('secondPage','tell-us')"><a href="#tell-us"></a></li> -->
				</ul>
			</div>
			<div class="signup-form-head">
				<h1>What's Your Location</h1>
				<p>What is the purpose of your account, and how do you plan to use Travel Linked?</p>
			</div>
			<div class="signup-form-btm">
				<div class="signup-form-row">
					<div class="icon-control">
						<select class="signup-form-field" id="coutry" name="country" onChange="loadstate()">
							<option disabled selected>Country</option>
							<option value="Afghanistan">Afghanistan</option>
							<option value="Aland Islands">Åland Islands</option>
							<option value="Åland Islands">Albania</option>
							<option value="Algeria">Algeria</option>
							<option value="American Samoa">American Samoa</option>
							<option value="Andorra">Andorra</option>
							<option value="Angola">Angola</option>
							<option value="Anguilla">Anguilla</option>
							<option value="Antarctica">Antarctica</option>
							<option value="Antigua and Barbuda">Antigua and Barbuda</option>
							<option value="Argentina">Argentina</option>
							<option value="Armenia">Armenia</option>
							<option value="Aruba">Aruba</option>
							<option value="Australia">Australia</option>
							<option value="Austria">Austria</option>
							<option value="Azerbaijan">Azerbaijan</option>
							<option value="Bahamas">Bahamas</option>
							<option value="Bahrain">Bahrain</option>
							<option value="Bangladesh">Bangladesh</option>
							<option value="Barbados">Barbados</option>
							<option value="Belarus">Belarus</option>
							<option value="Belgium">Belgium</option>
							<option value="Belize">Belize</option>
							<option value="Benin">Benin</option>
							<option value="Bermuda">Bermuda</option>
							<option value="Bhutan">Bhutan</option>
							<option value="Bolivia">Bolivia, Plurinational State of</option>
							<option value="Bonaire">Bonaire, Sint Eustatius and Saba</option>
							<option value="Bosnia">Bosnia and Herzegovina</option>
							<option value="Botswana">Botswana</option>
							<option value="Bouvet">Bouvet Island</option>
							<option value="Brazil">Brazil</option>
							<option value="British Indian Ocean">British Indian Ocean Territory</option>
							<option value="Brunei">Brunei Darussalam</option>
							<option value="Bulgaria">Bulgaria</option>
							<option value="Burkina">Burkina Faso</option>
							<option value="Burundi">Burundi</option>
							<option value="Cambodia">Cambodia</option>
							<option value="Cameroon">Cameroon</option>
							<option value="Canada">Canada</option>
							<option value="Cape Verde">Cape Verde</option>
							<option value="Cayman">Cayman Islands</option>
							<option value="Central African Republic">Central African Republic</option>
							<option value="Chad">Chad</option>
							<option value="Chile">Chile</option>
							<option value="China">China</option>
							<option value="Christmas Island">Christmas Island</option>
							<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
							<option value="Colombia">Colombia</option>
							<option value="Comoros">Comoros</option>
							<option value="Congo">Congo</option>
							<option value="Congo">Congo, the Democratic Republic of the</option>
							<option value="Cook Islands">Cook Islands</option>
							<option value="Costa Rica">Costa Rica</option>
							<option value="Côte d'Ivoire">Côte d'Ivoire</option>
							<option value="Croatia">Croatia</option>
							<option value="Cuba">Cuba</option>
							<option value="Curaçao">Curaçao</option>
							<option value="Cyprus">Cyprus</option>
							<option value="Czech Republic">Czech Republic</option>
							<option value="Denmark">Denmark</option>
							<option value="Djibouti">Djibouti</option>
							<option value="Dominica">Dominica</option>
							<option value="Dominican Republic">Dominican Republic</option>
							<option value="Ecuador">Ecuador</option>
							<option value="Egypt">Egypt</option>
							<option value="El Salvador">El Salvador</option>
							<option value="Equatorial Guinea">Equatorial Guinea</option>
							<option value="Eritrea">Eritrea</option>
							<option value="Estonia">Estonia</option>
							<option value="Ethiopia">Ethiopia</option>
							<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
							<option value="Faroe Islands">Faroe Islands</option>
							<option value="Fiji">Fiji</option>
							<option value="Finland">Finland</option>
							<option value="France">France</option>
							<option value="French Guiana">French Guiana</option>
							<option value="French Polynesia">French Polynesia</option>
							<option value="French Southern Territories">French Southern Territories</option>
							<option value="Gabon">Gabon</option>
							<option value="Gambia">Gambia</option>
							<option value="Georgia">Georgia</option>
							<option value="Germany">Germany</option>
							<option value="Ghana">Ghana</option>
							<option value="Gibraltar">Gibraltar</option>
							<option value="Greece">Greece</option>
							<option value="Greenland">Greenland</option>
							<option value="Grenada">Grenada</option>
							<option value="Guadeloupe">Guadeloupe</option>
							<option value="Guam">Guam</option>
							<option value="Guatemala">Guatemala</option>
							<option value="Guernsey">Guernsey</option>
							<option value="Guinea">Guinea</option>
							<option value="Guinea-Bissau">Guinea-Bissau</option>
							<option value="Guyana">Guyana</option>
							<option value="Haiti">Haiti</option>
							<option value="Heard Island ">Heard Island and McDonald Islands</option>
							<option value="Holy See">Holy See (Vatican City State)</option>
							<option value="Honduras">Honduras</option>
							<option value="Hong Kong">Hong Kong</option>
							<option value="Hungary">Hungary</option>
							<option value="Iceland">Iceland</option>
							<option value="India">India</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
							<option value="Iraq">Iraq</option>
							<option value="Ireland">Ireland</option>
							<option value="sle of Man">Isle of Man</option>
							<option value="Israel">Israel</option>
							<option value="Italy">Italy</option>
							<option value="Jamaica">Jamaica</option>
							<option value="Japan">Japan</option>
							<option value="Jersey">Jersey</option>
							<option value="Jordan">Jordan</option>
							<option value="Kazakhstan">Kazakhstan</option>
							<option value="Kenya">Kenya</option>
							<option value="Korea">Korea, Republic of</option>
							<option value="Kuwait">Kuwait</option>
							<option value="Kyrgyzstan">Kyrgyzstan</option>
							<option value="Latvia">Latvia</option>
							<option value="Lebanon">Lebanon</option>
							<option value="Lesotho">Lesotho</option>
							<option value="Liberia">Liberia</option>
							<option value="Libya">Libya</option>
							<option value="Liechtenstein">Liechtenstein</option>
							<option value="Lithuania">Lithuania</option>
							<option value="Luxembourg">Luxembourg</option>
							<option value="Macao">Macao</option>
							<option value="Macedonia">Macedonia, the former Yugoslav Republic of</option>
							<option value="Madagascar">Madagascar</option>
							<option value="Malawi">Malawi</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Maldives">Maldives</option>
							<option value="Mali">Mali</option>
							<option value="Malta">Malta</option>
							<option value="Marshall">Marshall Islands</option>
							<option value="Martinique">Martinique</option>
							<option value="Mauritania">Mauritania</option>
							<option value="Mauritius">Mauritius</option>
							<option value="Mayotte">Mayotte</option>
							<option value="Mexico">Mexico</option>
							<option value="Micronesia">Micronesia, Federated States of</option>
							<option value="Moldova">Moldova, Republic of</option>
							<option value="Monaco">Monaco</option>
							<option value="Mongolia">Mongolia</option>
							<option value="Montenegro">Montenegro</option>
							<option value="Montserrat">Montserrat</option>
							<option value="Morocco">Morocco</option>
							<option value="Mozambique">Mozambique</option>
							<option value="Myanmar">Myanmar</option>
							<option value="Namibia">Namibia</option>
							<option value="Nauru">Nauru</option>
							<option value="Nepal">Nepal</option>
							<option value="Netherlands">Netherlands</option>
							<option value="New Caledonia">New Caledonia</option>
							<option value="New Zealand">New Zealand</option>
							<option value="Nicaragua">Nicaragua</option>
							<option value="Niger">Niger</option>
							<option value="Nigeria">Nigeria</option>
							<option value="Niue">Niue</option>
							<option value="Norfolk">Norfolk Island</option>
							<option value="Northern">Northern Mariana Islands</option>
							<option value="Norway">Norway</option>
							<option value="Oman">Oman</option>
							<option value="Pakistan">Pakistan</option>
							<option value="Palau">Palau</option>
							<option value="Palestinian">Palestinian Territory, Occupied</option>
							<option value="Panama">Panama</option>
							<option value="Papua New Guinea">Papua New Guinea</option>
							<option value="Paraguay">Paraguay</option>
							<option value="Peru">Peru</option>
							<option value="Philippines">Philippines</option>
							<option value="Pitcairn">Pitcairn</option>
							<option value="Poland">Poland</option>
							<option value="Portugal">Portugal</option>
							<option value="Puerto">Puerto Rico</option>
							<option value="Qatar">Qatar</option>
							<option value="Réunion">Réunion</option>
							<option value="Romania">Romania</option>
							<option value="Russian">Russian Federation</option>
							<option value="Rwanda">Rwanda</option>
							<option value="Saint Barthélemy">Saint Barthélemy</option>
							<option value="Saint Helena">Saint Helena, Ascension and Tristan da Cunha</option>
							<option value="Saint Lucia">Saint Lucia</option>
							<option value="Saint Martin">Saint Martin (French part)</option>
							<option value="Saint Pierre">Saint Pierre and Miquelon</option>
							<option value="Saint Vincent">Saint Vincent and the Grenadines</option>
							<option value="Samoa">Samoa</option>
							<option value="San Marino">San Marino</option>
							<option value="Sao Tome and Principe">Sao Tome and Principe</option>
							<option value="Saudi Arabia">Saudi Arabia</option>
							<option value="Senegal">Senegal</option>
							<option value="Serbia">Serbia</option>
							<option value="Seychelles">Seychelles</option>
							<option value="Sierra Leone">Sierra Leone</option>
							<option value="Singapore">Singapore</option>
							<option value="int Maarten">Sint Maarten (Dutch part)</option>
							<option value="Slovakia">Slovakia</option>
							<option value="Slovenia">Slovenia</option>
							<option value="Solomon">Solomon Islands</option>
							<option value="Somalia">Somalia</option>
							<option value="South Africa">South Africa</option>
							<option value="South Sudan">South Sudan</option>
							<option value="Spain">Spain</option>
							<option value="Sri Lanka">Sri Lanka</option>
							<option value="Sudan">Sudan</option>
							<option value="Suriname">Suriname</option>
							<option value="Svalbard">Svalbard and Jan Mayen</option>
							<option value="Swaziland">Swaziland</option>
							<option value="Sweden">Sweden</option>
							<option value="Switzerland">Switzerland</option>
							<option value="Syrian Arab Republic">Syrian Arab Republic</option>
							<option value="Taiwan">Taiwan, Province of China</option>
							<option value="Tajikistan">Tajikistan</option>
							<option value="Tanzania">Tanzania, United Republic of</option>
							<option value="Thailand">Thailand</option>
							<option value="Timor-Leste">Timor-Leste</option>
							<option value="Togo">Togo</option>
							<option value="Tokelau">Tokelau</option>
							<option value="Tonga">Tonga</option>
							<option value="Trinidad">Trinidad and Tobago</option>
							<option value="Tunisia">Tunisia</option>
							<option value="Turkey">Turkey</option>
							<option value="Turkmenistan">Turkmenistan</option>
							<option value="Turks">Turks and Caicos Islands</option>
							<option value="Tuvalu">Tuvalu</option>
							<option value="Uganda">Uganda</option>
							<option value="Ukraine">Ukraine</option>
							<option value="United Arab Emirates">United Arab Emirates</option>
							<option value="United Kingdom">United Kingdom</option>
							<option value="United States">United States</option>
							<option value=" Outlying Islands">United States Minor Outlying Islands</option>
							<option value="Uruguay">Uruguay</option>
							<option value="Uzbekistan">Uzbekistan</option>
							<option value="Vanuatu">Vanuatu</option>
							<option value="Venezuela">Venezuela, Bolivarian Republic of</option>
							<option value="Viet Nam">Viet Nam</option>
							<option value="Virgin Islands, British">Virgin Islands, British</option>
							<option value="Virgin Islands U.S.">Virgin Islands, U.S.</option>
							<option value="Wallis and Futuna">Wallis and Futuna</option>
							<option value="Western Sahara">Western Sahara</option>
							<option value="Yemen">Yemen</option>
							<option value="Zambia">Zambia</option>
							<option value="Zimbabwe">Zimbabwe</option>
						</select>
						<h4 id="country_faze" class="signup-error">country is required</h4>
						<span class="ion ion-arrow-down-b"></span>
					</div>
				</div>
				<div class="text"></div>

				<div class="signup-form-row">
					<input type="text" name="straddress1" id="straddress1" class="signup-form-field" placeholder="Street Address 1">
					<h4 id="str1error" style="" class="signup-error">street address is required</h4>
				</div>
				<div class="signup-form-row">
					<input type="text" name="straddress2" id="straddress2"  class="signup-form-field" placeholder="Street Address 2">
					<h4 id="str2error" style="" class="signup-error">street address is required</h4>
				</div>
				<div class="signup-form-row">

					<div class="signup-w-120">
						<input type="text" class="signup-form-field" id="cty" name="city" placeholder="City">
						<h4 id="cityerror" style="" class="signup-error">City state is required</h4>
					</div>
					<div class="signup-w-80">
						<div class="icon-control">
							<select class="signup-form-field" name="state" id="state">
								<option disabled selected>State</option>
								<option value="AL">Alabama</option>
								<option value="AK">Alaska</option>
								<option value="AZ">Arizona</option>
								<option value="AR">Arkansas</option>
								<option value="CA">California</option>
								<option value="CO">Colorado</option>
								<option value="CT">Connecticut</option>
								<option value="DE">Delaware</option>
								<option value="DC">District Of Columbia</option>
								<option value="FL">Florida</option>
								<option value="GA">Georgia</option>
								<option value="HI">Hawaii</option>
								<option value="ID">Idaho</option>
								<option value="IL">Illinois</option>
								<option value="IN">Indiana</option>
								<option value="IA">Iowa</option>
								<option value="KS">Kansas</option>
								<option value="KY">Kentucky</option>
								<option value="LA">Louisiana</option>
								<option value="ME">Maine</option>
								<option value="MD">Maryland</option>
								<option value="MA">Massachusetts</option>
								<option value="MI">Michigan</option>
								<option value="MN">Minnesota</option>
								<option value="MS">Mississippi</option>
								<option value="MO">Missouri</option>
								<option value="MT">Montana</option>
								<option value="NE">Nebraska</option>
								<option value="NV">Nevada</option>
								<option value="NH">New Hampshire</option>
								<option value="NJ">New Jersey</option>
								<option value="NM">New Mexico</option>
								<option value="NY">New York</option>
								<option value="NC">North Carolina</option>
								<option value="ND">North Dakota</option>
								<option value="OH">Ohio</option>
								<option value="OK">Oklahoma</option>
								<option value="OR">Oregon</option>
								<option value="PA">Pennsylvania</option>
								<option value="RI">Rhode Island</option>
								<option value="SC">South Carolina</option>
								<option value="SD">South Dakota</option>
								<option value="TN">Tennessee</option>
								<option value="TX">Texas</option>
								<option value="UT">Utah</option>
								<option value="VT">Vermont</option>
								<option value="VA">Virginia</option>
								<option value="WA">Washington</option>
								<option value="WV">West Virginia</option>
								<option value="WI">Wisconsin</option>
								<option value="WY">Wyoming</option>
							</select>
							<!-- <h4 id="stati" style="" class="signup-error">state is required</h4>
							<span class="ion ion-arrow-down-b"></span> -->
						</div>
						<div class="city-text"></div>

					</div>
					<div class="signup-w-100">
						<input type="text" name="zip" id="zp" class="signup-form-field" placeholder="Zip Code">
						<h4 id="ziperror" style="" class="signup-error">zip code is required</h4>
					</div>

				</div>
				<div class="signup-form-btn">
					<button id="billing-address">Confirm Billing Address</button>
				</div>
			</div>
		</div>
		<div class="signup-page-welcome" id="firstItem" style="display: none">
			<div class="signup-page-welcome-inner">
				<h2>Welcome To The Club</h2>
				<p>Hosts on Airbnb are real people with real homes. That's why you'll have to confirm a few, quick details to activate your account.</p>
				<button id="first-step">Next - 4 steps left</button>
			</div>
		</div>
		<div class="signup-page-form" id="phoneC" style="display:none;">
			<div class="signup-wizard-links">
				<ul>
					<li  onclick="ShowthirdPage('phoneC','secondPage')"></li>
					<li class="active" onClick="ShowthirdPage('phoneC','phoneC')"><a href="#phoneC"></a></li>
					<li onClick="ShowthirdPage('phoneC','emailConfirm')"><a href="#emailConfirm"></a></li>
					<!-- <li onclick="ShowthirdPage('phoneC','tell-us')"><a href="#tell-us"></a></li> -->
				</ul>
			</div>
			<div class="signup-form-head">
				<h1>Confirm Your Phone Number</h1>
				<p>This is so we can connect with you that way we can ensure your always accommodated.</p>
			</div>
			<div class="signup-form-btm">
				<h4 id="phnerror" style="display: none">Phone is required</h4>
				<div class="signup-form-row phone-num">
					<label>Phone Number</label>
					<input type="text" name="phone" id="phn" class="signup-form-field" >
                    <h4 id="phhnn" style="" class="signup-error">phone is required</h4>
					<em>+1</em>
				</div>
				<div class="signup-form-btn">
					<button id="phoneConfirm">Confirm Phone Number</button>
				</div>
			</div>
		</div>
		<div class="signup-page-form" id="emailConfirm" style="display:none;">
			<div class="signup-wizard-links">
				<ul id="3">
					<li onClick="showemailPage('emailConfirm','secondPage')"><a href="#secondPage"></a></li>
					<li onClick="showemailPage('emailConfirm','phoneC')"><a href="#phoneC"></a></li>
					<li class="active" onClick="showemailPage('emailConfirm','emailConfirm')"></li>
					<!-- <li onclick="showemailPage('emailConfirm','tell-us')"><a href="#tell-us"></a></li> -->
				</ul>
			</div>
			<div class="signup-form-head">
				<h1>Check Your Email</h1>
				<p>Tap the link in the email we sent you. Confirming your email address helps us send you trip information.</p>
			</div>
			<div class="signup-form-btm">
				<h4 id="eml_eroor" style="display: none">Email is required</h4>
				<div class="signup-form-row change-email-field">
					<label>Email Address</label>
					<input type="text" name="changed_email" id="changed_email" class="signup-form-field" value="">
				</div>
				<div class="signup-form-btn change-email-link">
					<button id="resend-email">Send Email</button>
					<h4 id="confirmac" style="display: none;">Check your mail to confirm account</h4>
					<a href="#">Change Email Address</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="page-forgot-pass forgot-popup" id="tell-us" style="display:none;">
	<div class="page-forgot-pass-inner">
		<div class="page-forgot-pass-logo">
			<a href="#">
				<img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png">
			</a>
		</div>
		<div class="popup-inner">
			<div class="popup-body">
				<h3>Forgot your password? Don’t Panic<span>Enter the email address associated with your account, and we’ll email you a link to reset your password.</span></h3>
				 <div class="login-fields">
						<div class="login-fields-holder">
							<input class="login-field" placeholder="Email Address" name="email" type="text">
						</div>
					</div>
					<div class="login-submit">
						<button class="forgot-to-confirmation" type="submit" >Send Reset Link</button>
					</div>

			</div>
			<div class="popup-foot">
				<p>Ready to log in? <a href="javascript:void(0)" class="forgot-to-login">Go back</a></p>
			</div>
		</div>

	</div>
</div>
<div class="page-forgot-pass page-login" style="display: none">
	<div class="page-forgot-pass-inner">
		<div class="page-forgot-pass-logo">
			<a href="#">
				<img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png">
			</a>
		</div>
		<div class="popup-inner" >
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
<div class="become-member-page" id="member">
	<div class="become-member-left" >
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
	<?php if(session('error')): ?>
		<div class="alert alert-danger">
			<strong> <?php echo e(session('error')); ?></strong>
		</div>
	<?php endif; ?>
	<div class="become-member-right">
		<div class="become-member-right-inner">
			<h1>Become A Member</h1>
			<div class="become-member-fb">
				<a href="<?php echo e(url('userlogin/facebook')); ?>"><span><i class="fa fa-facebook"></i></span>Join with Facebook</a>
			</div>
			<div class="become-member-or">
				<span>Or</span>
			</div>



			<div class="become-member-form">
				<div class="signup-form-row">
					<div class="icon-control">
						<?php /*<select class="signup-form-field" name="month" id="mth">*/ ?>
						<select name="gender" class="signup-form-field" id="gender">
							<option value="0">Mr</option>
							<option value="1">Miss</option>
						</select>
						<span class="ion ion-arrow-down-b"></span>
					</div>
				</div>
				<div class="signup-form-row">
					<?php if(isset($user_email)): ?>
					<input type="email" class="signup-form-field" name="user_email" id="usr_email" value="<?php echo e($user_email); ?>" >
					<input type="hidden" class="form-control" name="facebook_id" id="facebook_id" value="<?php echo e($user_id); ?>">
					<?php else: ?>
						<input type="email" class="signup-form-field" name="user_email" id="usr_email" placeholder="Enter Email">
					<?php endif; ?>
					<h4 id="valid_emails"  class="signup-error" style="">Please provide valid email</h4>
					<h4 id="user_email" class="signup-error" style="">Email is required</h4>
					<div id="email_exist" class="signup-error" style="">This email already exist</div>
				</div>

				<div class="signup-form-row">
					<?php if(isset($fbname)): ?>
					<input  type="text" class="signup-form-field" name="first_name" id="frst_name" value="<?php echo e($fbname[0]); ?>" >
					<?php else: ?>
						<input  type="text" class="signup-form-field" name="first_name" id="frst_name" placeholder="First Name" >
					<?php endif; ?>
					<h4 id="feast_name" style="" class="signup-error">First Name is required</h4>
				</div>

				<div class="signup-form-row">
					<?php if(isset($fbname)): ?>
					<input type="text" class="signup-form-field" name="last_name" id="lst_name" value="<?php echo e($fbname[1]); ?>">
					<?php else: ?>
						<input type="text" class="signup-form-field" name="last_name" id="lst_name" placeholder="Last Name" >
						<?php endif; ?>
					<h4 id="last_name" class="signup-error" style="">Last Name is required</h4>
				</div>

				<div class="signup-form-row">
					<input  type="password" class="signup-form-field"  name="password" id="pssword" placeholder="Create a Password">
					<h4 id="paassword" style="" class="signup-error">Password is required</h4>
				</div>
				<div class="signup-form-row birthday-date-row">
					<p>Birthday <span id="valyear">To become part of the club, you must be 18 or older.</span></p>
					<div class="signup-w-120">
						<div class="icon-control">
							<select class="signup-form-field" name="month" id="mth">
								<option disabled="disabled" selected="">Month</option>
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
							    <option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
                            <h4 id="moth" class="signup-error" style="">Month is required</h4>
							<span class="ion ion-arrow-down-b"></span>
						</div>

					</div>
					<div class="signup-w-70">

						<div class="icon-control">
							<select class="signup-form-field" id="dy" name="day">
								<option disabled="" selected="">Day</option>
								<?php for($i=1;$i<31;$i++){?>
								<option value="<? echo $i;?>"><? echo $i;?></option>
								<?}?>
							</select>
                            <h4 id="selday" style="" class="signup-error">Day is required</h4>

							<span class="ion ion-arrow-down-b"></span>
						</div>
					</div>
					<div class="signup-w-90">

						<div class="icon-control">
							<select class="signup-form-field" name="year" id="yar">
								<option disabled="" selected="">Year</option>
								<?php for($y=1965; $y<=date('Y'); $y++){?>
								<option value="<?php echo $y;?>"><?php echo $y;?></option>
								<?php }?>
							</select>
                            <h4 id="selyar" style="" class="signup-error">year is required</h4>
							<span class="ion ion-arrow-down-b"></span>
						</div>
					</div>
				</div>
				<div class="become-member-terms">By signing up, I agree to Travel Linked's <a href="#">Website Terms of Use</a>, <a href="#">Property Policies</a>, <a href="#">Occupancy Restrictions</a>, <a href="#">Payments Terms of Service</a>, <a href="#">Privacy Policy</a>, and <a href="#">Refund Policy</a>.</div>
				<div class="signup-form-btn">
					<button id="join" onClick="first_validation()">Join Now</button>
				</div>
				<div class="members-login-link">
					<span>Are you already a member? <a href="<?php echo e('userlogin/simple'); ?>">Log in</a></span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="form-age-validator">
	<div class="form-age-validator-inner">
		<span class="form-age-close"><i class="icon ion-close-round"></i></span>
		<h2>Invalid User <span>To become part of the club, you must be 18 or older.</span></h2>
	</div>
</div>


<script src="<?php echo e(url('/assets/js/jquery.min.js')); ?>?v=<?php echo e(uniqid()); ?>"></script>
<script src="<?php echo e(url('/assets/js/jquery.mCustomScrollbar.concat.min.js')); ?>?v=<?php echo e(uniqid()); ?>"></script>

<script>
function loadstate(){
		var countery =$("#coutry :selected").attr('value');
				if(countery != "United States"){
					$("#state").attr("disabled", "true");	
				}
				else{
				$("#state").attr("disabled", "false");
				$('#state').removeAttr('disabled');
			}
		}
		function ShowSecondPage(id, active) {

        country = $('#country').val();
        straddress1 = $('#straddress1').val();
        straddress2 = $('#straddress2').val();
        city = $('#city').val();
        state = $('#state').val();
        zip = $('#zip').val();

		$('#' + id).hide();
		$('#' + active).show();

    }
    function  ShowthirdPage(id , active) {
        phone = $('#phone').val();
		$('#' + id).hide();
        $('#' + active).show();

    }
     function showemailPage(id, active) {
           email = $('#email').val();
            $('#' + id).hide();
            $('#' + active).show();

    }

    (function($){
        $(window).on("load",function(){
            $(".become-member-right").mCustomScrollbar({
                axis:'y',
                mouseWheel:true
            });
        });
    })(jQuery);
    var calculat_year='';
    var user_email='';
    var last_name = '';
    var first_name = '';
    var password='';
    var month = '';
    var day = '';
    var year= '';
    var city='';
    var country='';
    var straddress1 = '';
    var straddress2 = '';
    var state = '';
    var phone ='';
    var email='';
    var about = '';
    var zip='';
    var source = '';
    function first_validation() {

    }

	$(document).ready(function () {
		$('#join').click(function () {
		user_email = $('#usr_email').val();
		facebook_id = $('#facebook_id').val();
		modified_email = $('#changed_email').val(user_email);
        first_name =$('#frst_name').val();
        last_name = $('#lst_name').val();
        day = $('#dy').val();
        //month =$("#mth']").val();
        month =$("select#mth").val();
            gender= $("select#gender").val()
            year = $('#yar').val();
        password = $('#pssword').val();
        calculat_year = new Date().getFullYear() - year;

         if(user_email==''){
            $('#user_email').addClass('fade');
			 $( "input[name='user_email']").addClass('signup-field-error');
        }
			$("input[name='user_email']").keyup(function() {

                 user_email = $("input[name='user_email']").val();
				if(user_email == ''){
                    $("input[name='user_email']").addClass('signup-field-error');
                }

			});
        if(user_email){
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            if (pattern.test(user_email) == false){
                $('#user_email').removeClass('fade');
				$('#valid_emails').addClass('fade');
                $("input[name='user_email']").addClass('signup-field-error');
                user_email='';
            }
            else{
                $('#valid_emails').removeClass('fade');
                $("input[name='user_email']").removeClass('signup-field-error');
			}
		}


            if(first_name==''){
            $('#feast_name').addClass('fade');
            $( "input[name='first_name']" ).addClass('signup-field-error')
        }
            $("input[name='first_name']").keyup(function(){

                var first_name =  $("input[name='first_name']").val();
                if(first_name==''){
                    $( "input[name='first_name']" ).addClass('signup-field-error');
                }
                else{
                    $("input[name='first_name']").removeClass('signup-field-error');
				}
                });


        if(last_name==''){
            $('#last_name').addClass('fade');
            $( "input[name='last_name']" ).addClass('signup-field-error');
        }
            $("input[name='last_name']" ).keyup(function () {
                var last_name = $("input[name='last_name']").val();

                if(last_name==''){
                    $( "input[name='last_name']" ).addClass('signup-field-error');
				}
				else {
                    $("input[name='last_name']").removeClass('signup-field-error');
                }
            });
			if(password==''){
            $('#paassword').addClass('fade');
            $("input[name='password']").addClass('signup-field-error');
        }
			$("input[name='password']").keyup(function (){

             var password = $('#pssword').val();
				if(password==''){
                 $("input[name='password']").addClass('signup-field-error');
			 }
			 else {
                 $("input[name='password']").removeClass('signup-field-error');
             }
             });



            if(calculat_year < 18){
                $('.form-age-validator').addClass('show');
				$('.form-age-close').click(function(){
					$('.form-age-validator').removeClass('show');
				});
            }

        if(month==null){

            $('#moth').addClass('fade');
            $("select[name='month']").addClass('signup-field-error');
		}


             $('#mth').change(function () {
				var month = $('#mth').val();
                if(month==''){
                    $("select[name='month']").addClass('signup-field-error');
				}
				else{
                    $("select[name='month']").removeClass('signup-field-error');
				}
            })


            if(day==null){
                $('#selday').addClass('fade');
                $("select[name='day']").addClass('signup-field-error');
                //  $('#mth').addClass('signup-field-error');
            }

                $('#dy').change(function () {
                    var day = $('#dy').val();
                    if(day==''){
                        $("select[name='day']").addClass('signup-field-error');
                    }
                    else{
                        $("select[name='day']").removeClass('signup-field-error');
                    }
                })
            if(year==null){
                $('#selyar').addClass('fade');
                $("select[name='year']").addClass('signup-field-error');
            }
            $('#yar').change(function () {
                var year = $('#yar').val();
                if(year==null){
                    $("select[name='year']").addClass('signup-field-error');
                }
                else{
                    $("select[name='year']").removeClass('signup-field-error');
                }
            })

        if(user_email && first_name && last_name && password && year && month && day){
            if(calculat_year < 18){
                $('.form-age-validator').addClass('show');
                $('.form-age-close').click(function(){
                    $('.form-age-validator').removeClass('show');
                });
            }else{
                $('#member').hide();
                $('#signup-page').show();
                $('#firstItem').show();
			}

        }
        });
	 $('#first-step').click(function () {
        $('#firstItem').hide();
        $('#secondPage').show();
    });
    $('#billing-address').click(function () {
		country = $('#coutry').val();
        straddress1 = $('#straddress1').val();
        straddress2 = $('#straddress2').val();
        city = $('#cty').val();
        state = $('#state').val();
        zip = $('#zp').val();
        if(country==null){
            $('#country_faze').addClass('fade');
            $("select[name='country']").addClass('signup-field-error');
        }
        $('#coutry').change(function () {
            country = $('#coutry').val();
            if(country==null){
                $("select[name='country']").addClass('signup-field-error');
            }
            else{
                $("select[name='country']").removeClass('signup-field-error');
            }
        })


        if(straddress1 ==''){
			$('#str1error').addClass('fade');
            $("input[name='straddress1']").addClass('signup-field-error');
        }
            $("input[name='straddress1']").keyup(function () {
                straddress1 = $("input[name='straddress1']").val();
            if(straddress1==''){
                $("input[name='straddress1']").addClass('signup-field-error');
            }
            else{
                $("input[name='straddress1']").removeClass('signup-field-error');
            }
            });

        if(straddress2==''){
            $('#str2error').addClass('fade');
            $("input[name='straddress2']").addClass('signup-field-error');
		}
            $("input[name='straddress2']").keyup(function () {
                 straddress2 = $("input[name='straddress2']").val();
                if (straddress2== '') {
                    $("input[name='straddress2']").addClass('signup-field-error');
                }
                else {
                    $("input[name='straddress2']").removeClass('signup-field-error');
                }
            });


		if(city){
            $('#cityerror').addClass('fade');
            $("input[name='city']").addClass('signup-field-error');
           	}
        $("input[name='city']").keyup(function () {
            var city = $("input[name='city']").val();
            if (city == '') {
                $("input[name='city']").addClass('signup-field-error');
            }
            else {
                $("input[name='city']").removeClass('signup-field-error');
            }
        });
		if(zip==''){
            $('#ziperror').addClass('fade');
            $("input[name='city']").addClass('signup-field-error');
		}
        $("input[name='zip").keyup(function () {
           var zip =$("input[name='zip").val();
           if(zip==''){
               $("input[name='zip").addClass('signup-field-error');
           }
           else{
               $("input[name='zip']").removeClass('signup-field-error');
           }
           });


        if(country && straddress1 || straddress2 && city && zip && state){
            $('#phoneC').show();
            $('#secondPage').hide();
        }
    });
    $('#phoneConfirm').click(function () {
        phone = $("input[name='phone']").val();
       if(phone==''){
           $("#phhnn").addClass('fade');
           $("input[name='phone']").addClass('signup-field-error');
       }
         $("input[name='phone']").keyup(function () {
             phone = $("input[name='phone']").val();

             if(phone==''){
                 $("input[name='phone']").addClass('signup-field-error');
             }
             else{
                 $("input[name='phone']").removeClass('signup-field-error');

             }
         });
        facebook_id = $('#facebook_id').val();
        if(facebook_id == null){
            if(phone) {
                $('#emailConfirm').show();
                $('#phoneC').hide();
            }
		}else{
            $.ajax({
                url: "<?php echo e(URL('submitForm')); ?>",
                type: "POST",
                data:{
                    "email":user_email,
                    "fname":first_name,
                    "lname":last_name,
                    "facebook_id":facebook_id,
                    "password":password,
                    "day":day,
                    "month":month,
                    "year":year,
                    "country" : country,
                    "straddress1": straddress1,
                    "straddress2":straddress2,
                    "city" : city,
                    "state":state,
                    "zip":zip,
                    "phone":phone,
                    "about":about,
                    "source":source,
                    "_token": "<?php echo e(csrf_token()); ?>"
                },
                success:function (data) {
                    if (data==1) {
                        window.location = "http://travellinked.com/travellinked/signup";
                        alert('email already exists');
                    } else {
                        window.location.href = '<?php echo e(url('userlogin/facebook')); ?>';
                    }
                }
            })
		}

    });

    $('#resend-email').click(function () {
    	modified_email = $('#changed_email').val();
         ready(modified_email);
	});
		$('#confirmac').click(function () {
			$('#confirmac').hide();
        })

       

 });

	function ready(changedEmail) {
		$.ajax({
            url: "<?php echo e(URL('submitForm')); ?>",
            type: "POST",
            data:{
                "email":changedEmail,
				"fname":first_name,
				"lname":last_name,
				"facebook_id":facebook_id,
				"password":password,
				"day":day,
				"month":month,
				"year":year,
				"country" : country,
                "straddress1": straddress1,
                "straddress2":straddress2,
                "city" : city,
				"state":state,
                "zip":zip,
				"phone":phone,
                "about":about,
				"source":source,
				"gender":gender,
				"_token": "<?php echo e(csrf_token()); ?>"
            },
            success:function (data) {

				if (data==1) {
                    window.location = "http://travellinked.com/travellinked/signup";
				    alert('email already exists');
				}
                else {
                    $('#confirmac').show();
               }
            }
		})
    }

</script>
</body>
</html>