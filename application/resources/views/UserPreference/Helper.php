<?php

namespace App\Helpers;

use App\Api;

use App\Rate;
use App\Hotel;
use DB;


class Helper

{

    public static function api()

    {

		$api_detail = Api::first();

        return $api_detail;

    }

    public static function GetHtmlForReservation($reservations){
     $counter = 0;
        $html = '';
      if(count($reservations)!=0){
        foreach($reservations as $reservation){
          $html.= '<div class="reservation-box"><div class="reservation-box-title">';
          if($reservation->booking_status == 'Pending'){
            $html.='<h2 class="blue-text">Booking'.$reservation->booking_status.'</h2>';
          }
          if($reservation->booking_status == 'Canceled'){
            $html.='<h2 class="red-text">Booking'.$reservation->booking_status.'</h2>';
          }
          if($reservation->booking_status == 'Confirmed'){
            $html.='<h2 class="green-text">Booking'.$reservation->booking_status.'</h2>';
          }
          $html.= '</div><div class="reservation-box-dropdown">
          <div  id="moreOptions'.$counter.'" class="moreOptionsClick reservation-box-dots">
             <span id="moreOptions'.$counter.'"></span>
             <span id="moreOptions'.$counter.'"></span>
             <span id="moreOptions'.$counter.'"></span>
              </div><ul id="options'.$counter.'"><li class="booking"><a href="'.url("user/reservations/".$reservation->booking_id."/viewBooking").'">View Booking</a></li>
              <li><a href="">Add Note</a></li>
              <li><a href="'.url("user/reservations/".$reservation->booking_id."/cancel").'">CancelBooking</a></li></ul>'.$counter++.'</div>';
              $html.='<div class="reservation-description">
                <div class="reservation-description-left">
                  <div class="booking-date">
                    <h4>Booking Date</h4><h5>'.$reservation->booking_date .'</h5>
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
                    <p><span>Check In:</span>'. $reservation ->booking_traveldate .'</p>
                    <p><span>Check Out:</span> '.$reservation ->booking_traveldateEnd.'</p>
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
          return $html;

        }
      }
      else{
           echo "no response";
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
			}
			else
			{
				$arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$starRating);
				$rating = $starRating." Hotel";
			}
			if($arr[0] == 1 || $arr[0] == 1.5){
				$class = "one-star";
				$array['star1'] = $array['star1']+1;
			}
			elseif($arr[0] == 2 || $arr[0] == 2.5){
				$class = "two-star";
				$array['star2'] = $array['star2']+1;
			}
			elseif($arr[0] == 3 || $arr[0] == 3.5){
				$class = "three-star";
				$array['star3'] = $array['star3']+1;
			}
			elseif($arr[0] == 4 || $arr[0] == 4.5){
				$class = "four-star";
				$array['star4'] = $array['star4']+1;
			}
			elseif($arr[0] == 5 || $arr[0] == 5.5){
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
		$images = simplexml_load_string($result);

		$images = json_decode(json_encode((array)$images->channel));
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
					  $imgSrc = str_replace("api.","",$img->link);
					  $imgSrc = str_replace($find,$replace,$imgSrc);
					  $hdImages[] = $imgSrc;
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
					  $imgSrc = str_replace("api.","",$img->link);
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

}
