<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use App\Helpers\Helper;

use App\Destinations;

class DealsController extends Controller

{

	private $APiUser;

	private $ApiPassword;

	/*============================= controller constructor ===============================*/

	public function __construct()

	{

		//$this->APiUser = "luxVarTest_Xml";

		//$this->ApiPassword = "9kun3WP22K6GYuJ8";

		$this->APiUser = "luxVaRLive_xml";

		$this->ApiPassword = "ZGMA4bE2MBSh89qe";	

	}

	/*===================== function for searching hotel with state,city,code,name =======*/	

	public function goToHotelLandingPage(Request $request,$state,$city,$id)

	{

		$state = str_replace('-',' ',$state);

		$city  = str_replace('-',' ',$city);

		$section = '';

		if(!empty($request->session()->get("srcFlage")) && $request->session()->get("srcFlage") == 'hotel')

		{

			$hotels	= $request->session()->get('hotels');

			$sliderArr = array();

			$retHotel = $hotels[0];

			if($retHotel['hotelCode'] != $id)

			{

				$request->session()->forget('srcFlage');

				$currentUrl = $request->url();

				return redirect($currentUrl);

			}

			$url = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/gallery/hotelCode/".$id;

			$result = @file_get_contents($url);

			if(empty($result)){

			return redirect()->to("500");

			}

			$images = simplexml_load_string($result);

			$url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$id;

			$result1 = @file_get_contents($url1);

			if(empty($result1)){

				return redirect()->to("500");

			}

			$hotelPolicy = simplexml_load_string($result1);

			$url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$id;

			$result2 = @file_get_contents($url2);

			if(empty($result2)){

				return redirect()->to("500");

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

			

			$count = 0;

			$counter = 0;

			if(!isset($images->code))

			{

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

						  $sliderArr[] = $imgSrc;

						  $count++;

					  }

				  }

				  $counter++;

				}

			}

			/*============================== images section =================================*/

			if(isset($hotelPolicy->code))

			{

				$retHotel['image'] = (String)$retHotel['thumbNailUrl'];

				$hotels[0]['image'] = (String)$retHotel['thumbNailUrl'];

			}

			else

			{

				$retHotel['image'] = (String)$hotelPolicy->hotel->images->image[0];

				$hotels[0]['image'] = (String)$hotelPolicy->hotel->images->image[0];

			}

			/*============================== images section ====================================*/

			$request->session()->set("oneHotel",$retHotel);

			$request->session()->set("hotels",$hotels);

			$request->session()->save();

			$topBarData = array(); 

			$currHotelDest = DB::table('tblhotelswithcodes')

			->join('tblhotelgroupcodes','tblhotelswithcodes.hotelgroupcode','=','tblhotelgroupcodes.hotelgroupcode')

			->select('tblhotelswithcodes.hotelgroupcode','tblhotelswithcodes.hotelid','tblhotelgroupcodes.hotelgroupname')

			->where('tblhotelswithcodes.hotelid',$retHotel['hotelCode'])

			->first();

			if($currHotelDest == null)

			{

				$currHotelDest = DB::table('hotel')

				->select('hotel.cityCode')

				->where('hotel.hotelCode',$retHotel['hotelCode'])

				->first();

				if($currHotelDest != null)

				{

					$topBarData['text'] = $retHotel['name'];

					$citySlug = str_replace(' ','-',$retHotel['city']);

					$topBarData['link'] = '/cities/'.$citySlug.'/'.$retHotel['hotelCode'];

				}

			}

			else

			{

				$topBarData['text'] = $currHotelDest->hotelgroupname;

				$groupSlug = str_replace(' ','-',$currHotelDest->hotelgroupname);

				$topBarData['link'] = '/destinations/'.$currHotelDest->hotelgroupcode.'/'.$groupSlug;

			}
			
