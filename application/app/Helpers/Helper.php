<?php

namespace App\Helpers;

use App\Api;
use Carbon\Carbon;
use App\Rate;
use App\Hotel;
use DB;


class Helper

{

    public static function api()

    {

        $api_detail = Api::where('is_active', '=', '1')->first();

        return $api_detail;

    }
    public static function getFilterDealsRecord($alldeals){

        $counter = 1;
        $html = '';
        if(count($alldeals)>0) {
            foreach ($alldeals as $dealItem) {


                $html .= '<tr>';
                $html .= '<td><i class="fa fa-check"></i></td>';
                $html .= '<td>' . $counter . '</td>';
                $html .= '<td> ' . $dealItem['hotelName'] . '</td>';
                $html .= '<td>' . $dealItem['location'] . '</td>';
                $html .= '<td> ' . \Carbon\Carbon::parse($dealItem['created_at'])->format('F jS,  Y') . ' </td>';
                $html .= '<td>' . $dealItem['dealName'] . '</td>';
                $html .= '<td>';

                if ($dealItem['deal_status'] == 1) {
                    $html .= '<span class="text-success">Active</span>';
                } else {
                    $html .= '<span class="text-danger">Inactive</span>';
                }
                $html .= '</td>';
                $html .= '<td>';

                $html .= '<div class="checkbox c-checkbox">';
                $html .= '<label>';
                if ($dealItem["deal_status"] == 1) {
                    $html .= '<input data-required="true" id="all'.$counter.'" name="dealId"  onclick="DealForm('.$dealItem['id'].');" type="checkbox" checked="checked">';
                    $html .= '<span class="fa fa-check"></span>';
                }
                else {
                    $html .= '<input data-required="true" id="all' . $counter . '"   onclick="DealForm('.$dealItem['id'].');" name="dealId" type="checkbox"><span class="fa fa-check"></span>';
                }
                $html .= '</label></div></td></tr>';

                $counter++;

            }
            return $html;
        }


    }
    public static function GetT20Deals($deals){

        $html = '';
        $chunk = 0;

        foreach($deals as $deal){
            $nameSlug = str_replace(' ','-',$deal->name);
            $stateSlug = str_replace(' ', '-', $deal->state);
            $citySlug = str_replace(' ', '-', $deal->city);
            $rating = "";
            $class = "";
            if (is_array($deal->starRating)) {
                $arr[0] = 0;
                $rating = "";
            } else {
                $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $deal->starRating);
            }
            if ($arr[0] == 1 || $arr[0] == 1.5) {
                $class = "one-star";
                $rating = "1 Star Hotel";
            } elseif ($arr[0] == 2 || $arr[0] == 2.5) {
                $class = "two-star";
                $rating = "2 Star Hotel";

            } elseif ($arr[0] == 3 || $arr[0] == 3.5) {
                $class = "three-star";
                $rating = "3 Star Hotel";
            } elseif ($arr[0] == 4 || $arr[0] == 4.5) {
                $class = "four-star";
                $rating = "4 Star Hotel";
            } elseif ($arr[0] == 5 || $arr[0] == 5.5) {
                $class = "five-star";
                $rating = "5 Star Hotel";
            }

            if ($chunk == 0) {
                $html .= '<div class="top-picks-row">';
            }
            $html .= '<div class="one-third">';
            $html .= '<a href="' . url("viewHotel") . "/" . $citySlug . '/' . $deal->hotelCode . '">';
            $html .= '<img style="width:380px; height:280px;" src="' . $deal->images->image[0] . '" >';
            $html .= '<div class="top-pick-content">';
            $html.='<div class="top-pick-position">';
            $html .= '<span class="hotel-rating ' . $class . '">' . $rating . '</span>';
            $html .= '<h3>' . $deal->name . '</h3>';
            $html .= '<p>' . $deal->city .  '</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html.='</a>';
            $html.='</div>';
            $chunk++;
            if ($chunk == 3) {
                $html .= '</div>';
                $chunk = 0;
            }
        }
        if($chunk < 3){

            $html.='</div>';
        }

