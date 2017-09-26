<?php
 $cancel = false;
    $time = strtotime($checkin);
    $diff = $time - time();

    if($diff < 345600){
        $cancel = true;
    }


?>

@extends('layouts.main')

<div class="booking_process" style="display:none;">

@include('layouts.process')

</div>

<style>

.staying-days > a{

	height:34px;

}

.staying-days > a i{

	left: 0;

	position: absolute;

	right: 0;

	top: 10px;

}

.check-arrow {

	padding-top: 2px;

}

.fb-btn > span i{

	line-height:36px;

}

</style>

<?php

@session_start(); ?>

<base href="<?php app_path().'/Api/brain-tree/' ?>">

@section('content')

<?php require_once(app_path(). '/Api/brain-tree/global.php'); ?>

<div class="body-section payment-page">

<div class="paymentportal-sect">



        	<div class="container">

            <div id="success_msg"></div>



            <form id="cardForm">

            	<div class="paymentportal-sect-left">

                	<div class="hotel-name-desp">

                    	<h3>{{$hotel}}</h3>

                        <p>{{$address}} {{$cityName}}</p>

                    </div>

                   <?php if(session()->get('userLogin') != 1){?>

                    <div class="payment-signin">

                    	<span>Already a member? Signin for faster checkout.</span>

                        <a href="javascript:void(0)" class="login-link">Sign In</a>

                    </div>

                    <?php } ?>



                    <div class="payment-form traveler_information">

                    	<h4>Traveler Information</h4>

                       @if($totalrooms>1)
                       <?php $i=1;?>
                        @foreach($dispRooms as $key => $value)
                        <?php

                            if($value['adultSearch'] ==''){
                                $value['adultSearch'] = 0;
                            }
                            if($value['childrenSearch']==''){
                                $value['childrenSearch'] = 0;
                            }


                            ?>

                            <div class = "pform-row">
                                Room {{$i}} - {{$value['adultSearch']}} Adults, {{$value['childrenSearch']}} Children, {{$value['roomType']}} {{$value['bedType']}}
                            </div>

                            <div class="pform-row">

                        	<div class="pform-1">

                            	<label>Title</label>

                                <div class="icon-control">

                                	<select class="control-field valid" name="traveler_title{{$i}}" required>

                                    	<option value="">Title</option>

                                        <option value="Mr">Mr</option>

                                        <option value="Mis">Mis</option>

                                    </select>

                                    <span class="ion ion-arrow-down-b"></span>

                                </div>

                            </div>
                            <div class="err error_traveler_title" id="error_traveler_title" style="display:none;">Please select a title</div>

                            <div class="pform-2">

                            	<label>First Name</label>

                                <input class="control-field valid" placeholder="Enter First Name" type="text" name="traveler_fname{{$i}}" required="required">

                            </div>
                            <div class="err error_traveler_fname" id="error_traveler_fname" style="display:none;">Please enter first name</div>

                            <div class="pform-2">

                            	<label>Last Name</label>

                                <input class="control-field valid" placeholder="Enter Last Name" type="text" name="traveler_lname{{$i}}" required="required">

                            </div>
                            <div class="err error_traveler_lname" id="error_traveler_lname" style="display:none;">Please enter last name</div>


                        </div>
                        <?php $i++;?>
                        @endforeach
                       @else
                            <div class="pform-row">

                        	<div class="pform-1">

                            	<label>Title</label>

                                <div class="icon-control">

                                	<select class="control-field valid" name="traveler_title" required>

                                    	<option value="">Title</option>

                                        <option value="Mr">Mr</option>

                                        <option value="Mis">Mis</option>

                                    </select>

                                    <span class="ion ion-arrow-down-b"></span>

                                </div>

                            </div>
                            <div class="err error_traveler_title" id="error_traveler_title" style="display:none;">Please select a title</div>

                            <div class="pform-2">

                            	<label>First Name</label>

                                <input class="control-field valid" placeholder="Enter First Name" type="text" name="traveler_fname" required="required">

                            </div>
                            <div class="err error_traveler_fname" id="error_traveler_fname" style="display:none;">Please enter first name</div>

                            <div class="pform-2">

                            	<label>Last Name</label>

                                <input class="control-field valid" placeholder="Enter Last Name" type="text" name="traveler_lname" required="required">

                            </div>
                            <div class="err error_traveler_lname" id="error_traveler_lname" style="display:none;">Please enter last name</div>


                        </div>
                       @endif

                        <div class="pform-row">

                            <label>Your Confirmation Email</label>

                            <input class="control-field valid" value="<?php if(session()->get('userLogin') == 1){ echo session()->get('userEmail'); } ?>" placeholder="So we can send you your email confirmation" type="email" name="traveler_email" required="required">

                        </div>
                            <div class="err error_traveler_email" id="error_traveler_email" style="display:none;">Please enter email</div>


                    </div>



                    <div class="payment-form promo">

                    	<div class="title_promo">

                            <h4>Promo</h4>

                            <p><span>Have a Promo Code? <a href="javascript:void(0)" class="promo-code-link">Click here!</a></span><a href="javascript:void(0)" class="promo-code-link promo-code-link-after">Nevermind</a></p>

                        </div>

						<div class="promo-field">

							<input class="control-field valid" name="" placeholder="Plug in your promo here" type="text">

						</div>

                    </div>

                    <div class="payment-form payment">

                    	<div class="title_promo">

                            <h4>Payment</h4>

                            <ul class="card_list">

                            	<li><a href="#"><img src="{{url('/assets/images/card_01.png')}}" alt="card_01"></a></li>

                                <li><a href="#"><img src="{{url('/assets/images/card_02.png')}}" alt="card_02"></a></li>

                                <li><a href="#"><img src="{{url('/assets/images/card_03.png')}}" alt="card_03"></a></li>

                                <li><a href="#"><img src="{{url('/assets/images/card_04.png')}}" alt="card_04"></a></li>

                            </ul>

                        </div>

                        <div class="card_info">

                            <h5>Card Information</h5>

                            <div class="pform-row">

                                <label>Cardholder Name</label>

                                <input class="control-field valid" type="text" name="booking_cardholder" required="required">

                            </div>
                            <div class="err error_booking_cardholder" id="error_booking_cardholder" style="display:none;">Please enter cardholder name</div>


                            <div class="pform-row">

                            	<label>Debit/Credit card number</label>

                                <div id="card_number" class="control-field valid"></div>

                            </div>


                            <div class="pform-row">

                                <div class="pform-1">

                           			<label>Expiration date</label>

                                    <div class="icon-control">

                                        <div id="month" class="control-field valid"></div>

                                        <span class="ion ion-arrow-down-b"></span>

                                    </div>

                                </div>

                                <div class="pform-1">

                                	<label>&nbsp;</label>

                                    <div class="icon-control">

                                        <div id="year" class="control-field valid"></div>

                                        <span class="ion ion-arrow-down-b"></span>

                                    </div>

                                </div>

                                <div class="pform-2">

                                    <label>Security Code <a href="javascript:void(0)" class="security-code-link">What's this?</a></label>

                                    <input class="control-field valid" type="text" name="booking_security_code">

                                </div>
                            <div class="err error_booking_security_code" id="error_booking_security_code" style="display:none;">Please enter security code</div>


                            </div>

                        </div>

                        <div class="clear"></div>

                        <div class="billing_address">

                        	<h5>Billing Address</h5>

                            <div class="pform-row">

                                <div class="pform-1 country">

                                    <label>Country</label>

                                    <div class="icon-control">

                                        <select class="control-field valid" name="booking_country" required="required">

                                            <option value="">Select</option>

                                             <option value="US">US</option>

                                        </select>

                                        <span class="ion ion-arrow-down-b"></span>

                                    </div>

                                </div>
                            <div class="err error_booking_country" id="error_booking_country" style="display:none;">Please select country</div>


                            </div>

                            <div class="pform-row">

                                <label>Street Address 1</label>

                                <input class="control-field valid" type="text" name="booking_address1" required="required">

                            </div>
                            <div class="err error_booking_address1" id="error_booking_address1" style="display:none;">Please enter address</div>


                            <div class="pform-row">

                                <label>Street Address 2</label>

                                <input class="control-field valid" type="text" name="booking_address2">

                            </div>
                            <div class="err error_booking_address2" id="error_booking_address2" style="display:none;">Please enter address</div>

                            <div class="pform-row">

                                <div class="pform-1">

                                    <label>City</label>

                                    <input class="control-field valid" type="text" name="booking_city" required="required">

                                </div>
                            <div class="err error_booking_city" id="error_booking_city" style="display:none;">Please enter city</div>

                                <div class="pform-1 state">

                                    <label>State</label>

                                    <div class="icon-control">

                                        <select class="control-field valid" name="booking_state" required="required">

                                            <option value="">Select</option>

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

                                        <span class="ion ion-arrow-down-b"></span>

                                    </div>

                                </div>
                            <div class="err error_booking_state" id="error_booking_state" style="display:none;">Please enter state</div>


                                <div class="pform-2">

                                    <label>Zip Code</label>

                                    <input class="control-field valid" type="text" name="booking_zipcode" required="required">

                                </div>
                            <div class="err error_booking_zipcode" id="error_booking_zipcode" style="display:none;">Please enter zip code</div>


                            </div>

                    	</div>

                         <div class="clear"></div>

                    </div>

                    <div class="payment-form payment member">

                    	<h4>Become a member</h4>

                        <p>The information below will allow you to manage the reservation</p>

                    	<div class="member_become">

                        	<div class="pform-row">

                             	<div class="pform-1 title">

                                    <label>Title</label>

                                    <div class="icon-control">

                                        <select class="control-field valid" name="member_title">

                                            <option value="">Title</option>

                                            <option value="Mr">Mr</option>

                                            <option value="Mis">Mis</option>

                                        </select>

                                        <span class="ion ion-arrow-down-b"></span>

                                    </div>

                                </div>
                            <div class="err error_member_title" id="error_member_title" style="display:none;">Please select a title</div>


                                <div class="pform-1">

                                    <label>First Name</label>

                                    <input class="control-field" placeholder="Enter first Name" type="text" name="member_fname">

                                </div>
                            <div class="err error_member_fname" id="error_member_fname" style="display:none;">Please enter first name</div>




                                <div class="pform-2">

                                     <label>Last Name</label>

                                    <input class="control-field" placeholder="Enter Last Name" type="text" name="member_lname">

                                </div>
                            <div class="err error_member_lname" id="error_member_lname" style="display:none;">Please enter last name</div>


                            </div>

                            <div class="pform-row">

                                <label>Your Email</label>

                                <input class="control-field" value="<?php if(isset($_SESSION["user_login"])){ echo $_SESSION["user_login"]; } ?>" placeholder="Enter Email Address" type="text" name="member_email">

                            </div>

                            <div class="err error_member_email" id="error_member_email" style="display:none;">Please enter email</div>


                            <div class="pform-row">

                                <label>Phone</label>

                                <input class="control-field" placeholder="Enter Phone Number" type="text" name="member_phone">

                            </div>
                            <div class="err error_member_phone" id="error_member_phone" style="display:none;">Please enter a phone</div>



                    	</div>

                    </div>

                    <div class="payment-form terms_conditoin">

                    	<h4>Accept Terms &amp; Conditions</h4>



                        <p>We understand that sometimes your travel plans change. we do not charge a change or cancel fee. However, this property ({{$hotel}}) impose the following penalty to its customers that we are   to pass on: Cancellations or changes made after 1:00 AM ((GMT-0800) Pacific Time (US &amp; Canada); Tijuana) on Sep 2, 2016, or no-shows, are subject to a 1 Night Room &amp; Tax Penalty.</p>

                        <p>By selecting to complete this booking I acknowledge that I have read and  accept the <a href="javascript:void(0)" class="property-policy-link">Property Policies</a>, <a href="javascript:void(0)" class="occupation-link">Occupancy Restrictions</a>, <a href="javascript:void(0)" class="room-type-link">Room Type Details</a>, <a href="javascript:void(0)" class="web-terms-link">Websites Terms of Use</a> and <a href="javascript:void(0)" class="tl-terms-link">Travel Linked Terms of Services</a>.</p>

                        <p>Full payment will by charged by TravelLinked when you book this hotel</p>

                        <div class="payment-signin reservation">

             		 <input type="hidden" name="nonce" id="nonce_token">

                            <input value="Confirm Your Reservation" id="submit" type="submit">

                        </div>

                    </div>

                </div>

             </form>

                <div class="paymentportal-sect-right">

                	<div class="venue-img">

                    	<img style="height:120px; width:300px;" src="{{$image}}">

                    </div>

                    <div class="trip_summary">

                        <div class="venu-text">

                            <h2>Trip Summary</h2>

                        </div>

                        <div class="venu-text box">

                            <?php if($totalrooms > 1){ ?>

                            <h4>{{$totalrooms}} Rooms</h4>

							<?php }else{ ?>
                            <h4>Room</h4>

                            <?php

                            }

							foreach($dispRooms as $key => $value){ ?>

                            <?php if($totalrooms > 1){ ?>

                            <h5>Room {{$key+1}}</h5>

                            <?php }

                            if($value['adultSearch'] ==''){
                                $value['adultSearch'] = 0;
                            }
                            if($value['childrenSearch']==''){
                                $value['childrenSearch'] = 0;
                            }


                            ?>

                            <span>{{$value['roomType']}} {{$value['bedType']}}</span>

                            <span>{{$value['adultSearch']}} Adults, {{$value['childrenSearch']}} Children</span>

                            <?php } ?>

                        </div>

                        <div class="venu-text box">

                            <?php if($nights > 1){ ?>

                            <h4>{{$nights}} Nights</h4>

							<?php }else{ ?>

                            <h4>{{$nights}} Night</h4>

                            <?php } ?>

                            <div class="top_night_parent">

                            	<div class="left_excl">

                                	<h5>Check In</h5>

                                </div>

                                <div class="right_excl">

                                	<span><?php

									$yrdata= strtotime($checkin);

									echo date('D, M j Y', $yrdata);



									?></span>

                                </div>

                           </div>

                            <div class="top_night_parent">

                            	<div class="left_excl">

                                	<h5>Check Out</h5>

                                </div>

                                <div class="right_excl">

                                	<span>

                                    <?php

									$yrdata= strtotime($checkout);

									echo date('D, M j Y', $yrdata);



									?>



                                    </span>

                                </div>

                           </div>



                        </div>

                      <?php

					 	$check = explode(",",$amendmentType);

					  if($hotel_fee > 0 || $cancel || $check[0] != "Cancel" || isset($check[1]) != "Modify"){ ?>

                         <div class="venu-text box">

                            <h4>Things to Note</h4>

                        <?php if($hotel_fee > 0) {?>

                            <p>Mandatory Resort Fee</p>

                            <span><?php echo $resortFee; ?> Per Day Per Room</span>

                        <?php }if($check[0] != "Cancel" || $cancel || isset($check[1]) != "Modify"){ ?>

                            <p class="policy">Cancelation Policy</p>

                            <p class="red">Non Refundable booking</p>

                         </div>

                        <?php }} ?>

                        <div class="venu-text box">

                            <h4>Charges</h4>

                            <div class="top_night_parent">

                            	<div class="left_excl">

                                	<h5>Subtotal</h5>

                                </div>

                                <div class="right_excl">

                                	<span>${{$totalRate}}</span>

                                </div>

                           </div>

                            <div class="top_night_parent">

                            	<div class="left_excl">

                                	<h5>Tax</h5>

                                </div>

                                <div class="right_excl">

                                	<span>${{$tax}}</span>

                                </div><br />

                              <?php if($actualTax > 0){ ?>

                              <div class="left_excl">

                                	<h5>Tax by provider</h5>

                                </div>

                              <div class="right_excl">

                                	<span>{{$percentTax}}</span>

                                </div>

                              <?php } ?>

                           </div>

                            <div class="top_night_parent">

                            <?php if($hotel_fee > 0){ ?>

                                <div class="left_excl">

                                	<h5>Hotel Fees (due at hotel)</h5>

                                </div>

                                <div class="right_excl">

                                	<span>$<?php echo $hotel_fee; ?></span>

                                </div>

                            <?php } ?>

                           </div>

                            <div class="top_night_parent bold">

                            	<div class="left_excl">

                                	<h5>Estimate Grand Total</h5>

                                </div>

                                <div class="right_excl">

                                	<span>${{$grandTotal}}</span>

                                </div>

                           </div>

                        </div>

                    </div>

                    <div class="total-amount">

                    	<div class="top_night_parent">

                            <div class="left_excl">

                                <h5>Due Now</h5>

                            </div>

                            <div class="right_excl">

                                <span>${{$grandTotal-$hotel_fee}}</span>

                            </div>

                       </div>

                    </div>

                </div>

            	<div class="clear"></div>

            </div>

        	<div class="clear"></div>

   		</div>

</div>



@endsection
