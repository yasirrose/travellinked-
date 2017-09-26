<?php
    $cancel = false;
    $time = strtotime($checkin);
    $diff = $time - time();
    if ($diff < 345600) {
        $cancel = true;
    }
?>

<div class="booking_process" style="display:none;"> <?php echo $__env->make('layouts.process', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </div>
<style>
    .staying-days > a {
        height: 34px;
    }
    .staying-days > a i {
        left: 0;
        position: absolute;
        right: 0;
        top: 10px;
    }
    .check-arrow {
        padding-top: 2px;
    }
    .fb-btn > span i {
        line-height: 36px;
    }
</style>
//==============Page code started...
@session_start();
<base href="<?php app_path() . '/Api/brain-tree/' ?>">
<?php $__env->startSection('content'); ?>
    <?php require_once(app_path() . '/Api/brain-tree/global.php'); ?>
    <div class="body-section payment-page">
        <div class="paymentportal-sect">
            <div class="container">
                <div id="success_msg"></div>
                <form id="cardForm">
                    <div class="paymentportal-sect-left">
                        <div class="hotel-name-desp">
                            <h3><?php echo e($hotel); ?></h3>
                            <p><?php echo e($address); ?> <?php echo e($cityName); ?></p>
                        </div>
                        <?php if(session()->get('userLogin') != 1){?>
                            <div class="payment-signin">
                                <span>Already a member? Signin for faster checkout.</span>
                                <a href="<?php echo e(url('userlogin')); ?>" class="login-link">Sign In</a>
                            </div>
                        <?php } ?>
                        <div class="payment-form traveler_information">
                            <h4>Traveler Information</h4>
                            <?php if($totalrooms>1): ?>
                                <?php $i = 1;?>
                                <?php foreach($dispRooms as $key => $value): ?>
                                    <?php

                                    if ($value['adultSearch'] == '') {
                                        $value['adultSearch'] = 0;
                                    }
                                    if ($value['childrenSearch'] == '') {
                                        $value['childrenSearch'] = 0;
                                    }


                                    ?>
                                    <div class="pform-row"> Room <?php echo e($i); ?> - <?php echo e($value['adultSearch']); ?>

                                        Adults, <?php echo e($value['childrenSearch']); ?>

                                        Children, <?php echo e($value['roomType']); ?> <?php echo e($value['bedType']); ?> </div>
                                    <div class="pform-row">
                                        <div class="pform-1 validated">
                                            <label>Title</label>
                                            <div class="icon-control">
                                                <select class="control-field valid" name="traveler_title<?php echo e($i); ?>"
                                                        required>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mis">Mis</option>
                                                </select>
                                                <span class="ion ion-arrow-down-b"></span>
                                            </div>
                                            <div class="err" id="title_error" style="display:none;">Please select a title</div>
                                        </div>
                                        <div class="pform-2 validated">
                                            <label>First Name</label>
                                            <input class="control-field valid" placeholder="Enter First Name"
                                                   type="text" name="traveler_fname<?php echo e($i); ?>" value="">
                                            <div class="err">Please enter first name</div>
                                        </div>
                                        <div class="pform-2 validated">
                                            <label>Last Name</label>
                                            <input class="control-field valid" placeholder="Enter Last Name" type="text"
                                                   name="traveler_lname<?php echo e($i); ?>" required="required">
                                            <div class="err">Please enter last name</div>
                                        </div>
                                    </div>
                                    <?php $i++;?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="pform-row">
                                    <div class="pform-1 validated">
                                        <label>Title</label>
                                        <div class="icon-control">
                                            <select class="control-field valid" name="traveler_title" required>
                                                <option value="">Title</option>
                                                <option value="Mr">Mr</option>
                                                <option value="Mis">Mis</option>
                                            </select>
                                            <span class="ion ion-arrow-down-b"></span>
                                        </div>
                                        <div class="err" style="display:none;" id="error_traveler_title">Please select a
                                            title
                                        </div>
                                    </div>
                                    <div class="pform-2 validated">
                                        <label>First Name</label>
                                        <input class="control-field valid" placeholder="Enter First Name" type="text"
                                               name="traveler_fname" value="<?php echo e(session()->get('userName')); ?>">
                                        <div class="err">Please enter first name</div>
                                    </div>
                                    <div class="pform-2 validated">
                                        <label>Last Name</label>
                                        <?php if(isset($userLastName)): ?>
                                            <input class="control-field valid" placeholder="Enter Last Name" type="text"
                                                   name="traveler_lname" value="<?php echo e($userLastName->last_name); ?>"
                                                   required="required">
                                        <?php elseif(session()->get('lastName') != null): ?>
                                            <input class="control-field valid" placeholder="Enter Last Name" type="text"
                                                   name="traveler_lname" value="<?php echo e(session()->get('lastName')); ?>" required="required">
                                            <?php else: ?>
                                            <input class="control-field valid" placeholder="Enter Last Name" type="text"
                                                   name="traveler_lname" value="" required="required">
                                        <?php endif; ?>
                                        <div class="err">Please enter last name</div>
                                    </div>

                                </div>
                            <?php endif; ?>
                            <div class="pform-row validated">
                                <label>Your Confirmation Email</label>
                                <input class="control-field valid" value="<?php if (session()->get('userLogin') == 1) {
                                    echo session()->get('userEmail');
                                } ?>" placeholder="So we can send you your email confirmation" type="email"
                                       name="traveler_email" required="required">
                                <div class="err">Please enter email</div>
                            </div>
                        </div>
                        <div class="payment-form promo">
                            <div class="title_promo">
                                <h4>Promo</h4>
                                <p><span>Have a Promo Code? <a href="javascript:void(0)" class="promo-code-link">Click here!</a></span><a
                                            href="javascript:void(0)" class="promo-code-link promo-code-link-after">Nevermind</a>
                                </p>
                            </div>
                            <div class="promo-field">
                                <input class="control-field valid" name="" placeholder="Plug in your promo here"
                                       type="text">
                            </div>
                        </div>
                        <div class="payment-form payment">
                            <div class="title_promo">
                                <h4>Payment</h4>
                                <ul class="card_list">
                                    <li><a href="#"><img src="<?php echo e(url('/assets/images/card_01.png')); ?>" alt="card_01"></a>
                                    </li>
                                    <li><a href="#"><img src="<?php echo e(url('/assets/images/card_02.png')); ?>" alt="card_02"></a>
                                    </li>
                                    <li><a href="#"><img src="<?php echo e(url('/assets/images/card_03.png')); ?>" alt="card_03"></a>
                                    </li>
                                    <li><a href="#"><img src="<?php echo e(url('/assets/images/card_04.png')); ?>" alt="card_04"></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card_info">
                                <h5>Card Information</h5>
                                <div class="pform-row validated">
                                    <label>Cardholder Name</label>
                                    <input class="control-field valid" type="text" name="booking_cardholder"
                                           required="required">
                                    <div class="err">Please enter cardholder name</div>
                                </div>
                                <div class="pform-row">
                                    <label>Debit/Credit card number</label>
                                    <div id="card-element">
                                        <!-- a Stripe Element will be inserted here. -->
                                    </div>
                                    <!-- Used to display Element errors -->
                                    <div id="card-errors"></div>
                                </div>
                                <div class="pform-row"></div>
                                <div class="clear"></div>
                                <div class="billing_address">
                                    <h5>Billing Address</h5>
                                    <div class="pform-row">
                                        <div class="pform-1 country validated">
                                            <label>Country</label>
                                            <div class="icon-control">
                                                <select class="control-field valid" name="booking_country"
                                                        required="required">
                                                    <option value="">Select</option>
                                                    <option value="US">US</option>
                                                </select>
                                                <span class="ion ion-arrow-down-b"></span>
                                            </div>
                                            <div class="err">Please select country</div>
                                        </div>
                                    </div>
                                    <div class="pform-row validated">
                                        <label>Street Address 1</label>
                                        <input class="control-field valid" type="text" name="booking_address1"
                                               required="required">
                                        <div class="err">Please enter address</div>
                                    </div>
                                    <div class="pform-row" validated>
                                        <label>Street Address 2</label>
                                        <input class="control-field valid" type="text" name="booking_address2">
                                        <div class="err">Please enter address</div>
                                    </div>
                                    <div class="pform-row">
                                        <div class="pform-1 validated">
                                            <label>City</label>
                                            <input class="control-field valid" type="text" name="booking_city"
                                                   required="required">
                                            <div class="err">Please enter city</div>
                                        </div>
                                        <div class="pform-1 state validated">
                                            <label>State</label>
                                            <div class="icon-control">
                                                <select class="control-field valid" name="booking_state"
                                                        required="required">
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
                                                <span class="ion ion-arrow-down-b"></span></div>
                                            <div class="err">Please enter state</div>
                                        </div>
                                        <div class="pform-2 validated">
                                            <label>Zip Code</label>
                                            <input class="control-field valid" type="text" name="booking_zipcode"
                                                   required="required">
                                            <div class="err">Please enter zip code</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        <!--   <div class="payment-form payment member">

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

                                        <input class="control-field" value="<?php if (isset($_SESSION["user_login"])) {
                            echo $_SESSION["user_login"];
                        } ?>" placeholder="Enter Email Address" type="text" name="member_email">

                                    </div>

                                    <div class="err error_member_email" id="error_member_email" style="display:none;">Please enter email</div>


                                    <div class="pform-row">

                                        <label>Phone</label>

                                        <input class="control-field" placeholder="Enter Phone Number" type="text" name="member_phone">

                                    </div>
                                    <div class="err error_member_phone" id="error_member_phone" style="display:none;">Please enter a phone</div>



                                </div>

                            </div> -->
                            <div class="payment-form terms_conditoin">
                                <h4>Accept Terms &amp; Conditions</h4>
                                <p>We understand that sometimes your travel plans change. we do not charge a change or
                                    cancel fee. However, this property (<?php echo e($hotel); ?>) impose the following penalty to its
                                    customers that we are to pass on: Cancellations or changes made after 1:00 AM
                                    ((GMT-0800) Pacific Time (US &amp; Canada); Tijuana) on Sep 2, 2016, or no-shows,
                                    are subject to a 1 Night Room &amp; Tax Penalty.</p>
                                <p>By selecting to complete this booking I acknowledge that I have read and accept the
                                    <a href="javascript:void(0)" class="property-policy-link">Property Policies</a>, <a
                                            href="javascript:void(0)" class="occupation-link">Occupancy Restrictions</a>,
                                    <a href="javascript:void(0)" class="room-type-link">Room Type Details</a>, <a
                                            href="javascript:void(0)" class="web-terms-link">Websites Terms of Use</a>
                                    and <a href="javascript:void(0)" class="tl-terms-link">Travel Linked Terms of
                                        Services</a>.</p>
                                <p>Full payment will by charged by TRAVEL LINKED when you book this hotel</p>
                                <div class="payment-signin reservation">
                                    <input type="hidden" name="nonce" id="nonce_token">
                                    <input type="hidden" name="apiRoomRate" id="apiRoomRate" value="<?php echo e($apiRoomRate); ?>">
                                    <input value="Confirm Your Reservation" id="submit" type="submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="paymentportal-sect-right">
                    <div class="venue-img"><img style="height:120px; width:300px;" src="<?php echo e($image); ?>"></div>
                    <div class="trip_summary">
                        <div class="venu-text">
                            <h2>Trip Summary</h2>
                        </div>
                        <div class="venu-text box">
                            <?php if($totalrooms > 1){ ?>
                            <h4><?php echo e($totalrooms); ?> Rooms</h4>
                            <?php }else{ ?>
                            <h4>Room</h4>
                            <?php

                            }

                            foreach($dispRooms as $key => $value){ ?>
                            <?php if($totalrooms > 1){ ?>
                            <h5>Room <?php echo e($key+1); ?></h5>
                            <?php }

                            if ($value['adultSearch'] == '') {
                                $value['adultSearch'] = 0;
                            }
                            if ($value['childrenSearch'] == '') {
                                $value['childrenSearch'] = 0;
                            }


                            ?>
                            <span><?php echo e($value['roomType']); ?> <?php echo e($value['bedType']); ?></span> <span><?php echo e($value['adultSearch']); ?>

                                Adults, <?php echo e($value['childrenSearch']); ?> Children</span>
                            <?php } ?>
                        </div>
                        <div class="venu-text box">
                            <?php if($nights > 1){ ?>
                            <h4><?php echo e($nights); ?> Nights</h4>
                            <?php }else{ ?>
                            <h4><?php echo e($nights); ?> Night</h4>
                            <?php } ?>
                            <div class="top_night_parent">
                                <div class="left_excl">
                                    <h5>Check In</h5>
                                </div>
                                <div class="right_excl"> <span>
                                <?php

                                        $yrdata = strtotime($checkin);

                                        echo date('D, M j Y', $yrdata);



                                        ?>
                                </span></div>
                            </div>
                            <div class="top_night_parent">
                                <div class="left_excl">
                                    <h5>Check Out</h5>
                                </div>
                                <div class="right_excl"> <span>
                                <?php

                                        $yrdata = strtotime($checkout);

                                        echo date('D, M j Y', $yrdata);



                                        ?>
                                </span></div>
                            </div>
                        </div>
                        <?php

                        $check = explode(",", $amendmentType);

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
                                <div class="right_excl"><span>$<?php echo e($totalRate); ?></span></div>
                            </div>
                            <div class="top_night_parent">
                                <div class="left_excl">
                                    <h5>With Tax</h5>
                                </div>
                                <div class="right_excl"><span>$<?php echo e($actualTax); ?></span></div>
                                <br/>
                            </div>
                            <div class="top_night_parent">
                                <?php if($hotel_fee > 0){ ?>
                                <div class="left_excl">
                                    <h5>Hotel Fees (due at hotel)</h5>
                                </div>
                                <div class="right_excl"><span>$<?php echo $hotel_fee; ?></span></div>
                                <?php } ?>
                            </div>
                            <div class="top_night_parent bold">
                                <div class="left_excl">
                                    <h5>Estimate Grand Total</h5>
                                </div>
                                <div class="right_excl"><span>$<?php echo e($grandTotal); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="total-amount">
                        <div class="top_night_parent">
                            <div class="left_excl">
                                <h5>Due Now</h5>
                            </div>
                            <div class="right_excl"><span>$<?php echo e($grandTotal - $hotel_fee); ?></span></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>