        return $html;

    }

    Public static function getTaxFromBackend($newrates){

        $rate = self::Rate();
        if($rate[0]->tax_status == 0){
            $newrates=  (($newrates/100)*$rate[0]->tax);
        }
        if($rate[0]->tax_status == 1){
            $newrates= $newrates + $rate[0]->tax;
        }
        return $newrates;
    }

    public static function getCalculatedPrice($newrates)
    {
        $rate = self::Rate();
        $margin= $rate[0]->margin;
        if($rate[0]->margin_status == 0){
            $margin = $rate[0]->margin/100;
            if($margin >= 1){
                $margin=0.99;
            }
            $newrates = $newrates/(1-$margin);

        }
        if($rate[0]->markup_status == 0){
            $newrates = $newrates + (($newrates/100)*$rate[0]->markup);
        }
        if($rate[0]->markup_status == 1){
            $newrates = $newrates + $rate[0]->markup;
        }

//========================DISCOUNT CALCULATION
        if($rate[0]->discount_status == 0){
            $newrates= $newrates + (($newrates/100)*$rate[0]->discount);
        }
        if($rate[0]->discount_status == 1){
            $newrates= $newrates + $rate[0]->discount;
        }

        return $newrates;
    }
    public static function getFilterDestinations($alldests){

        $counter = 1;
        $html = '';
        if(count($alldests)>0){
            foreach($alldests as $destItem){
                $html.='<tr><td><i class="fa fa-check"></i> </td>
			  <td align="center">'.$counter.'</td><td class="link-color">'. $destItem->hotelgroupcode . '</td>';
                $html.='<td>'. $destItem->hotelgroupname.'</td>';
                $html.='<td>';
                if(!empty($destItem->hotelgroupimage)){
                    $html.='<img width="80" src="'.url('/').'/'.$destItem->hotelgroupimage.'">';
                }

                $html.='<form method="post" action="'.url("admin/update-destination-status").'"  class="all'.$counter.'">
				<input type="hidden" name="_token" value=" '.csrf_token().'" />';
                $html.='<input type="file" name="destImage" class="all'.$counter.'>
				<input type="hidden" name="record_id" value="'.$destItem->groupId.'">';
                $html.='</form></td>';
                $html.='<td> <span class="book-confirm">';
                if ($destItem->status == 1) {
                    $html.='active';
                }
                else{
                    $html.='inactive';
                }
                $html.='</span></td>';
                $html.='<td><div data-toggle="tooltip" onclick="checkBoxVal('.$counter.')" class="checkbox c-checkbox">
				<label>';
                if($destItem->status == 1){
                    $html.= '<input id="all'.$counter.' name="destId" type="checkbox" checked="checked"><span class="fa fa-check"></span>';
                }
                else{
                    $html.='<input id="all'.$counter.'" name="destId" type="checkbox">  <span
                                                class="fa fa-check"></span>';
                }
                $html.='</label></div></td></tr>';
                $counter++;
            }

            if($counter == 1){

                $html.='<tr><td style="display:none;" colspan="1"></td>
                                    <td style="display:none;" colspan="1"></td>
                                    <td style="display:none;" colspan="1"></td>
                                    <td style="display:none;" colspan="1"></td>
                                    <td style="display:none;" colspan="1"></td>
                                    <td align="center" colspan="5">No destinations found</td></tr>';


            }
            return $html;


        }



    }



    public static function getFilterBookingsRecord($allBooking)
    {
        $html ='';
        if($allBooking>0) {
            foreach ($allBooking as $booking){
                $html .= '<tr><td>
                          <i   class="fa fa-check"></i>
                         
                         </td>';
                $html.='<td class="link-color"> # <a href="'.url("admin/booking/detail/".$booking->request_id).'"> '.  $booking->booking_id .'  </a> </td>';
                $html.='<td> '.\Carbon\Carbon::parse($booking -> booking_date)->format('F jS,  Y').' </td>';
                $html.='<td>'.session()->get('userName').'</td>';
                $html.='<td>'.$booking->booking_status.'</td>';
                if($booking->booking_status =='Confirmed'){
                    $html.='<td>
                                <div class="approve-decline btn-group"><span class="apprDec" data-toggle="dropdown" style="cursor:pointer;">Confirmed </span>
                                  <ul role="menu" class="dropdown-menu animated fadeInLeft">
                                                <li>
                                  <a href="'.url("admin/cancel/".$booking->request_id).'" onclick="return confirm(\'Do you want to cancel?\')">
                                    Cancel booking</a>
                                     </li>
                                     <li> <a href="#">Email Client</a> </li>
                                     </ul>
                                     </div>
                           </td>';
                }
                elseif($booking->booking_status == 'Canceled'){
                    $html.='<td> <div class="approve-decline btn-group"><span class="apprDec" data-toggle="dropdown" style="cursor:pointer;"> Canceled</span>
                                <ul role="menu" class="dropdown-menu animated fadeInLeft">
                                                <li> <a href="'.url("admin/decline/".$booking->request_id).'" onclick="return confirm(\'Are you want to refund?\')">
                                    Refund </a>
                                                </li>
                                                <li> <a href="#">Email Client</a> </li>

                                            </ul>
                                        </div></td>';
                }
                elseif ($booking->is_deleted == 1){
                    $html.='<td><p class="book-canceled">Declined</p></td>';
                }
                else{
                    $html.='<td>
                                    <div class="approve-decline btn-group"> <span class="apprDec" data-toggle="dropdown" style="cursor:pointer;">Approve / Decline<b class="caret"></b></span>
                                       <ul role="menu" class="dropdown-menu animated fadeInLeft"><li> <a href="'.url("admin/approve/".$booking->request_id).'">Approve Booking </a> </li>
                                       <li><a href="'.url("admin/decline/".$booking->request_id).'" onclick="confirm(\'Do you want to decline?\')">Decline Booking</a></li>
                                       <li><a href="#">Email Client</a> </li>
                                       </ul>
                                       </div>
                                       </td>';

                }
                $html.='<td>'. $booking->total_amount .'</td>
                <td></td></tr>';



            }
            return $html;
        }
    }

    public static function GetHtmlFromCustomers($customers){
        $html = '';
        foreach($customers as $customer){
            $html .= "<tr><td class='link-color'><a >".$customer['userName']."</a></td>";
            $html .= '<td>'.$customer['location'].'</td>';
            $html .= '<td align="center">'.$customer['totalBooking'].'</td>';
            $html .= "<td align=\"center\"><p class=\"link-color\">".$customer['lastBooking']."</p></td>";
            $html .= "<td>".$customer['totalBookingPrice']."</td>";
            $html .= "<td>".'  <div class="squaredThree">
              <input data-required="true" id="squared2" value="" name="sameAsAbove" type="checkbox">
          </div>'
                ."</td></tr>";

        }

        return $html;
    }
    public static function GetHtmlForReservation($reservations){
        $counter = 1;
        $html = '';
        if(count($reservations)!=0){
            foreach($reservations as $reservation){
                $html.= '<div class="reservation-box"><div class="reservation-box-title">';
                if($reservation->booking_status == 'Pending'){
                    $html.='<h2 class="blue-text">Booking '.$reservation->booking_status.'</h2>';
                }
                if($reservation->booking_status == 'Canceled'){
                    $html.='<h2 class="red-text">'.$reservation->booking_status.'</h2>';
                }
                if($reservation->booking_status == 'Confirmed'){
                    $html.='<h2 class="green-text">'.$reservation->booking_status.'</h2>';
                }
                $html.= '<div class="reservation-box-dropdown">
          <div  id="moreOptions'.$counter.'" onclick="moreOptionsClicked(event)" class="moreOptionsClick reservation-box-dots">
             <span id="moreOptions'.$counter.'"></span>
             <span id="moreOptions'.$counter.'"></span>
             <span id="moreOptions'.$counter.'"></span>
              </div><ul id="options'.$counter.'"><li class="booking"><a href="'.url("user/reservations/".$reservation->booking_id."/viewBooking").'">View Booking</a></li>
              <li><a href="">Add Note</a></li>
              <li><a href="'.url("user/reservations/".$reservation->booking_id."/cancel").'">CancelBooking</a></li></ul></div></div>';
                $counter++;
                $html.='<div class="reservation-description">
                <div class="reservation-description-left">
                  <div class="booking-date">
                    <h4>Booking Date</h4><h5>'.\Carbon\Carbon::parse($reservation -> booking_date)->format('F jS,  Y') .'</h5>
                  </div>
                  <div class="booking-url">
                    <a href="">Reservation Details</a>
                    <a href="">Hotel Policies</a>
                    <a href="">Book Again</a>
                   </div>
                   <div class="booking-linked">
                     <p>Travel Linked #</p>
                     <h6>'.$reservation->booking_id . '</h6>
                   </div>
                   </div>';
                $html.='<div class="reservation-description-right">
                        <h2>'.$reservation->name.'</h2>
                        <p>'.$reservation->address.'</p>
                        <div class="reservation-checkin">
                          <div class="reservation-checkin-left">
                          <p>'.(count(explode(',' , $reservation->roomeCode)) - 1).' Room </p>';
                $html.='<div class="checkin-text">
                    <p><span>Check In:</span> '. \Carbon\Carbon::parse($reservation -> booking_traveldate)->format('D, M jS  Y') .'</p>
                    <p><span>Check Out:</span> '.\Carbon\Carbon::parse($reservation ->booking_traveldateEnd)->format('D, M jS  Y') .'</p>
                  </div>';
                $html.='<p>Traveler Name: '.session()->get('userName').'</p>
                 <div class="checkin-total">
                   <p><span>Total Paid:</span> $'. $reservation->total_amount .'</p>
                 </div>
                 </div>';
                $html.='<div class="reservation-img">
                   <img src="'.$reservation->image.'" alt="">
                 </div>
                 </div>
               </div>
              </div>
           </div>';

            }
            return $html;
        }
        else{
            $html.=  '<div class="no-reservation-box">
    <h2>No Reservation Found </h2>
    <p>Try Something else from Your Menu !</p>
          </div>';
            return $html;
        }
    }
    public static function removeElementsFromHotelArray($Harr){
        foreach($Harr as $key => $hotel){
            if(isset($hotel['roomInformation'][0])){
                foreach($hotel['roomInformation'] as $secondKey => $room){

                    if($room["confirmationType"] == "REQ"){
                        unset($Harr[$key]['roomInformation'][$secondKey]);
                    }
                }
                $Harr[$key]['roomInformation'] = array_values($Harr[$key]['roomInformation']);
                if(empty($Harr[$key]['roomInformation'])){

                    unset($Harr[$key]);
                    //$Harr = array_values($Harr);
                }
            }
            else{
                if($hotel['roomInformation']["confirmationType"] == "REQ"){
                    unset($Harr[$key]);
                }
            }
        }
        $Harr = array_values($Harr);
        // dd($Harr[5]);
        return $Harr;
    }
    public static function getTravelerName($id){

        $row = DB::table('traveler_info')->where('request_id', '=', $id)->first();
        if($row==null){
            return 'Unknown Traveler';
        }
        return $row->traveler_fname.' '.$row->traveler_lname;
    }
    public static function getNewHotelToDatabase($id, $ApiUser){
        $url = "http://api.bonotel.com/index.cfm/user/".$ApiUser."/action/hotel/hotelCode/".$id;
        $result1 = @file_get_contents($url);
        if(empty($result1)){
            return redirect()->to("500");
        }
        $hotel = simplexml_load_string($result1);
        $hotel = $hotel->hotel;
        $obj = new Hotel;
        $obj->hotelCode = $hotel->hotelCode.'';
        $obj->name = $hotel->name.'';
        $obj->address = $hotel->address.'';
        $obj->city = $hotel->city.'';
        $obj->cityCode = $hotel->cityCode.'';
        $obj->stateCode = $hotel->stateCode.'';
        $obj->country = $hotel->country.'';
        $obj->state = $hotel->state.'';
        $obj->postalCode = $hotel->postalCode.'';
        $obj->phone = $hotel->phone.'';
        $obj->latitude = $hotel->latitude.'';
        $obj->longitude = $hotel->longitude.'';
        $obj->image = $hotel->images->image[0].'';
        $obj->time = Date('Y-m-d');
        $obj->save();

        return $hotel->cityCode;

    }
    public static function starCheckerWithoutCounter($starRating){

        $hotelRating = "0";
        $class = "";
        $rating = "";
        if(is_array($starRating)){
            $arr[0] = 0;
            $rating = "";
        }
        else{
            $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$starRating);
            //$rating = $starRating." Hotel";
        }
        if($arr[0] == 1 || $arr[0] == 1.5){
            $class = "one-star";
            $hotelRating = "1star";
            $rating = "1 Star Hotel";
        }
        if($arr[0] == 2 || $arr[0] == 2.5){
            $class = "two-star";
            $hotelRating = "2star";
            $rating = "2 Star Hotel";
        }
        if($arr[0] == 3 || $arr[0] == 3.5){
            $class = "three-star";
            $hotelRating = "3star";
            $rating = "3 Star Hotel";
        }
        if($arr[0] == 4 || $arr[0] == 4.5){
            $class = "four-star";
            $hotelRating = "4star";
            $rating = "4 Star Hotel";
        }
        if($arr[0] == 5 || $arr[0] == 5.5){
            $class = "five-star";
            $hotelRating = "5star";
            $rating = "5 Star Hotel";
        }
        return array($class, $hotelRating, $rating);
    }
    public static function starChecker($starRating, $array){
        if(is_array($starRating)){
            $arr[0] = 0;
            $rating = "";
        } else {
            $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$starRating);
            $rating = $starRating." Hotel";
        }
        if($arr[0] == 1 || $arr[0] == 1.5){
            $class = "one-star";
            $array['star1'] = $array['star1']+1;
        } elseif($arr[0] == 2 || $arr[0] == 2.5){
            $class = "two-star";
            $array['star2'] = $array['star2']+1;
        } elseif($arr[0] == 3 || $arr[0] == 3.5){
            $class = "three-star";
            $array['star3'] = $array['star3']+1;
        } elseif($arr[0] == 4 || $arr[0] == 4.5){
            $class = "four-star";
            $array['star4'] = $array['star4']+1;
        } elseif($arr[0] == 5 || $arr[0] == 5.5){
            $class = "five-star";
            $array['star5'] = $array['star5']+1;
        }
        return array($rating, $class, $array);
    }

    public static function getOptimalRate($rooms){

        $rates = array(0, 0, 0, 0, 0);
        foreach($rooms as $room){
            if($rates[$room["roomNo"]-1] == 0){
                $rates[$room["roomNo"]-1] = $room["rateInformation"]["totalRate"];
            }

        }
        $sum = 0;

        foreach($rates as $rate){
            $rate = str_replace(',','',$rate);
            $sum = $sum + $rate;
           }

        return $sum;
    }


    public static function getHdImages($hotelCode, $user){
        $url = "http://api.bonotel.com/index.cfm/user/".$user."/action/gallery/hotelCode/".$hotelCode;
        $result = @file_get_contents($url);
//        print_r($result);die();
        $result = simplexml_load_string($result);
        $images = json_decode(json_encode((array)$result->channel));
        if($images==null){
            $hdImages[] = '';
            return $hdImages;
        }
        $hdImages = array();
        $tempImage = '';
        foreach($images->item as $img){
            if($img->description == 'Exterior Photo' || $img->description == 'Room Photo' || $img->description == 'Dining Photo')
            {
                $imgArr = explode('.',$img->link);
                $find = '';
                $replace = '';
                if($imgArr[count($imgArr)-1] == 'png')
                {
                    $find = '_Screen.png';
                    $replace = '_HiRes2.jpg';
                }
                else
                {
                    $find = '_Screen.jpg';
                    $replace = '_HiRes2.jpg';
                }
//                $imgSrc = str_replace("api.","",$img->link);
                $imgSrc = $img->link;
                $imgSrc = str_replace($find,$replace,$imgSrc);
                $hdImages[] = $imgSrc;
//                dd($hdImages);

            }
            else{
                $imgArr = explode('.',$img->link);
                $find = '';
                $replace = '';
                if($imgArr[count($imgArr)-1] == 'png')
                {
                    $find = '_Screen.png';
                    $replace = '_HiRes2.jpg';
                }
                else
                {
                    $find = '_Screen.jpg';
                    $replace = '_HiRes2.jpg';
                }
                $imgSrc = $img->link;
//                $imgSrc = str_replace("api.","",$img->link);
                $imgSrc = str_replace($find,$replace,$imgSrc);
                $tempImage = $imgSrc;
            }
        }
        if(count($hdImages)==0){
            $hdImages[] = $tempImage;
        }
        
        return $hdImages;
    }


    public static function Rate()
    {
        $rates = Rate::all();
        $newRate = array();
        foreach($rates as $key => $rate){
            $data = json_decode(json_encode($rate,true));
            $newRate[] = $data;
        }
        return $newRate;
    }
    public static function normalDateConverter($date){

        // $date = Carbon::parse($date)->format('Y-m-d');
        return $date;



    }

    public static function priceFormate($price){
        $price = ($price).' $';
        return $price;
    }
}