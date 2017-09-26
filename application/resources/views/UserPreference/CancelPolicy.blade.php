@extends('layouts.main')
@section('content')
<div class="body-section">

   <div class="container">
         <div class="policy-wraper">
           <h2>Cancellation Policy</h2>
               <h3>Please review policy as there may be fees that apply.</h3>
               <p>We understand that sometimes plans fall through. We do not charge a cancel or change fee. When the hotel charges such fees in accordance with its own policies, the cost will be passed on to you. Mirage Resort &amp; Casino charges the following cancellation and change fees. Cancellations or changes made after 12:00 PM (Pacific Daylight Time (US &amp; Canada); Tijuana) on December 10, 2011 are subject to a hotel fee equal to the first night's rate plus taxes and fees.</p>
               <ul>
                 <?php

     $cancel = str_replace("<ul>","",$hotelPolicy->hotel->cancelPolicies);

     $cancel = str_replace("</ul>","",$cancel);
                   $cancel = str_replace("Bonotel","TRAVEL LINKED",$cancel);


     echo $cancel;

     ?>

              </ul>
           </div>
           <div class="bcmplt-row">
               <h3>Booking Details</h3>
               <table cellspacing="0" cellpadding="0">
                   <tbody>
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
                               <h5>Booking #</h5>
                               <span>{{$record->booking_id}}</span>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </div>
           <div class="bcmplt-row">
               <h3>Room Details</h3>
               <table cellspacing="0" cellpadding="0">
                   <tbody>
                       <tr>
                         <td width="35%">
                          <h5>Hotel Name</h5>
                        </td>
                        <td width="24%">
                            <h5>Room Type</h5>
                       </td>
                       <td width="26%">
                           <h5>Occupancy</h5>
                           </td>
                           <td align="right" width="15%">
                               <h5>Traveler</h5>

                           </td>
                       </tr>
                       <tr>
                         <?php

                       $rm_types = explode(',', $record->room_types);
                       $adult    =  explode(',',$record->adults);
                      $child = explode(',', $record->children);
                        for($i=0; $i<count($rm_types)-1;$i++){?>

                              <td width="35%"> <span>{{ $record->hotel_name }}</span></td>
                              <td width="24%"><span><?php echo $rm_types[$i]?></span></td>
                               <td width="26%" > <span><?php echo $adult[$i] ?> Adults, <?php echo $child[$i]  ?> Children   </span></td>
                              <td align="right" width="15%">{{ session()->get('userName') }}</td>
                            </tr>
                         <?php
                       }
                    ?>

                   </tbody>

               </table>
           </div>
           <div class="bcmplt-row no-border">
               <div class="total-chagebox">
                   <h5>Charges</h5>
                   <div class="charge-list padding-btm-none">
                       <span class="left-align">Total Paid</span>
                       <span class="right-align">${{$record->total_amount}}</span>
                   </div>
                   <div class="charge-list est-grand-total">
                       <span class="left-align">Cancelations Fees</span>
                       <span class="right-align red-text">${{$record->deduction_ammount}}</span>
                   </div>
                   <div class="booking-code">
                       <span class="left-align">Total Refund Due</span>
                       <span class="right-align">${{ $record->total_amount - $record->deduction_ammount }}</span>
                   </div>
               </div>
             <div class="clear"></div>
           </div>
           <div class="reservation-below-section">
             <h4>Please intial below</h4>
               <p>I understand the clicking Cancel below will cancel my hotel reservation for all rooms and will be responsibile for any cancelation fees that apply. </p>
               <input class="insert-initials-btn" type="button" value="Insert Initials">
           </div>
           <div class="reservation-btns">
             <input class="keep-reseveration-btn" type="button" value="Keep Reseveration">

             <input class="cancel-reseveration-btn web-terms-link" type="button" value="Cancel Reservation">
               <div class="clear"></div>
           </div>
       </div>
 </div>
@endsection
