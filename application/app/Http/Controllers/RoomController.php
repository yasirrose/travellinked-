<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use DB;

class RoomController extends Controller

{

	private $APiUser;

	private $ApiPassword;

    private $provider;

	/*============================= controller constructor ===============================*/

	public function __construct()

	{

		// $this->APiUser = "luxVarTest_Xml";

		// $this->ApiPassword = "9kun3WP22K6GYuJ8";

		$this->APiUser = Helper::api()->api_user;

		$this->ApiPassword = Helper::api()->api_password;

        $this->provider = Helper::api()->api_provider;

	}

	/*==================== function for providing data about hotel details (rooms,images) ==================*/

	public function hotelRooms(Request $request){
		$hotelCode = $request->input("hotel");
		/*======== session set for search result page if back /if you remove this the sky will fall on you/======*/

		//$request->session()->set("imgCount",0);

		//$request->session()->set("filterChanged",-1);

		//$request->session()->save();

		/*======== This session set for search result pervieous page if back======*/
		$sliderArr = array();
		$retHotel  = array();
		$hotels	= $request->session()->get('hotels');
		$url = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/gallery/hotelCode/".$hotelCode;
		$result = @file_get_contents($url);
		if(empty($result)){
		    return redirect()->to("500");
		}
		$images = simplexml_load_string($result);
		$url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$hotelCode;
		$result1 = @file_get_contents($url1);
		if(empty($result1)){
			return redirect()->to("500");
		}
		$hotelPolicy = simplexml_load_string($result1);
		$url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$hotelCode;
        $result2 = @file_get_contents($url2);
		if(empty($result2)){
			return redirect()->to("500");
		}
		$roomBeds = simplexml_load_string($result2);
		$roomTypes = array();
		foreach($roomBeds->hotel->room as $room) {
			$roomType = (string)$room->roomTypeID;
			foreach($room->bed as $bed)
			{
				$bedType = (string)$bed->bedTypeID;
				$roomTypes[$roomType][$bedType]['adults'] = $bed->adults;
				$roomTypes[$roomType][$bedType]['child'] = $bed->children;
			}
		}
		$count = 0;
		$counter = 0;
		if(!isset($images->code)) {
			foreach($images->channel->item as $img)
			{
			  if($count > 3)
				break;
			  if($counter > 0 && $img->description != 'logos')
			  {
				  if($img->description == 'Exterior Photo' || $img->description == 'Room Photo' || $img->description == 'Dining Photo')
				  {
					  $imgArr = explode('.',$img->link);
					  $find = '';
					  $replace = '';
					  if($imgArr[count($imgArr)-1] == 'png') {
						  $find = '_Screen.png';
						  $replace = '_HiRes2.jpg';
					  }
					  else
					  {
						  $find = '_Screen.jpg';
						  $replace = '_HiRes2.jpg';
					  }
//					  $imgSrc = str_replace("api.","",$img->link);
					  $imgSrc = $img->link;
					  $imgSrc = str_replace($find,$replace,$imgSrc);
					  $sliderArr[] = $imgSrc;
					  $count++;
				  }
			  }
			  $counter++;
			}
		}
		foreach($hotels as $hotel)
		{
			if($hotel['hotelCode'] == $hotelCode) {
				$retHotel = $hotel;
				break;
			}
		}
		/*============================== images section =================================*/
		if(!isset($retHotel['image'])) {
			if(isset($result2->code)) {
				$retHotel['image'] = (String)$hotelPolicy['thumbNailUrl'];
			}
			else{
				$retHotel['image'] = (String)$hotelPolicy->hotel->images->image[0];
			}
		}
		/*============================== images section ====================================*/
		$section = '';
		if($request->input('section')) {
			if($request->input('section') == 'overview') {
				$section = 'hotelDesSection';
			}
			elseif($request->input('section') == 'rooms') {
				$section = 'roomAvlSection';
			}
		}
		$request->session()->set("oneHotel",$retHotel);
		$request->session()->save();
		$topBarData = array();
		$currHotelDest = DB::table('tblhotelswithcodes')
		->join('tblhotelgroupcodes','tblhotelswithcodes.hotelgroupcode','=','tblhotelgroupcodes.hotelgroupcode')
		->select('tblhotelswithcodes.hotelgroupcode','tblhotelswithcodes.hotelid','tblhotelgroupcodes.hotelgroupname')
		->where('tblhotelswithcodes.hotelid',$retHotel['hotelCode'])
		->first();
		if($currHotelDest == null) {
			$currHotelDest = DB::table('hotel')
			->select('hotel.cityCode')
			->where('hotel.hotelCode',$retHotel['hotelCode'])
                ->first();
			if($currHotelDest != null) {
				$topBarData['text'] = $retHotel['city'];
				$citySlug = str_replace(' ','-',$retHotel['city']);
				$topBarData['link'] = '/cities/'.$citySlug.'/'.$currHotelDest->cityCode;
			}
		}
		else {
			$topBarData['text'] = $currHotelDest->hotelgroupname;
			$groupSlug = str_replace(' ','-',$currHotelDest->hotelgroupname);
			$topBarData['link'] = '/destinations/'.$currHotelDest->hotelgroupcode.'/'.$groupSlug;
		}
		$actualRate = $retHotel['roomInformation'][0]['rateInformation']['totalRate'];
		$fullUrl =  \Request::fullUrl();
        $request->session()->set('roomDetail',2);
        $request->session()->set('fullUrl',$fullUrl);
        $request->session()->set('rooomHotelCode',$retHotel['hotelCode']);


        return view('frontend.rooms',compact("sliderArr", "actualRate","retHotel","hotelPolicy","roomTypes","section","topBarData",'fullUrl'));

	}

