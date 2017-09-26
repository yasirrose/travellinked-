@extends('layouts.main')
@section('content')
    <div class="body-section payment-page">
        <div class="payment-pag">
            <div class="container"><strong style="color:#8DCBC9;">Your booking request is submited, after admin approval
                    notification will be send to you.</strong>
                <!-- <span>User Preferences</span>                <span>Your Reservations</span>                <span>100052</span>-->
                <div class="clear"></div>
            </div>
        </div>
        <div class="booking-cmplet-sect">
            <div class="container">
                <div class="bcmplt-head">
                    <h2>Booking Complete!</h2>

                    <?php if($travelDetail == ""){ ?>

                    <p>Confirmation emailed to
                         {{$userDetail->email}}

                    </p> <?php }else{ ?>

                    <p>Confirmation emailed to
                        to {{$travelDetail->traveler_email}}</p> <?php } ?>
                    <ul>
                        <li><a href="#"><i class="icon ion-ios-printer"></i>Print Confirmation</a></li>
                        <li><a href="#"><i class="fa fa-paper-plane"></i>Email Confirmation</a></li>
                        <li><a href="#"><i class="icon ion-ios-calendar-outline"></i>Add to Calendar</a></li>
                    </ul>
                </div>
                <div class="bcmplt-info">
                    <div class="bcmplt-info-left">
                        <div class="btn-aright">
                            <h4><?php echo $hotels['name'] ?></h4>
                            <p><?php echo $hotels['address'] . ", " . $hotels['city'] . ", " . $hotels['stateProvince'] . "<br>" . $hotels['country'] ?></p>
                            <span class="hotel-rating four-star">{{ $realStar[2]}}</span>
                        </div>
                        <div class="booking-code">
                            <span class="left-align">Booking Status</span>
                            <span class="right-align">{{$bookingDetail->booking_status}}</span>
                        </div>
                    </div>
                    <div class="bcmplt-img"><img src="<?php echo $hotels['image'] ?>"></div>
                    <div class="clear"></div>
                </div> <?php                $check = explode(",", $amendmentType);                 if($check[0] != "Cancel" || isset($check[1]) != "Modify"){ ?>
                <div class="bcmplt-row"><h3>Things To Keep In Mind</h3>
                    <ul>
                        <li>This Booking is a <span>Non Refundable</span></l>
                    </ul>
                </div> <?php } ?>
                <div class="bcmplt-row"><h3>Booking Details</h3>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="35%"><h5>Booking Date</h5>
                                <span><?php                                 $yrdata = strtotime($bookingDetail->booking_date);                                 echo date('D, M j Y', $yrdata);                                 ?></span>
                            </td>
                            <td width="24%"><h5>Check In</h5>
                                <span><?php                                $yrdata = strtotime($bookingDetail->booking_traveldate);                                echo date('D, M j Y', $yrdata);                                 ?></span>
                            </td>
                            <td width="26%"><h5>Check Out</h5>
                                <span><?php                                $yrdata = strtotime($bookingDetail->booking_traveldateEnd);                                echo date('D, M j Y', $yrdata);                                ?></span>
                            </td>
                            <td align="right" width="15%"><h5>Status</h5>
                                <span><?php echo $bookingDetail->booking_status ?></span></td>
                        </tr>
                    </table>
                </div>
                <div class="bcmplt-row"><h3>Room Details</h3>
                    <table cellpadding="0"
                           cellspacing="0">                <?php $count = 1; foreach($roomsDetail as $key => $room){ ?>
                        <tr>
                            <th width="35%">Room <?php echo $count; ?></th>
                        </tr>
                        <tr>
                            <td width="35%"><h5>Room Type</h5>
                                <span><?php echo $room["roomType"]; ?></span></td>
                            <td width="24%"><h5>Occupancy</h5>
                                <span><?php echo $room["stdAdults"]; ?> Adults, <?php echo $room["child"]; ?>
                                    Children</span></td>
                            <td width="26%"><h5>Traveler</h5> <?php if($travelDetail == "") {?>
                                <span><?php echo $userDetail->first_name; ?></span> <?php }else{ ?>
                                <span><?php echo $travelDetail->traveler_fname . " " . $travelDetail->traveler_lname ?></span> <?php } ?>
                            </td>
                            <td align="right" width="15%"><h5>Vendor Confirmation #</h5>
                                 @if($room_booking->status == 'canceled')
                                <span> {{$room_booking->status}}</span></td>
                                @else
                                <span>pending</span></td>
                                    @endif

                        </tr> <?php $count++; } ?>                    </table>
                </div>
                <div class="bcmplt-row"><h3>Billing</h3>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="35%"><h5>Travel Dates</h5>
                                <span><?php                                 $yrdata = strtotime($bookingDetail->booking_traveldate);                                 echo date('D, M j Y', $yrdata);                                 ?>
                                    - <?php                                 $yrdata = strtotime($bookingDetail->booking_traveldateEnd);                                 echo date('D, M j Y', $yrdata);                                 ?></span>
                            </td>
                            <td width="24%"><h5>No. of Nights</h5>
                                <span>{{$nights}}</span></td>
                            <td width="26%"><h5>No. of Rooms</h5>
                                <span><?php echo count($rooms); ?></span></td>
                            <td align="right" width="15%"><h5>Total</h5>
                                <span>$<?php echo $room_booking->amount; ?></span></td>
                        </tr>
                    </table>
                </div>
                <div class="bcmplt-row">
                    <div class="total-chagebox"><h5>Charges</h5>
                        <div class="charge-list"><span class="left-align">Subtotal</span> <span
                                    class="right-align">$<?php echo $room_booking->amount; ?></span></div>
                        <div class="charge-list"><span class="left-align">Taxes</span> <span
                                    class="right-align">$<?php                                $taxes = explode(",", $room_booking->taxes);                                $coutTax = "";                                foreach ($taxes as $tax) {
                                    $coutTax += $tax;
                                }                                echo $coutTax; ?></span>
                        </div> <?php if($room_booking->adminTaxes > 0){ ?>
                        <div class="charge-list"><span class="left-align">Tax by provider</span> <span
                                    class="right-align"><?php echo $room_booking->adminTaxes; ?></span></div> <?php } ?>
                        <div class="charge-list"><span class="left-align">Hotel Fees (due at hotel)</span> <span
                                    class="right-align">${{$bookingDetail->hotelFee}}</span>
                        </div> <?php                        /*===== add tax in any by the admin======*/                        $amount = $room_booking->amount;                        $rate = Helper::Rate();                        $actualTax = floatVal(str_replace(",", "", $rate[0]->global_value));                        $actualDis = floatVal(str_replace(",", "", $rate[0]->global_discount));                        $rateType = $rate[0]->global_type;                        if ($actualTax > 0) {
                            if ($rateType == 0) {
                                $taxAmount = floatVal(($amount * $actualTax) / 100);
                                $discountAmount = floatVal(($actualDis * $amount) / 100);
                                $amount = floatVal($amount + $taxAmount - $discountAmount);
                            } elseif ($rateType == 1) {
                                $amount = floatVal($amount + $actualTax - $actualDis);
                            }
                        }                     ?>
                        <div class="charge-list est-grand-total"><span class="left-align">Estimated Grand Total</span>
                            <span class="right-align">$<?php echo $amount + $coutTax + $bookingDetail->hotelFee; ?></span>
                        </div>
                        <div class="booking-code"><span class="left-align">Total Paid For</span> <span
                                    class="right-align">$<?php echo $amount + $coutTax + $bookingDetail->hotelFee; ?></span>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="bcmplt-row"><h3>Hotel Information</h3>
                    <div class="mb-10"><h6>Address</h6>
                        <p><?php echo $hotels['address'] . ", " . $hotels['city'] . ", " . $hotels['stateProvince'] . "<br>" . $hotels['country'] ?></p>
                    </div>
                    <div class="mb-10"><h6>Contact Informatiom</h6>
                        <p>Tel. <?php echo $hotelPolicy->hotel->phone?><br>Fax <?php echo $hotelPolicy->hotel->fax; ?>
                        </p></div>
                    <div class="mb-10"><h6>Hotel Description</h6>
                        <p><?php echo $hotels['shortDescription'] ?></p></div>
                    <div class="mb-10"><h6>Facilities</h6> <?php echo $hotelPolicy->hotel->facilities; ?>
                    </div>
                </div> <?php if($bookingDetail->hotelFee > 0){ ?>
                <div class="bcmplt-row"><h3>Fee's</h3>                    <h6>Mandatory Resort Fee</h6>
                    <p>Guests who book the Exclusive room categories will be responsible to pay the Resort Fee of
                        $<?php echo $bookingDetail->hotelFee; ?> per night.</p></div> <?php } ?>
                <div class="bcmplt-row"><h3>Cancellation Policy</h3>
                    <div class="mb-10"><p><?php //echo $hotelPolicy->hotel->description; ?></p></div>
                    <div class="mb-10">
                        <p>                    <?php                        echo $hotelPolicy->hotel->cancelPolicies;                    ?>                    </p>
                    </div>
                </div>
                <div class="bcmplt-row"><h3>Restrictions/Policies</h3>
                    <!--<div class="mb-10">                        <h6>Child Policy:</h6>                        <ul>                        	<li>No specific child policy</li>                        </ul>                    </div>-->
                    <div class="mb-10"><h6>General Limitations &
                            Policies:</h6> <?php                        if(empty($hotelPolicy->hotel->limitationPolicies)){                        echo "<p>No specific limitation policies for this hotel</p>";                        }else{                         echo $hotelPolicy->hotel->limitationPolicies;                        }?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>@endsection