			var_dump($hotelPolicy);
			exit;
			return view('frontend.rooms',compact("sliderArr","retHotel","hotelPolicy","roomTypes","section","topBarData"));

		}

		else

		{

			$xml = "";

			if($request->input('checkin') && $request->input('checkout') && $request->input('rooms'))

			{

				$checkInObj = new \DateTime($request->input('checkin'));

				$checkOutObj = new \DateTime($request->input('checkout'));

				$checkin = $checkInObj->format('d-M-Y');

				$checkout = $checkOutObj->format('d-M-Y');

				$checkIn = $checkInObj->format('m/d/Y');

				$checkOut = $checkOutObj->format('m/d/Y');

				$request->session()->set("checkin",$checkIn);

				$request->session()->set("checkout",$checkOut);

				$interval = $checkOutObj->diff($checkInObj);

				$nights = $interval->days;

				$Arr_age = array();

				$Arr_child = array();

				$Arr_adlt = array();

				$age = "";

				$rooms = $request->input("rooms");

				for($i = 1,$j =1; $i<= $rooms; $i++,$j++)

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

			}

			else

			{

				$dateElem = date('Y-m-d');

				$checkInObj = new \DateTime($dateElem);

				$checkOutObj = new \DateTime($dateElem);

				$checkInObj->modify('+60 day');

				$checkOutObj->modify('+62 day');

				$checkin = $checkInObj->format('d-M-Y');

				$checkout = $checkOutObj->format('d-M-Y');

				$checkIn = $checkInObj->format('m/d/Y');

				$checkOut = $checkOutObj->format('m/d/Y');

				$Arr_age = array();

				$Arr_child[] = 0;

				$Arr_adlt[] = 2;

				$age = "";

				$nights = 2;

				$rooms = 1;

			}

			/*=== store these values for future usage =======*/

			$request->session()->set("num_rooms",$rooms);

			$request->session()->set("nights",$nights);

			$request->session()->set("code",$id);

			$request->session()->set("srcFlage",'');

			$request->session()->set("adults",array_sum($Arr_adlt));

			$request->session()->set("totalChild",array_sum($Arr_child));

			$request->session()->set("adultsArr",$Arr_adlt);

			$request->session()->set("childAges",$age);

			$request->session()->set("childAgesArr",$Arr_age);

			$request->session()->set("childsArr",$Arr_child);

			$request->session()->save();

			/*=== end store these values for future usage =====*/

			

			$newXml = '<?xml version="1.0" encoding="utf-8" ?>

			<availabilityRequest cancelpolicy = "Y" hotelfees="Y">

			<control>

			<userName>'.$this->APiUser.'</userName>

			<passWord>'.$this->ApiPassword.'</passWord>

			</control>

			<checkIn>'.$checkin.'</checkIn>

			<checkOut>'.$checkout.'</checkOut>

			<noOfRooms>'.$rooms.'</noOfRooms>

			<noOfNights>'.$nights.'</noOfNights>

			<country>US</country>

			<hotelCodes>

				<hotelCode>'.$id.'</hotelCode>

			</hotelCodes>

			<roomsInformation>';

			if(empty($xml))

			{

				$newXml .= '<roomInfo>

								<roomTypeId>0</roomTypeId>

								<bedTypeId>0</bedTypeId>

								<adultsNum>1</adultsNum>

								<childNum>0</childNum>

							</roomInfo>';

			}

			else

			{

				$newXml .= $xml;

			}

			$newXml .='</roomsInformation>

			</availabilityRequest>';

			$url = 'http://ws0.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do';

			//$url = "http://xmltest.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do";

			$ch = curl_init();

			curl_setopt( $ch, CURLOPT_URL, $url );

			curl_setopt( $ch, CURLOPT_POST, true );

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

			curl_setopt( $ch, CURLOPT_POSTFIELDS, $newXml );

			$result = curl_exec($ch);

			$rawData = new \SimpleXMLElement($result);

			$errors = $rawData->xpath('//errors');

			if(empty($rawData))

			{

				return redirect()->to("500");

			}

			if (count($errors) > 0) 

			{

				$errors = json_decode(json_encode($errors), true);

				$message =  "Sorry about that. We couldn’t find any deals for selected <span>hotel</span>";

				$request->session()->set('msg', $message);

				return redirect()->to('no/inventory');

			}

			else

			{

				$finalResult = $rawData->xpath('//hotel');

				$Harr = json_decode(json_encode($finalResult), true);

				curl_close($ch);

				/*==== set search result in session for sort by function ====*/

				

				$sliderArr = array();

				$retHotel = $Harr[0];

				$url = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/gallery/hotelCode/".$id;

				$result = @file_get_contents($url);

				if(empty($result)){

				return redirect()->to("500");

				}

				$images = simplexml_load_string($result);

				$url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$id;

				$result1 = @file_get_contents($url1);

				if(empty($result1)){

					return redirect()->to("500");

				}

				$hotelPolicy = simplexml_load_string($result1);

				$url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$id;

				$result2 = @file_get_contents($url2);

				if(empty($result2)){

					return redirect()->to("500");

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

				$count = 0;

				$counter = 0;

				if(!isset($images->code))

				{

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

							  $sliderArr[] = $imgSrc;

							  $count++;

						  }

					  }

					  $counter++;

					}

				}

				/*============================== images section =================================*/

				if(isset($hotelPolicy->code))

				{

					$retHotel['image'] = (String)$retHotel['thumbNailUrl'];

					$Harr[0]['image'] = (String)$retHotel['thumbNailUrl'];

				}

				else

				{

					$retHotel['image'] = (String)$hotelPolicy->hotel->images->image[0];

					$Harr[0]['image'] = (String)$hotelPolicy->hotel->images->image[0];

				}

				

				/*============================== images section ====================================*/

				$request->session()->set('hotels',$Harr);

				$request->session()->set("oneHotel",$retHotel);

				$request->session()->set("destination",$retHotel['name']);

				$request->session()->save();

				$topBarData = array(); 

				$currHotelDest = DB::table('tblhotelswithcodes')

				->join('tblhotelgroupcodes','tblhotelswithcodes.hotelgroupcode','=','tblhotelgroupcodes.hotelgroupcode')

				->select('tblhotelswithcodes.hotelgroupcode','tblhotelswithcodes.hotelid','tblhotelgroupcodes.hotelgroupname')

				->where('tblhotelswithcodes.hotelid',$retHotel['hotelCode'])

				->first();

				if($currHotelDest == null)

				{

					$currHotelDest = DB::table('hotel')

					->select('hotel.cityCode')

					->where('hotel.hotelCode',$retHotel['hotelCode'])

					->first();

					if($currHotelDest != null)

					{

						$citySlug = str_replace(' ','-',$retHotel['city']);

						$topBarData['text'] = $retHotel['city'];

						$topBarData['link'] = '/cities/'.$citySlug.'/'.$currHotelDest->cityCode;

					}

				}

				else

				{

					$topBarData['text'] = $currHotelDest->hotelgroupname;

					$groupSlug = str_replace(' ','-',$currHotelDest->hotelgroupname);

					$topBarData['link'] = '/destinations/'.$currHotelDest->hotelgroupcode.'/'.$groupSlug;

				}
				
				if(empty($xml))

				{

					return view('frontend.no-dates-selected-rooms',compact("sliderArr","retHotel","hotelPolicy","roomTypes","section","topBarData"));

				}

				else

				{

					return view('frontend.rooms',compact("sliderArr","retHotel","hotelPolicy","roomTypes","section","topBarData"));

				}

			}

		}

	}

	/*========================== end function for searching hotels =======================*/

	

	/*===================== function for searching hotel with state,city,code,name =======*/	

	public function goToHotelLandingPage1(Request $request,$city,$id)

	{

		$city  = str_replace('-',' ',$city);

		$section = '';

		$xml = "";

		if($request->input('checkin') && $request->input('checkout') && $request->input('rooms'))

		{

			$checkInObj = new \DateTime($request->input('checkin'));

			$checkOutObj = new \DateTime($request->input('checkout'));

			$checkin = $checkInObj->format('d-M-Y');

			$checkout = $checkOutObj->format('d-M-Y');

			$checkIn = $checkInObj->format('m/d/Y');

			$checkOut = $checkOutObj->format('m/d/Y');

			$request->session()->set("checkin",$checkIn);

			$request->session()->set("checkout",$checkOut);

			$interval = $checkOutObj->diff($checkInObj);

			$nights = $interval->days;

			$Arr_age = array();

			$Arr_child = array();

			$Arr_adlt = array();

			$age = "";

			$rooms = $request->input("rooms");

			for($i = 1,$j =1; $i<= $rooms; $i++,$j++)

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

		}

		else

		{

			$dateElem = date('Y-m-d');

			$checkInObj = new \DateTime($dateElem);

			$checkOutObj = new \DateTime($dateElem);

			$checkInObj->modify('+60 day');

			$checkOutObj->modify('+62 day');

			$checkin = $checkInObj->format('d-M-Y');

			$checkout = $checkOutObj->format('d-M-Y');

			$checkIn = $checkInObj->format('m/d/Y');

			$checkOut = $checkOutObj->format('m/d/Y');

			$Arr_age = array();

			$Arr_child[] = 0;

			$Arr_adlt[] = 2;

			$age = "";

			$nights = 2;

			$rooms = 1;

		}

		/*=== store these values for future usage =======*/

		$request->session()->set("num_rooms",$rooms);

		$request->session()->set("nights",$nights);

		$request->session()->set("code",$id);

		$request->session()->set("srcFlage",'');

		$request->session()->set("adults",array_sum($Arr_adlt));

		$request->session()->set("totalChild",array_sum($Arr_child));

		$request->session()->set("adultsArr",$Arr_adlt);

		$request->session()->set("childAges",$age);

		$request->session()->set("childAgesArr",$Arr_age);

		$request->session()->set("childsArr",$Arr_child);

		$request->session()->save();

		/*=== end store these values for future usage =====*/

		

		$newXml = '<?xml version="1.0" encoding="utf-8" ?>

		<availabilityRequest cancelpolicy = "Y" hotelfees="Y">

		<control>

		<userName>'.$this->APiUser.'</userName>

		<passWord>'.$this->ApiPassword.'</passWord>

		</control>

		<checkIn>'.$checkin.'</checkIn>

		<checkOut>'.$checkout.'</checkOut>

		<noOfRooms>'.$rooms.'</noOfRooms>

		<noOfNights>'.$nights.'</noOfNights>

		<country>US</country>

		<hotelCodes>

			<hotelCode>'.$id.'</hotelCode>

		</hotelCodes>

		<roomsInformation>';

		if(empty($xml))

		{

			$newXml .= '<roomInfo>

							<roomTypeId>0</roomTypeId>

							<bedTypeId>0</bedTypeId>

							<adultsNum>1</adultsNum>

							<childNum>0</childNum>

						</roomInfo>';

		}

		else

		{

			$newXml .= $xml;

		}

		$newXml .='</roomsInformation>

		</availabilityRequest>';

		$url = 'http://ws0.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do';

		//$url = "http://xmltest.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do";

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );

		curl_setopt( $ch, CURLOPT_POST, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $newXml );

		$result = curl_exec($ch);

		$rawData = new \SimpleXMLElement($result);

		$errors = $rawData->xpath('//errors');

		if(empty($rawData))

		{

			return redirect()->to("500");

		}

		if (count($errors) > 0) 

		{

			$errors = json_decode(json_encode($errors), true);

			$message =  "Sorry about that. We couldn’t find any deals for selected <span>hotel</span>";

			$request->session()->set('msg', $message);

			return redirect()->to('no/inventory');

		}

		else

		{

			$finalResult = $rawData->xpath('//hotel');

			$Harr = json_decode(json_encode($finalResult), true);

			curl_close($ch);

			/*==== set search result in session for sort by function ====*/

			

			$sliderArr = array();

			$retHotel = $Harr[0];

			$url = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/gallery/hotelCode/".$id;

			$result = @file_get_contents($url);

			if(empty($result)){

			return redirect()->to("500");

			}

			$images = simplexml_load_string($result);

			$url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$id;

			$result1 = @file_get_contents($url1);

			if(empty($result1)){

				return redirect()->to("500");

			}

			$hotelPolicy = simplexml_load_string($result1);

			$url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$id;

			$result2 = @file_get_contents($url2);

			if(empty($result2)){

				return redirect()->to("500");

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

			

			$count = 0;

			$counter = 0;

			if(!isset($images->code))

			{

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

						  $sliderArr[] = $imgSrc;

						  $count++;

					  }

				  }

				  $counter++;

				}

			}

			/*============================== images section =================================*/

			if(isset($hotelPolicy->code))

			{

				$retHotel['image'] = (String)$retHotel['thumbNailUrl'];

				$Harr[0]['image'] = (String)$retHotel['thumbNailUrl'];

			}

			else

			{

				$retHotel['image'] = (String)$hotelPolicy->hotel->images->image[0];

				$Harr[0]['image'] = (String)$hotelPolicy->hotel->images->image[0];

			}

			/*============================== images section ====================================*/

			$request->session()->set('hotels',$Harr);

			$request->session()->set("oneHotel",$retHotel);

			$request->session()->set("destination",$retHotel['name']);

			$request->session()->save();

			$topBarData = array(); 

			$currHotelDest = DB::table('tblhotelswithcodes')

			->join('tblhotelgroupcodes','tblhotelswithcodes.hotelgroupcode','=','tblhotelgroupcodes.hotelgroupcode')

			->select('tblhotelswithcodes.hotelgroupcode','tblhotelswithcodes.hotelid','tblhotelgroupcodes.hotelgroupname')

			->where('tblhotelswithcodes.hotelid',$retHotel['hotelCode'])

			->first();

			if($currHotelDest == null)

			{

				$currHotelDest = DB::table('hotel')

				->select('hotel.cityCode')

				->where('hotel.hotelCode',$retHotel['hotelCode'])

				->first();

				if($currHotelDest != null)

				{

					$topBarData['text'] = $retHotel['name'];

					$citySlug = str_replace(' ','-',$retHotel['city']);

					$topBarData['link'] = '/cities/'.$citySlug.'/'.$retHotel['hotelCode'];

				}

			}

			else

			{

				$topBarData['text'] = $currHotelDest->hotelgroupname;

				$groupSlug = str_replace(' ','-',$currHotelDest->hotelgroupname);

				$topBarData['link'] = '/destinations/'.$currHotelDest->hotelgroupcode.'/'.$groupSlug;

			}
			if(empty($xml))

			{

				return view('frontend.no-dates-selected-rooms',compact("sliderArr","retHotel","hotelPolicy","roomTypes","section","topBarData"));

			}

			else

			{

				return view('frontend.rooms',compact("sliderArr","retHotel","hotelPolicy","roomTypes","section","topBarData"));

			}

		}

	}

	/*========================== end function for searching hotels =======================*/

	

	/*================== function for searching hotel against destination ================*/	

	public function goToSearchPageDestination(Request $request,$id,$name)

	{

		$recentCheckIn = $request->session()->get('checkin');

		$recentCheckOut = $request->session()->get('checkout');

		if(empty($recentCheckIn) || empty($recentCheckOut))

		{

			$recentCheckIn = $request->session()->get('checkinRoomPage');

			$recentCheckOut = $request->session()->get('checkoutRoomPage');

		}

		$checkIn = '';

		$checkOut = '';

		$checkin = '';

		$checkout = '';

		$nights = 2;

		if(empty($recentCheckIn) || empty($recentCheckOut))

		{

			$dateElem = date('Y-m-d');

			$checkInObj = new \DateTime($dateElem);

			$checkOutObj = new \DateTime($dateElem);

			$checkInObj->modify('+60 day');

			$checkOutObj->modify('+62 day');

			$checkin = $checkInObj->format('d-M-Y');

			$checkout = $checkOutObj->format('d-M-Y');

			$checkIn = $checkInObj->format('m/d/Y');

			$checkOut = $checkOutObj->format('m/d/Y');

		}

		else

		{

			$checkInObj = new \DateTime($recentCheckIn);

			$checkOutObj = new \DateTime($recentCheckOut);

			$checkin = $checkInObj->format('d-M-Y');

			$checkout = $checkOutObj->format('d-M-Y');

			$checkIn = $checkInObj->format('m/d/Y');

			$checkOut = $checkOutObj->format('m/d/Y');

			$interval = $checkOutObj->diff($checkInObj);

			$nights = $interval->days;

		}

		$currentUrl = url('destinations/'.$id.'/'.$name);

		$name  = str_replace('-',' ',$name);

		$checkExist = Destinations::where('hotelgroupcode','=',$id)->where('hotelgroupname','=',$name)->first();

		if($checkExist == null)

		{

			return redirect()->to('/');

		}

		$Arr_age = array();

		$Arr_child[] = 0;

		$Arr_adlt[] = 2;

		$age = "";

		/*=== store these values for future usage =======*/

		$request->session()->set("checkin",$checkIn);

		$request->session()->set("checkout",$checkOut);

		$request->session()->set("num_rooms",1);

		$request->session()->set("nights",$nights);

		$request->session()->set("destination",$name);

		$request->session()->set("code",$id);

		$request->session()->set("srcFlage",'hotelgroupname');

		$request->session()->set("adults",array_sum($Arr_adlt));

		$request->session()->set("totalChild",array_sum($Arr_child));

		$request->session()->set("adultsArr",$Arr_adlt);

		$request->session()->set("childAges",$age);

		$request->session()->set("childAgesArr",$Arr_age);

		$request->session()->set("childsArr",$Arr_child);

		$request->session()->set("code",$id);

		$request->session()->save();

		/*=== end store these values for future usage =====*/

		$newXml = '<?xml version="1.0" encoding="utf-8" ?>

		<availabilityRequest cancelpolicy = "Y" hotelfees="Y">

		<control>

		<userName>'.$this->APiUser.'</userName>

		<passWord>'.$this->ApiPassword.'</passWord>

		</control>

		<checkIn>'.$checkin.'</checkIn>

		<checkOut>'.$checkout.'</checkOut>

		<noOfRooms>1</noOfRooms>

		<noOfNights>'.$nights.'</noOfNights>

		<country>US</country>

		<hotelGroupCode>'.$id.'</hotelGroupCode>

		<hotelCodes>

			<hotelCode>0</hotelCode>

		</hotelCodes>

		<roomsInformation>

		<roomInfo>

			<roomTypeId>0</roomTypeId>

			<bedTypeId>0</bedTypeId>

			<adultsNum>1</adultsNum>

			<childNum>0</childNum>

		</roomInfo>

		</roomsInformation>

		</availabilityRequest>';

		$url = 'http://ws0.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do';

		//$url = "http://xmltest.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do";

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );

		curl_setopt( $ch, CURLOPT_POST, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $newXml );

		$result = curl_exec($ch);

		$rawData = new \SimpleXMLElement($result);

		$errors = $rawData->xpath('//errors');

		if(empty($rawData))

		{

			return redirect()->to("500");

		}

		

		if (count($errors) > 0) 

		{

			$errors = json_decode(json_encode($errors), true);

			$message =  "Sorry about that. We couldn’t find any deals for selected <span>Area</span>";	

			$request->session()->set('msg', $message);

			return redirect()->to('no/inventory');

		}

		else

		{

			$finalResult = $rawData->xpath('//hotel');

			$Harr = json_decode(json_encode($finalResult), true);

			session()->put("hcode",array());

			$total_result = 0;

			/*============== loop to get stars and destinations count ===========================*/

			$starCount = array(

				'star5' => 0,

				'star4' => 0, 

				'star3' => 0, 

				'star2' => 0, 

				'star1' => 0

			);

			$dests = array();

			$destsCount = array();

			$allDest = "";

			$hCodes = array();

			$maxPrice = 0;

			foreach($Harr as $hotel)

			{ 
$currMinDeal = array();

				$currMinDeal = $hotel["roomInformation"];
				
				if(isset($currMinDeal[0]['rateInformation']['totalRate']))
				{
					uasort($currMinDeal, function ($a, $b) {
							return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));
						});
					$currMinDeal = array_values($currMinDeal);
				}
				if(isset($currMinDeal[0]['rateInformation']['totalRate']))
				{
					if(Helper::getOptimalRate($currMinDeal) > $maxPrice)
					{
					
						$maxPrice = Helper::getOptimalRate($currMinDeal) ;
					}
				}
				else
				{
					
					if(isset($currMinDeal['rateInformation'])){
						if(intval(str_replace(',','',$currMinDeal['rateInformation']['totalRate'])) > $maxPrice)
						{
							$maxPrice = intval(str_replace(',','',$currMinDeal['rateInformation']['totalRate']));
						}
					}
					else{
						if($currMinDeal==null){

						}
						else{
							dd($currMinDeal);
						}
					}

				}

				$hotel_code = $hotel["hotelCode"];

				$hCodes[] = $hotel_code;

				/*============================== rating section =================================*/

				$class = "";

				if(is_array($hotel["starRating"]))

				{

					$arr[0] = 0;

					$rating = "";

				}

				else

				{

					$arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$hotel["starRating"]);

					$rating = $hotel["starRating"]." Hotel";

				}                                                               

				if($arr[0] == 1 || $arr[0] == 1.5){

					$class = "one-star";

					$starCount['star1'] = $starCount['star1']+1; 				

				}

				elseif($arr[0] == 2 || $arr[0] == 2.5){

					$class = "two-star";

					$starCount['star2'] = $starCount['star2']+1;

				}

				elseif($arr[0] == 3 || $arr[0] == 3.5){

					$class = "three-star";

					$starCount['star3'] = $starCount['star3']+1;

				}

				elseif($arr[0] == 4 || $arr[0] == 4.5){

					$class = "four-star";

					$starCount['star4'] = $starCount['star4']+1;

				}

				elseif($arr[0] == 5 || $arr[0] == 5.5){

					$class = "five-star";

					$starCount['star5'] = $starCount['star5']+1;

				}

				/*============================== rating section =================================*/

				/*============================== making destinations section ========================*/

				if(isset($dests[$hotel["city"]]))

				{

					$curDestArr = count($dests[$hotel["city"]]);

					$dests[$hotel["city"]][$curDestArr] = $hotel["hotelCode"];

					$destsCount[$hotel["city"]] = count($dests[$hotel["city"]]);

				}

				else

				{

					$curDestArr = 0;

					$dests[$hotel["city"]][$curDestArr] = $hotel["hotelCode"];

					$destsCount[$hotel["city"]] = 1;

					$allDest .= $hotel["city"].",";

				}

				

				/*============================== making destinations section ========================*/

			}

			/*============== end loop to get stars and destinations count =======================*/

			$total_result = count($Harr);

			$maxPrice = ceil($maxPrice/$nights);

			curl_close($ch);

			/*==== set search result in session for sort by function ====*/

			$request->session()->set("hGroup",$dests);

			$request->session()->set("allCodes",$hCodes);

			$request->session()->set("destCount",$destsCount);

			$request->session()->set("allDest",$allDest);

			$request->session()->set("checkArea",$id);

			$request->session()->set('starCount',$starCount);

			$request->session()->set('hotels', $Harr);

			$request->session()->set("imgCount",0);

			$request->session()->set("reqFlag",1);

			$request->session()->set("filterChanged",-1);

			$request->session()->set("filterCombinations",array());

			/*==== set result result in session ====*/

			return view('frontend.search',compact("hGroup","Harr","Harray","search_name",

			"total_result","nights","facArr","facilityCount","starCount","dests","destsCount","allDest","facs","maxPrice","currentUrl"));

		}

	}

	/*============= end function for searching hotels against destination ================*/

	

	/*================== function for searching hotel against cities =====================*/	

	public function goToSearchPageCitites(Request $request,$city,$citycode)

	{

		$recentCheckIn = $request->session()->get('checkin');

		$recentCheckOut = $request->session()->get('checkout');

		if(empty($recentCheckIn) || empty($recentCheckOut))

		{

			$recentCheckIn = $request->session()->get('checkinRoomPage');

			$recentCheckOut = $request->session()->get('checkoutRoomPage');

		}

		$currentUrl = url('cities/'.$city.'/'.$citycode);

		$name  = str_replace('-',' ',$city);

		$checkIn = '';

		$checkOut = '';

		$checkin = '';

		$checkout = '';

		$nights = 2;

		if(empty($recentCheckIn) || empty($recentCheckOut))

		{

			$dateElem = date('Y-m-d');

			$checkInObj = new \DateTime($dateElem);

			$checkOutObj = new \DateTime($dateElem);

			$checkInObj->modify('+60 day');

			$checkOutObj->modify('+62 day');

			$checkin = $checkInObj->format('d-M-Y');

			$checkout = $checkOutObj->format('d-M-Y');

			$checkIn = $checkInObj->format('m/d/Y');

			$checkOut = $checkOutObj->format('m/d/Y');

		}

		else

		{

			$checkInObj = new \DateTime($recentCheckIn);

			$checkOutObj = new \DateTime($recentCheckOut);

			$checkin = $checkInObj->format('d-M-Y');

			$checkout = $checkOutObj->format('d-M-Y');

			$checkIn = $checkInObj->format('m/d/Y');

			$checkOut = $checkOutObj->format('m/d/Y');

			$interval = $checkOutObj->diff($checkInObj);

			$nights = $interval->days;

		}

		$Arr_age = array();

		$Arr_child[] = 0;

		$Arr_adlt[] = 2;

		$age = "";

		/*=== store these values for future usage =======*/

		$request->session()->set("checkin",$checkIn);

		$request->session()->set("checkout",$checkOut);

		$request->session()->set("num_rooms",1);

		$request->session()->set("nights",$nights);

		$request->session()->set("destination",$name);

		$request->session()->set("code",$citycode);

		$request->session()->set("srcFlage",'city');

		$request->session()->set("adults",array_sum($Arr_adlt));

		$request->session()->set("totalChild",array_sum($Arr_child));

		$request->session()->set("adultsArr",$Arr_adlt);

		$request->session()->set("childAges",$age);

		$request->session()->set("childAgesArr",$Arr_age);

		$request->session()->set("childsArr",$Arr_child);

		$request->session()->save();

		/*=== end store these values for future usage =====*/

		$newXml = '<?xml version="1.0" encoding="utf-8" ?>

		<availabilityRequest cancelpolicy = "Y" hotelfees="Y">

		<control>

		<userName>'.$this->APiUser.'</userName>

		<passWord>'.$this->ApiPassword.'</passWord>

		</control>

		<checkIn>'.$checkin.'</checkIn>

		<checkOut>'.$checkout.'</checkOut>

		<noOfRooms>1</noOfRooms>

		<noOfNights>'.$nights.'</noOfNights>

		<country>US</country>

		<city>'.$citycode.'</city>

		<hotelCodes>

			<hotelCode>0</hotelCode>

		</hotelCodes>

		<roomsInformation>

		<roomInfo>

			<roomTypeId>0</roomTypeId>

			<bedTypeId>0</bedTypeId>

			<adultsNum>1</adultsNum>

			<childNum>0</childNum>

		</roomInfo>

		</roomsInformation>

		</availabilityRequest>';

		$url = 'http://ws0.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do';

		//$url = "http://xmltest.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do";

		

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );

		curl_setopt( $ch, CURLOPT_POST, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $newXml );

		$result = curl_exec($ch);

		$rawData = new \SimpleXMLElement($result);

		$errors = $rawData->xpath('//errors');

		if(empty($rawData))

		{

			return redirect()->to("500");

		}

		

		if (count($errors) > 0) 

		{

			$errors = json_decode(json_encode($errors), true);

			$message =  "Sorry about that. We couldn’t find any deals for selected <span>City</span>";	

			$request->session()->set('msg', $message);

			return redirect()->to('no/inventory');

		}

		else

		{

			$finalResult = $rawData->xpath('//hotel');

			$Harr = json_decode(json_encode($finalResult), true);

			session()->put("hcode",array());

			$total_result = 0;

			/*============== loop to get stars and destinations count ===========================*/

			$starCount = array(

				'star5' => 0,

				'star4' => 0, 

				'star3' => 0, 

				'star2' => 0, 

				'star1' => 0

			);

			$dests = array();

			$destsCount = array();

			$allDest = "";

			$hCodes = array();

			$maxPrice = 0;

			foreach($Harr as $hotel)

			{ 

				$rates = $hotel["roomInformation"];

				$prices = array_reduce($rates, function ($a, $b) {

							if(isset($b['rateInformation']))

							{

								return @intval(str_replace(',','',$a['rateInformation']['totalRate'])) > intval(str_replace(',','',$b['rateInformation']['totalRate'])) ? $a : $b;

							}

							else

							{

								return $a;

							}

						});

				if(intval(str_replace(',','',$prices['rateInformation']['totalRate'])) > $maxPrice)

				{

					$maxPrice = intval(str_replace(',','',$prices['rateInformation']['totalRate']));

				}

				$hotel_code = $hotel["hotelCode"];

				$hCodes[] = $hotel_code;

				/*============================== rating section =================================*/

				$class = "";

				if(is_array($hotel["starRating"]))

				{

					$arr[0] = 0;

					$rating = "";

				}

				else

				{

					$arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$hotel["starRating"]);

					$rating = $hotel["starRating"]." Hotel";

				}                                                               

				if($arr[0] == 1 || $arr[0] == 1.5){

					$class = "one-star";

					$starCount['star1'] = $starCount['star1']+1; 				

				}

				elseif($arr[0] == 2 || $arr[0] == 2.5){

					$class = "two-star";

					$starCount['star2'] = $starCount['star2']+1;

				}

				elseif($arr[0] == 3 || $arr[0] == 3.5){

					$class = "three-star";

					$starCount['star3'] = $starCount['star3']+1;

				}

				elseif($arr[0] == 4 || $arr[0] == 4.5){

					$class = "four-star";

					$starCount['star4'] = $starCount['star4']+1;

				}

				elseif($arr[0] == 5 || $arr[0] == 5.5){

					$class = "five-star";

					$starCount['star5'] = $starCount['star5']+1;

				}

				/*============================== rating section =================================*/

				/*============================== making destinations section ========================*/

				if(isset($dests[$hotel["city"]]))

				{

					$curDestArr = count($dests[$hotel["city"]]);

					$dests[$hotel["city"]][$curDestArr] = $hotel["hotelCode"];

					$destsCount[$hotel["city"]] = count($dests[$hotel["city"]]);

				}

				else

				{

					$curDestArr = 0;

					$dests[$hotel["city"]][$curDestArr] = $hotel["hotelCode"];

					$destsCount[$hotel["city"]] = 1;

					$allDest .= $hotel["city"].",";

				}

				

				/*============================== making destinations section ========================*/

			}

			/*============== end loop to get stars and destinations count =======================*/

			$total_result = count($Harr);

			$maxPrice = ceil($maxPrice);

			curl_close($ch);

			/*==== set search result in session for sort by function ====*/

			$request->session()->set("hGroup",$dests);

			$request->session()->set("allCodes",$hCodes);

			$request->session()->set("destCount",$destsCount);

			$request->session()->set("allDest",$allDest);

			$request->session()->set("checkArea",'');

			$request->session()->set('starCount',$starCount);

			$request->session()->set('hotels', $Harr);

			$request->session()->set("imgCount",0);

			$request->session()->set("reqFlag",1);

			$request->session()->set("filterChanged",-1);

			$request->session()->set("filterCombinations",array());

			/*==== set result result in session ====*/

			return view('frontend.search',compact("hGroup","Harr","Harray","search_name",

			"total_result","nights","facArr","facilityCount","starCount","dests","destsCount","allDest","facs","maxPrice","currentUrl"));

		}

	}

	/*============= end function for searching hotels against cities =====================*/		

	

/*========================== end search controller ===================================*/

}

		  