	/*==================== wnd function for providing data about hotel details (rooms,images) ==================*/

	

	/*==================== function for searching hotel rooms availability ==================*/

	public function searchWithNewParams(Request $request)

	{

		$oneHotel = $request->session()->get("oneHotel");

		$adults   = $request->input("adultsRoomPage");

		$checkinr  = $request->input("checkinRoomPage");

		$hotelCode = $request->input("hcodeRoomPage");

		$numNights = $request->input("nightsRoomPage");

	


		$numRooms  = $request->input("horizRooms");

		if($numRooms==0){
			$numRooms=1;
		}

		$checkoutr = $request->input("checkoutRoomPage");

		$checkInObj = new \DateTime($checkinr);

		$checkOutObj = new \DateTime($checkoutr);

		$checkin = $checkInObj->format('d-M-Y');

		$checkout = $checkOutObj->format('d-M-Y');

		/*=== pass these values to the next page=======*/

		$request->session()->set("adultRoom",$adults);

		$request->session()->set("checkinRoom",$checkinr);

		$request->session()->set("checkoutRoom",$checkoutr);

		$request->session()->set("nightsRoom",$numNights);

		$request->session()->set("hotelcodeRoom",$hotelCode);

		$request->session()->save();

		/*=== end set session=======*/

		$Arr_age = array();

		$Arr_child = array();

		$Arr_adlt = array();

		$xml = "";

		$age = "";

		for($i = 1,$j =1; $i<= $numRooms; $i++,$j++)

		{

			$adlt ="adults_".$i;

			$Arr_adlt[] = $_GET[$adlt];

			$chlds = "children_".$j;

			$Arr_child[] = $_GET[$chlds];

			if($i == 1)

			{

				if($request->input("children_1") != 0 )

				{

					$age["1"] = "";

					$ch = $_GET["children_1"];

					for($n = 1; $n <= $ch; $n++)

					{

						$ages = "children_1_age_".$n;

						$Arr_age['room1'][] = $_GET[$ages];

						$age["1"] .= '<childAge>'.$_GET[$ages].'</childAge>';

					}

				}

			}

			elseif($i == 2){

				if($request->input("children_2") != 0 )

				{

					$age["2"] = "";

					$ch2 = $_GET["children_2"];

					for($n = 1; $n <= $ch2; $n++)

					{

						$ages = "children_2_age_".$n;

						$Arr_age['room2'][] = $_GET[$ages];

						$age["2"] .= '<childAge>'.$_GET[$ages].'</childAge>';

					}

				}

			}

			elseif($i == 3)

			{

				if( $request->input("children_3") != 0 )

				{

					$age["3"] = "";

					$ch3 = $_GET["children_3"];



					for($n = 1; $n <= $ch3; $n++)

					{

						$ages = "children_3_age_".$n;

						$Arr_age['room3'][] = $_GET[$ages];

						$age["3"] .= '<childAge>'.$_GET[$ages].'</childAge>';

					}

				}

			}

			elseif($i == 4){

				if($request->input("children_4") != 0)

				{

					$age["4"] = "";

					$ch4 = $_GET["children_4"];



					for($n = 1; $n <= $ch4; $n++)

					{

						$ages = "children_4_age_".$n;

						$Arr_age['room4'][] = $_GET[$ages];

						$age["4"] .= '<childAge>'.$_GET[$ages].'</childAge>';

					}

				}

			}

			elseif($i == 5)

			{

				if($request->input("children_5") != 0)

				{

					$age["5"] = "";

					$ch5 = $_GET["children_5"];



					for($n = 1; $n <= $ch5; $n++)

					{

						$ages = "children_5_age_".$n;

						$Arr_age['room5'][] = $_GET[$ages];

						$age["5"] .= '<childAge>'.$_GET[$ages].'</childAge>';

					}

				}

			}

			if(isset($age[$i]))

			{

				$xml .= '<roomInfo>

				<roomTypeId>0</roomTypeId>

				<bedTypeId>0</bedTypeId>

				<adultsNum>'.$_GET[$adlt].'</adultsNum>

				<childNum>'.$_GET[$chlds].'</childNum>

				<childAges>'.$age[$i].'</childAges>

				</roomInfo>';

			}

			else

			{

				$xml .= '<roomInfo>

				<roomTypeId>0</roomTypeId>

				<bedTypeId>0</bedTypeId>

				<adultsNum>'.$_GET[$adlt].'</adultsNum>

				<childNum>'.$_GET[$chlds].'</childNum>

				<childAges>0</childAges>

				</roomInfo>';

			}

		}

		$newXml = '<?xml version="1.0" encoding="utf-8" ?>

		<availabilityRequest cancelpolicy = "Y" hotelfees="Y">

		<control>

		<userName>'.$this->APiUser.'</userName>

		<passWord>'.$this->ApiPassword.'</passWord>

		</control>

		<checkIn>'.$checkin.'</checkIn>

		<checkOut>'.$checkout.'</checkOut>

		<noOfRooms>'.$numRooms.'</noOfRooms>

		<noOfNights>'.$numNights.'</noOfNights>

		<country>US</country>

		<hotelCodes>

			<hotelCode>'.$hotelCode.'</hotelCode>

		</hotelCodes>

		<roomsInformation>'.$xml.'</roomsInformation>

		</availabilityRequest>';

		$url = $this->provider.'bonotelapps/bonotel/reservation/GetAvailability.do';

		//$url = "http://ws0.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do";

        
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );

