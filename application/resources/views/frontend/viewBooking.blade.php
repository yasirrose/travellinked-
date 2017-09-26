<?php
 $can = false;
    $time = strtotime($record->chekIn);
    $diff = $time - time();

    if($diff < 345600){
        $can = true;
    }
?>

@extends('layouts.main')

@section('content')

<div class="body-section payment-page">

    	<div class="payment-pag">

        	<div class="container">
				<ul>
					<li>User Preferences</li>
					<li>Your Reservations</li>
					<li>{{$record->booking_id}}</li>
				</ul>
               <!-- <span>User Preferences</span>

                <span>Your Reservations</span>

                <span>100052</span>-->

            	<div class="clear"></div>

            </div>

        </div>

        <div class="booking-cmplet-sect">

            <div class="container">

            	<div class="bcmplt-head">

                    <?php if($record->is_pending==1){
                      echo "<h2>Booking Pending</h2>";
                      echo "<p>Confirmation emailed to joshmimoun@me.com</p>";
                    }
                    elseif ($record->is_pending==0) {
                      echo "<h2>Booking Confirmed</h2>";
                      echo "<p>Confirmation emailed to joshmimoun@me.com</p>";
                    }

                    ?>


                    {{--<ul>--}}
                     {{--<li>--}}
                        {{--<a href="#" onclick="printFunction()"><i class="icon ion-ios-printer"></i>Print Confirmation</a>--}}
                     {{--</li>--}}
                     {{--<li>--}}
                        {{--<a href="{{url('user/getPDF').'/'.$record->booking_id}}" onclick="mailpage()"><i class="fa fa-paper-plane"></i>Email Confirmation</a>--}}
                     {{--</li>--}}
                     {{--<li>--}}
                        {{--<a href="#" id="calendar"><i class="icon ion-ios-calendar-outline"></i>Add to Calendar</a>--}}
                     {{--</li>--}}
                  {{--</ul>--}}
  </div>

                <div class="bcmplt-info">

                	<div class="bcmplt-info-left">

                    	<div class="btn-aright">

                            <h4>{{$record->hotel_name}}</h4>
                            <p>{{$record->hotel_address}}</p>
                            <p>United States</p>

                            <?php
                                $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$rating);
                                if($arr[0] == 1 || $arr[0] == 1.5 ){
                                    $rating = 1;
                                    echo '<span class="hotel-rating one-star">'.$rating.'&nbsp;'.' Hotel</span>';
                                } else if($arr[0] == 2 || $arr[0] == 2.5){
                                    $rating = 2;
                                    echo '<span class="hotel-rating two-star">'.$rating.'&nbsp;'.' Hotel</span>';
                                } else if($arr[0] == 3 || $arr[0] == 3.5){
                                    $rating =3;
                                    echo '<span class="hotel-rating three-star">'.$rating.'&nbsp;'.' Hotel</span>';
                                } else if($arr[0] == 4 || $arr[0] == 4.5){
                                    $rating =4;
                                    echo '<span class="hotel-rating four-star">'.$rating.'&nbsp;'.' Hotel</span>';
                                } else if($arr[0] == 5 || $arr[0] == 5.5){
                                    $rating = 5;
                                    echo '<span class="hotel-rating five-star">'.$rating.'&nbsp;'.' Hotel</span>';
                                }
                            ?>
                        </div>

                        <div class="booking-code">
                        	<span class="left-align">Booking Status</span>

                            <span class="right-align"><?php if($record->is_pending==1){
                              echo "Booking Pending"." "."(".$record->booking_id.")";
                            }
                            elseif ($record->is_pending==0) {
                              echo "Booking Confirmed";
                            }
                            ?></span>

                        </div>

                    </div>

                    <div class="bcmplt-img">

                         <img src="<?php echo $image ?>">

                    </div>

                    <div class="clear"></div>

                </div>
           <?php
             if($record->hote_fee > 0 || $can){?>

              <div class="bcmplt-row">

                	<h3>Things To Keep In Mind</h3>

                    <ul>
                 <li>Mandatory Resort Fee is $<?php echo $record->hote_fee; ?> Per Day Per Room for this Booking</li>
                 <li>This Booking is a <span>Non Refundable</span></l>
           </ul>

                </div>
            <?php }
           else {

           }
                ?>
                 <div class="bcmplt-row">

                	<h3>Booking Details</h3>

                    <table cellpadding="0" cellspacing="0">



                        <tr>

                        	<td width="35%">

                            	<h5>Booking Date</h5>


                              <span>{{$record->bookingDate}}</span>
                            </td>

                            <td width="24%">

                            	<h5>Check In</h5>

                              <span>{{$record->chekIn}}</span>

                            </td>

                            <td width="26%">

                            	<h5>Check Out</h5>

                                <span>{{$record->checkOut}}</span>

                            </td>

                            <td align="right" width="15%">

                            	<h5>Status</h5>


                              <span><?php if($record->is_pending==1){
                                echo "Booking Pending";
                              }
                              elseif ($record->is_pending==0) {
                                echo "Booking Confirmed";
                              }
                              ?></span>
                            </td>

                        </tr>

                    </table>

                </div>

                <div class="bcmplt-row">

                	<h3>Room Details</h3>

                    <table cellpadding="0" cellspacing="0">

                      <tr>
                        <td  width="35%">
                         <h5>Room Type</h5>
                       </td>
                       <td  width="24%">
                           <h5>Occupancy</h5>
                      </td>
                      <td width="26%">
                        <h5>Traveler</h5>
                      </td>
                          <td align="right" width="15%">
                              <h5>Vendor Confirmation#</h5>
                          </td>
                      </tr>
                  <tbody>
                    <tr>
                     <?php
                         $rm_types = explode(',', $record->room_types);
                         $adult    =  explode(',',$record->adults);
                         $child = explode(',', $record->children);
                          for($i=0; $i<count($rm_types)-1;$i++){ ?>
                            <td width="35%"><span><?php echo $rm_types[$i]?></span></td>
                           <td width="24%"><span><?php echo $adult[$i] ?> Adults, <?php echo $child[$i]  ?> Children</span>
                         <td width="26%"><span>{{ session()->get('userName') }} </span>  </td>
                         <td width="15%" align="right">
                           <?php if($record->is_pending==1){
                             echo "Pending(#####)";
                           }
                           elseif ($record->is_pending==0) {
                             echo "Confirmed(####)";
                           }
                           ?></td>
                        </tr>
                      <?php
                    }
                 ?>
               </tbody>
             </table>

                </div>

                <div class="bcmplt-row">

                	<h3>Billing</h3>

                    <table cellpadding="0" cellspacing="0">

                    	<tr>

                        	<td width="35%">

                            	<h5>Travel Dates</h5>

                                <span>{{Carbon\Carbon::parse($record->chekIn)->format('F jS,  Y')}} - {{Carbon\Carbon::parse($record->checkOut)->format('F jS,  Y')}} </span>

                            </td>

                            <td width="24%">

                            	<h5>No. of Nights</h5>

                                <span>{{$record->no_nights}}</span>

                            </td>

                            <td width="26%">

                            	<h5>No. of Rooms</h5>

                                <span>{{$record->no_rooms}}</span>

                            </td>

                            <td align="right" width="15%">

                            	<h5>Total</h5>


                              <span>${{$record->total_amount}}</span>
                            </td>

                        </tr>

                    </table>

                </div>

                <div class="bcmplt-row">

                	<div class="total-chagebox">

                    	<h5>Charges</h5>

                        <div class="charge-list">

                        	<span class="left-align">Subtotal</span>


                          <span class="right-align">${{$record->total_amount}}</span>
                        </div>

                        <div class="charge-list">

                        	<span class="left-align">Taxes</span>

                            <span class="right-align">${{$record->tax}}</span>

                        </div>
                          <?php if($record->hote_fee > 0){ ?>
                        <div class="charge-list">

                        	<span class="left-align">Hotel Fees (due at hotel)</span>

                            <span class="right-align">${{$record->hote_fee * $record->no_nights }}</span>

                        </div>

                       <div class="charge-list est-grand-total">

                        	<span class="left-align">Estimated Grand Total</span>

                            <span class="right-align">${{ $record->hote_fee * $record->no_nights + $record->tax  + $record->total_amount}}</span>

                        </div>
             <?php }  else { ?>
               <div class="charge-list est-grand-total">

                  <span class="left-align">Estimated Grand Total</span>

                    <span class="right-align">${{ $record->tax  + $record->total_amount}}</span>

                </div>

            <?php   }  ?>
                        <div class="booking-code">

                        	<span class="left-align">Total Paid For</span>

                            <span class="right-align">${{ $record->total_amount +  $record->tax}}</span>

                        </div>

                    </div>

                	<div class="clear"></div>

                </div>

                <div class="bcmplt-row">

                    <h3>Hotel Information</h3>

                    <div class="mb-10">

                        <h6>Address</h6>

                        <p>{{ $address }}</p>
                        <p>United States</p>

                    </div>

                    <div class="mb-10">

                        <h6>Contact Informatiom</h6>

                        <p>Tel. <?php echo  $phone; ?><br>Fax <?php echo $fax; ?></p>

                    </div>

                    <div class="mb-10">

                    	<h6>Hotel Description</h6>

                    	<p><?php echo $description ?></p>

                    </div>

                    <div class="mb-10">

                        <h6>Facilities</h6>

						<?php echo $facilities; ?>

                    </div>

                </div>

                <div class="bcmplt-row">

                    <h3>Fee's</h3>

                    <h6>Mandatory Resort Fee</h6>



                    <p>Guests who book the Exclusive room categories will be responsible to pay the Resort Fee of $200 per night.</p>



                </div>


                <div class="bcmplt-row">

                    <h3>Cancellation Policy</h3>

                    <div class="mb-10">

                        <p><?php $cancel = str_replace("Bonotel","TRAVEL LINKED",$policy);
                        echo $cancel ?></p>

                    </div>

                    <div class="mb-10">

                    </div>

                </div>

                <div class="bcmplt-row">

                    <h3>Restrictions/Policies</h3>

                    <!--<div class="mb-10">

                        <h6>Child Policy:</h6>

                        <ul>

                        	<li>No specific child policy</li>

                        </ul>

                    </div>-->

                    <div class="mb-10">

                        <h6>General Limitations &  Policies:</h6>

                        <?php

            // $cancel = str_replace("<ul>","",$limitation_policy);
            //
            // $cancel = str_replace("</ul>","",$cancel);
            //               $cancel = str_replace("Bonotel","TravelLinked",$cancel);


            echo $limitation_policy;

            ?>

                    </div>

                </div>



                <div class="clear"></div>

            </div>

        </div>

	</div>

@endsection
@section('script')
    <script>
        function printFunction() {
            window.print();
        }
        {{--function emailCurrentPage(){--}}
            {{--window.location.href="mailto:techleadz.cfm@gmail.com?subject=Booking Details"+document.title+"&body="+encodeURI(document.location);--}}
        {{--}--}}
        function mailpage()
        {
            mail_str = "mailto:techleadz.cfm@gmail.com?subject=Booking Details" + document.title;
            mail_str += "&body=I thought you might be interested in the " + document.title;
            mail_str += ". You can view it at, " + location.href;
            location.href = mail_str;
        }

    </script>
@endsection