		curl_setopt( $ch, CURLOPT_POST, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $newXml );

		$result = curl_exec($ch);


		curl_close($ch);


		$rawData = new \SimpleXMLElement($result);


		$errors = $rawData->xpath('//errors');



		if(empty($rawData))

		{
			dd($rawData);
			return response()->json(['error'=>500,'msg'=>'']);

			exit;
		}

		if (count($errors) > 0)

		{


			$roomsArrCheck = $oneHotel['roomInformation'];

			$roomsArr = (object)$oneHotel['roomInformation'];

			$url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$hotelCode;

			$result2 = @file_get_contents($url2);

			if(empty($result2))

			{

				return response()->json(['error'=>500,'msg'=>'']);

				exit;

			}
			else{
				return response()->json(['error'=>1, 'html'=>'<div>Room Not Available</div>']);
				exit;
			}

			$roomBeds = simplexml_load_string($result2);

			$roomTypes = array();

			foreach($roomBeds->hotel->room as $room)

			{

				$roomType = (string)$room->roomTypeID;

				foreach($room->bed as $bed)

				{

					$bedType = (string)$bed->bedTypeID;

					$roomTypes[$roomType][$bedType]['adults'] = $bed->adults;

					$roomTypes[$roomType][$bedType]['child'] = $bed->children;

				}

			}



			$html = "";

			if(isset($roomsArrCheck[0]['roomCode']))

			{

				$counter = 1;

				for($blockNo = 1; $blockNo<=$numRooms;$blockNo++){

					$html.='<div class="pform-row pick-room mt-extra roomBlocks" name="roomBlock'.$blockNo.'">

					<h3>Room '.$blockNo.'</h3>';

					foreach($roomsArr as $room)

					{

						$html.= '<div class="pform-1">

						<div class="left-check-title">

						<div class="inner-right-title">

						<h4>'.$room['roomType'].'</h4>

						</div>

						<a href="javascript:void(0)" name="room'.$counter.'" onclick="showDesc(this.name)">More info</a>

						</div>

						<div class="right-amout">

						<button id="adjustDatesButton">Adjust Dates</button>

						</div>

						<div class="hide_box" style="display:none;" id="room'.$counter.'">

						<h4 class="sm-minimize-text">'.$room['roomType'].' <span>'.$room['bedType'].'</span></h4>

						<p><b>Adults : </b>'.$room["stdAdults"].'</p>';

						if(isset($roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child']))

						{

							$html .='<p><b>Children : </b>'.$roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child'].'</p>';

						}

						else

						{

							$html .='<p><b>Children : </b>0</p>';

						}

						$html .='<p>'.implode(" ",$room['roomDescription']).'</p>

						</div>

						</div>';

						$counter++;

					}

					$html.='</div>

					<div class="pform-row pick-room btn">

						<div class="pform-1 viewMoreOption" id="roomBlock'.$blockNo.'">

							<a href="javascript:void(0)">View More Option&nbsp; <i class="icon ion-ios-arrow-thin-down"></i></a>

						</div>     

					</div>';

				}

			}

			else

			{
				for($blockNo = 1; $blockNo<=$numRooms;$blockNo++)

				{

					$html.='<div class="pform-row pick-room mt-extra roomBlocks" name="roomBlock'.$blockNo.'">

					<h3>Room '.$blockNo.'</h3>';

					$html.= '<div class="pform-1">

					<div class="left-check-title">

					<div class="inner-right-title">

					<h4>'.$roomsArr->roomType.'</h4>

					</div>

					<a href="javascript:void(0)" name="room1" onclick="showDesc(this.name)">More info</a>

					</div>

					<div class="right-amout">

					<button id="adjustDatesButton">Adjust Dates</button>

					</div>

					<div class="hide_box" style="display:none;" id="room1">

					<h4 class="sm-minimize-text">'.$roomsArr->roomType.' <span>'.$roomsArr->bedType.'</span></h4>

					<p><b>Adults : </b>'.$roomsArr->stdAdults.'</p>';

					if(isset($roomTypes[(string)$roomsArr->roomTypeCode][(string)$room->bedTypeCode]['child']))

					{

						$html .= '<p><b>Children : </b>'.$roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'].'</p>';

					}

					else

					{

						$html .= '<p><b>Children : </b>0</p>';

					}

					$html .='<p>'.implode(" ",$roomsArr->roomDescription).'</p>

					</div>

					</div>

					</div>

					<div class="pform-row pick-room btn">

						<div class="pform-1 viewMoreOption" id="roomBlock'.$blockNo.'">

							<a href="javascript:void(0)">View More Option&nbsp; <i class="icon ion-ios-arrow-thin-down"></i></a>

						</div>     

					</div>';

				}

			}

			return response()->json(['error'=>1,'msg'=>$html]);

			exit;

		}

		$request->session()->set("adults",array_sum($Arr_adlt));

		$request->session()->set("totalChild",array_sum($Arr_child));

		$request->session()->set("adultsArr",$Arr_adlt);

		$request->session()->set("childAges",$age);

		$request->session()->set("childAgesArr",$Arr_age);

		$request->session()->set("childsArr",$Arr_child);

		$finalResult = $rawData->xpath('//hotel');

		$Harr = json_decode(json_encode($finalResult), true);

		if(isset($oneHotel['image']))

		{

			$Harr[0]['image'] = $oneHotel['image'];

		}

		else

		{

			$Harr[0]['image'] = $Harr[0]['thumbNailUrl'];

		}

		$request->session()->set("oneHotel",$Harr[0]);

		$request->session()->save();

		$roomsArrCheck = $Harr[0]['roomInformation'];

		$roomsArr = (object)$Harr[0]['roomInformation'];



		$url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$Harr[0]["hotelCode"];

		$result2 = @file_get_contents($url2);

		if(empty($result2))

		{

			return response()->json(['error'=>500,'msg'=>'']);

			exit;

		}

		$roomBeds = simplexml_load_string($result2);

		$roomTypes = array();

		foreach($roomBeds->hotel->room as $room)

		{

			$roomType = (string)$room->roomTypeID;

			foreach($room->bed as $bed)

			{

				$bedType = (string)$bed->bedTypeID;

				$roomTypes[$roomType][$bedType]['adults'] = $bed->adults;

				$roomTypes[$roomType][$bedType]['child'] = $bed->children;

			}

		}



		$html = "";

		$minDeal = array();

		$minPrice = 0;

		if(isset($roomsArrCheck[0]['roomCode']))

		{

			$counter = 1;

			$minDeal = $roomsArrCheck;

			uasort($minDeal, function ($a, $b) {

				return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

			});

			$minDeal = array_values($minDeal);

			//$minPrice = str_replace(',','',$minDeal[0]['rateInformation']['totalRate']);

			$minPrice = Helper::getOptimalRate($minDeal);

			$minPrice = number_format((float)round(($minPrice)/$numNights,2),2,'.','');
           
			for($blockNo = 1; $blockNo<=$numRooms;$blockNo++){

				$checkCounter = 0;

				$html.='<div class="pform-row pick-room mt-extra roomBlocks" name="roomBlock'.$blockNo.'">';

				if($numRooms > 1)

				{

					$html.='<h3>Room '.$blockNo.'</h3>';

				}

				foreach($minDeal as $key => $room)

				{

					if($room['roomNo'] == $blockNo)

					{

						$actualRate = $room['rateInformation']['totalRate'];

						$actualRate = str_replace(",","",$actualRate);

						

                        $html.= '<div class="pform-1">

						<div class="left-check-title">

						<div class="rating-check">

						<input type="hidden" class="hotel_code" class="hotets" value="'.$Harr[0]["hotelCode"].'">';

						if($checkCounter == 0){

						$html.='<input type="checkbox" class="book_room" name="room_code[]" id="'.$room['roomCode'].'" value="'.$room['roomCode'].'" checked="checked">';

						}

						else

						{

						$html.='<input type="checkbox" class="book_room" name="room_code[]" id="'.$room['roomCode'].'" value="'.$room['roomCode'].'">';

						}

						$html.='<i class="icon ion-checkmark-round"></i>

						</div>

						<div class="inner-right-title">

						<h4>'.$room['roomType'].'</h4>

						</div>

						<a href="javascript:void(0)" name="room'.$counter.'" onclick="showDesc(this.name)">More info</a>

						</div>

						<div class="right-amout">

						<h4>$'.number_format((float)round($actualRate/$numNights,2),2,'.','').'<span>/night
						</span></h4>

						</div>

						<div class="hide_box" style="display:none;" id="room'.$counter.'">

						<h4 class="sm-minimize-text">'.$room['roomType'].' <span>'.$room['bedType'].'</span></h4>

						<p><b>Adults : </b>'.$room["stdAdults"].'</p>';

						if(isset($roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child']))

						{

							$html .='<p><b>Children : </b>'.$roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child'].'</p>';

						}

						else

						{

							$html .='<p><b>Children : </b>0</p>';

						}

						$html .='<p>'.implode(" ",$room['roomDescription']).'</p>

						</div>

						</div>';

						$counter++;

						$checkCounter++;

					}

				}

				$html.='</div>

				<div class="pform-row pick-room btn">

					<div class="pform-1 viewMoreOption" id="roomBlock'.$blockNo.'">

						<a href="javascript:void(0)">View More Option&nbsp; <i class="icon ion-ios-arrow-thin-down"></i></a>

					</div>     

				</div>';

			}

		}

		else

		{

			$minPrice = str_replace(',','',$roomsArr->rateInformation['totalRate']);

			$minPrice = number_format((float)round(($minPrice/$numNights),2),2,'.','');

			for($blockNo = 1; $blockNo<=$numRooms;$blockNo++)

			{

				if($roomsArr->roomNo == $blockNo)

				{

					$html.='<div class="pform-row pick-room mt-extra roomBlocks" name="roomBlock'.$blockNo.'">';

					if($numRooms > 1)

					{

						$html.='<h3>Room '.$blockNo.'</h3>';

					}

					$actualRate = $roomsArr->rateInformation['totalRate'];

					$actualRate = str_replace(",","",$actualRate);

					$html.= '<div class="pform-1">

					<div class="left-check-title">

					<div class="rating-check">

					<input type="hidden" class="hotel_code" class="hotets" value="'.$Harr[0]["hotelCode"].'">

					<input type="checkbox" class="book_room" name="room_code[]" id="'.$roomsArr->roomCode.'" value="'.$roomsArr->roomCode.'" checked="checked">

					<i class="icon ion-checkmark-round"></i>

					</div>

					<div class="inner-right-title">

					<h4>'.$roomsArr->roomType.'</h4>

					</div>

					<a href="javascript:void(0)" name="room1" onclick="showDesc(this.name)">More info</a>

					</div>

					<div class="right-amout">

					<h4>$'.number_format((float)round((Helper::getCalculatedPrice($actualRate/$numNights)),2),2,'.','').'<span>/night</span></h4>

					</div>

					<div class="hide_box" style="display:none;" id="room1">

					<h4 class="sm-minimize-text">'.$roomsArr->roomType.' <span>'.$roomsArr->bedType.'</span></h4>

					<p><b>Adults : </b>'.$roomsArr->stdAdults.'</p>';

					if(isset($roomTypes[(string)$roomsArr->roomTypeCode][(string)$room->bedTypeCode]['child']))

					{

						$html .= '<p><b>Children : </b>'.$roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'].'</p>';

					}

					else

					{

						$html .= '<p><b>Children : </b>0</p>';

					}

					$html .='<p>'.implode(" ",$roomsArr->roomDescription).'</p>

					</div>

					</div>

					</div>

					<div class="pform-row pick-room btn">

						<div class="pform-1 viewMoreOption" id="roomBlock'.$blockNo.'">

							<a href="javascript:void(0)">View More Option&nbsp; <i class="icon ion-ios-arrow-thin-down"></i></a>

						</div>     

					</div>';

				}

			}

		}

		return response()->json(['error'=>0,'msg'=>$html,'minPrice'=>'$'.$minPrice]);

		exit;

	}

	/*==================== end function for searching hotel rooms availability ==================*/ 

	/*========================== function for redirecting to payment page =========================*/ 

	public function goToPyament(Request $request)

	{

		$result = $request->session()->get('hotels');

		$hotel_code = $request->input("hotel_code");

		$room_id = $request->input("room_id");

		$hotel = array();	

		foreach($result as $Hotels)

		{ 

			if($hotel_code == $Hotels["hotelCode"])

			{

				$hotel[] = $Hotels;	

			}

		}

		session_start();	

		$_SESSION["pay_detail"] = $hotel;

		echo json_encode(1);

		exit;

	}  

	/*========================== end function for redirecting to payment page =====================*/ 

/*========================== end rooms controller ===================================*/

}

