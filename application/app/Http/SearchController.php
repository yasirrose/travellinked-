<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use App\Helpers\Helper;

class SearchController extends Controller

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

        $this->provider = Helper::api()->api_provider;

        $this->ApiPassword = Helper::api()->api_password;

    }

    /*========================== function for not found response =========================*/

    public function Inventory_Not_Fount(Request $request)
    {

        return view("frontend.sorry");

    }



    /*========================== end function for not found response ======================*/
    /*========================== function for searching hotels ===========================*/
    public function search(Request $request)
    {
        $currentUrl = "";
        $search_name = $request->input("location_name");
        $flag = $request->input("sflag");
        $check = $request->input("checkin");
        $checko = $request->input("checkout");
        $checkInObj = new \DateTime($check);
        $checkOutObj = new \DateTime($checko);
        $checkin = $checkInObj->format('d-M-Y');
        $checkout = $checkOutObj->format('d-M-Y');
        $search2 = $request->input("id");

        /*=== store these values for future usage =======*/

        $request->session()->set("checkin",$check);
        $request->session()->set("checkout",$checko);
        $request->session()->set("num_rooms",$request->input("num_rooms"));
        $request->session()->set("nights",$request->input("nights"));
        $request->session()->set("destination",$search_name);
        $nights = $request->input("nights");
        $request->session()->set("code",$search2);
        $request->session()->set("srcFlage",$flag);
        /*=== end store these values for future usage =====*/
        /*====== search by location ========*/

        $hGroup = "";
        if($search2 != "" && $flag == "hotelgroupname")
        {
            $hGroup = DB::table("tblhotelgroupcodes")->select("hotelgroupcode","hotelgroupname")->where('hotelgroupcode',$search2)->first();
        }
        elseif($search2 == "")
        {
            $city = DB::table("hotel")->select("hotelCode","cityCode","stateCode","state","city")
                ->where('city','LIKE',$search_name.'%')
                ->orWhere('name','LIKE',$search_name.'%')
                ->orWhere('state','LIKE',$search_name.'%')->first();
        }
        else {
            $city = DB::table("hotel")->select("hotelCode","cityCode","stateCode","state","city")->where('hotelCode','=',$search2)->orWhere('cityCode','=',$search2)->first();
        }
        $Arr_age = array();
        $Arr_child = array();
        $Arr_adlt = array();
        $xml = "";
        $age = "";
        for($i = 1,$j =1; $i<= $request->input("num_rooms"); $i++,$j++) {
            $adlt ="adults_".$i;
            $Arr_adlt[] = $_GET[$adlt];
            $chlds = "children_".$j;
            $Arr_child[] = $_GET[$chlds];
            if($request->input("children_".$i) != 0 )
            {
                $age[$i] = "";
                $ch = $_GET["children_".$i];
                for($n = 1; $n <= $ch; $n++)
                {
                    $ages = "children_".$i."_age_".$n;
                    $Arr_age['room'.$i][] = $_GET[$ages];
                    $age[$i] .= '<childAge>'.$_GET[$ages].'</childAge>';
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

        if($hGroup == "")
        {
            $hGroups = "";
            if($city != null)
            {
                $currentUrl = url('cities/'.str_replace(' ','-',$city->city).'/'.$city->cityCode);
                $cCode = $city->cityCode;
                $hCode = $city->hotelCode;
            }
            else
            {
                $cCode = -1;
                $hCode = -1;
            }
            $newXml = '<?xml version="1.0" encoding="utf-8" ?>

			<availabilityRequest cancelpolicy = "Y" hotelfees="Y">

			<control>

			<userName>'.$this->APiUser.'</userName>

			<passWord>'.$this->ApiPassword.'</passWord>

			</control>

			<checkIn>'.$checkin.'</checkIn>

			<checkOut>'.$checkout.'</checkOut>

			<noOfRooms>'.$request->input("num_rooms").'</noOfRooms>

			<noOfNights>'.$nights.'</noOfNights>

			<country>US</country>';

            if($flag == 'city' || empty($flag))
            {
                $newXml .= '<city>'.$cCode.'</city>
				<hotelCodes>
				<hotelCode>0</hotelCode>
				</hotelCodes>';
            }
            elseif($flag == 'hotel')
            {
                $newXml .= '<hotelCodes>
				<hotelCode>'.$hCode.'</hotelCode>
				</hotelCodes>';
            }
            $newXml.='<roomsInformation>'.$xml.'</roomsInformation>
			</availabilityRequest>';
        }
        else
        {
            $hGroups = $hGroup->hotelgroupcode;
            $currentUrl = url('destinations/'.$hGroups.'/'.str_replace(' ','-',$search_name));
            $newXml = '<?xml version="1.0" encoding="utf-8" ?>
			<availabilityRequest cancelpolicy="Y" hotelfees="Y">
			<control>
			<userName>'.$this->APiUser.'</userName>
			<passWord>'.$this->ApiPassword.'</passWord>
			</control>
			<checkIn>'.$checkin.'</checkIn>
			<checkOut>'.$checkout.'</checkOut>
			<noOfRooms>'.$request->input("num_rooms").'</noOfRooms>
			<noOfNights>'.$nights.'</noOfNights>
			<country>US</country>
			<state/><hotelGroupCode>'.$hGroups.'</hotelGroupCode>
			<hotelCodes>
			<hotelCode>0</hotelCode>
			</hotelCodes>';
            $newXml .= '<roomsInformation>'.$xml.'</roomsInformation>

			</availabilityRequest>';
           
        }
        //$url = 'http://ws0.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do';
        $url = $this->provider . "bonotelapps/bonotel/reservation/GetAvailability.do";
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
        $request->session()->set("adults",array_sum($Arr_adlt));
        $request->session()->set("totalChild",array_sum($Arr_child));
        $request->session()->set("adultsArr",$Arr_adlt);
        $request->session()->set("childAges",$age);
        $request->session()->set("childAgesArr",$Arr_age);
        $_SESSION["childs"] =  count($Arr_child);
        $request->session()->set("childsArr",$Arr_child);
        if (count($errors) > 0)
        {
            $errors = json_decode(json_encode($errors), true);

            if($flag == 'hotelgroupname')
            {
                $message =  "Sorry about that. We couldn’t find any deals for selected <span>Area</span>";
            }
            else
            {
                if(empty($flag))
                {
                    $message =  "Sorry about that. We couldn’t find any deals for selected <span>City</span>";
                }
                else
                {
                    $message =  "Sorry about that. We couldn’t find any deals for selected <span>".$flag."</span>";

                }

            }

            $request->session()->set('msg', $message);

            return redirect()->to('no/inventory');
        }
        else
        {

            $finalResult = $rawData->xpath('//hotelList/hotel');
            $Harr = json_decode(json_encode($finalResult), true);
            $Harr = Helper::removeElementsFromHotelArray($Harr);

            if(count($Harr)==0){
                $request->session()->set('msg', 'All Rooms are on Request, Please search with differenct criteria');
                return redirect()->to('no/inventory');
            }
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

            $minHotArray = array();
            $maxPrice = 0;
            $minPrice = 0;
            foreach($Harr as $hotel) {
//                dd($hotel);
                $currMinDeal = array();
                $currMinDeal = $hotel["roomInformation"];

                $rateInfo = array();
                $minP = 0;
                $maxP = 0;
                foreach($currMinDeal as $deal){
                    if(!isset($deal['rateInformation'])){
                        $rateInfo[] = (int) str_replace(',', '',$currMinDeal['rateInformation']['totalRate']);
                    }
                    else{
                        $abc = $deal['rateInformation'];
                        $rateInfo[] = (int) str_replace(',', '', $abc['totalRate']);

                    }
                }

                $sortArray = sort($rateInfo);
                $minHotArray[] = ($rateInfo[0])/($nights);
                $hotel_code = $hotel["hotelCode"];
                $hCodes[] = $hotel_code;

                /*============================== rating section =================================*/

                $class = "";

                List($rating, $class, $starCount) = Helper::starChecker($hotel["starRating"], $starCount);

                /*============================== rating section =================================*/

                /*============================== making destinations section ========================*/
                    // dd('abc',$dests[$hotel["city"]]);
                if(isset($dests[$hotel["city"]])) {
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
            /*--------------Max and Min Price Setting variable-------*/
            $sortArr = sort($minHotArray);
            $maxPrice = $minHotArray[count($minHotArray)-1];
            $minPrice = $minHotArray[0];

            /*============== end loop to get stars and destinations count =======================*/

            $total_result = count($Harr);


//            $maxPrice = ceil($maxPrice/$nights);
//            $minPrice = ceil($minPrice/$nights);
            
            curl_close($ch);

            /*==== set search result in session for sort by function ====*/

            $request->session()->set("hGroup",$dests);

            $request->session()->set("allCodes",$hCodes);

            $request->session()->set("destCount",$destsCount);

            $request->session()->set("allDest",$allDest);

            $request->session()->set("checkArea",$hGroups);

            $request->session()->set('starCount',$starCount);

            $request->session()->set('hotels', $Harr);

            $request->session()->set("imgCount",0);

            $request->session()->set("reqFlag",1);

            $request->session()->set("filterChanged",-1);

            $request->session()->set("filterCombinations",array());

            /*==== set result result in session ====*/

            if($flag == 'hotel')

            {
                $nameSlug = str_replace(' ','-',$Harr[0]['name']);

                $stateSlug = str_replace(' ','-',$Harr[0]['stateProvince']);

                $citySlug = str_replace(' ','-',$Harr[0]['city']);

                $reUrl = url('deals').'/'.$stateSlug.'/'.$citySlug.'/'.$Harr[0]['hotelCode'];

                return redirect($reUrl);

            }

            else

            {

                return view('frontend.search',compact("hGroup","Harr","Harray","search_name",

                    "total_result","nights","facArr","facilityCount", "minPrice","starCount","dests","destsCount","allDest","facs","maxPrice","currentUrl"));

            }

        }

    }

    /*========================== end function for searching hotels =======================*/



    /*==================== function to change search from header ======================*/

    public function changeSearch(Request $request)
    {
        $currentUrl = "";
        $search_name = $request->input("location_name");
        $flag = $request->input("sflag");
        $check = $request->input("checkin");
        $checko = $request->input("checkout");
        $checkInObj = new \DateTime($check);
        $checkOutObj = new \DateTime($checko);
        $checkin = $checkInObj->format('d-M-Y');
        $checkout = $checkOutObj->format('d-M-Y');
        $search2 = $request->input("id");
        /*=== store these values for future usage =======*/
        $request->session()->set("checkin",$check);
        $request->session()->set("checkout",$checko);
        $request->session()->set("num_rooms",$request->input("total_rooms"));
        $request->session()->set("nights",$request->input("nights"));
        $request->session()->set("destination",$search_name);
        $nights = $request->input("nights");
        $request->session()->set("code",$search2);
        $request->session()->set("srcFlage",$flag);
        $request->session()->save();
        /*=== end store these values for future usage =====*/
        /*====== search by location ========*/
        $hGroup = "";
        if($search2 != "" && $flag == "hotelgroupname")
        {
            dd('here');
            $hGroup = DB::table("tblhotelgroupcodes")->select("hotelgroupcode","hotelgroupname")->where('hotelgroupcode',$search2)->first();



        }

        elseif($search2 == "")

        {

            $city = DB::table("hotel")->select("hotelCode","cityCode","stateCode","state","city")

                ->where('city','LIKE',$search_name.'%')

                ->orWhere('name','LIKE',$search_name.'%')

                ->orWhere('state','LIKE',$search_name.'%')->first();

        }

        else

        {

            $city = DB::table("hotel")->select("hotelCode","cityCode","stateCode","state","city")->where('hotelCode','=',$search2)

                ->orWhere('cityCode','=',$search2)->first();



        }




        $Arr_age = array();

        $Arr_child = array();

        $Arr_adlt = array();

        $xml = "";

        $age = "";

        for($i = 1,$j =1; $i<= $request->input("total_rooms"); $i++,$j++)

        {

            $adlt ="adults_".$i;

            $Arr_adlt[] = $_GET[$adlt];

            $chlds = "children_".$j;

            $Arr_child[] = $_GET[$chlds];


            if($request->input("children_".$i) != 0 )

            {

                $age[$i] = "";

                $ch = $_GET["children_".$i];

                for($n = 1; $n <= $ch; $n++)

                {

                    $ages = "children_".$i."_age_".$n;

                    $Arr_age['room'.$i][] = $_GET[$ages];

                    $age[$i] .= '<childAge>'.$_GET[$ages].'</childAge>';



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

        if($hGroup == "")

        {

            $hGroups = "";

            if($city != null)

            {

                $currentUrl = url('cities/'.str_replace(' ','-',$city->city).'/'.$city->cityCode);

                $cCode = $city->cityCode;

                $hCode = $city->hotelCode;

            }

            else

            {

                $cCode = -1;

                $hCode = -1;

            }

            $newXml = '<?xml version="1.0" encoding="utf-8" ?>

			<availabilityRequest cancelpolicy = "Y" hotelfees="Y">

			<control>

			<userName>'.$this->APiUser.'</userName>

			<passWord>'.$this->ApiPassword.'</passWord>

			</control>

			<checkIn>'.$checkin.'</checkIn>

			<checkOut>'.$checkout.'</checkOut>

			<noOfRooms>'.$request->input("total_rooms").'</noOfRooms>

			<noOfNights>'.$nights.'</noOfNights>

			<country>US</country>';

            if($flag == 'city' || empty($flag))

            {

                $newXml .= '<city>'.$cCode.'</city>

				<hotelCodes>

				<hotelCode>0</hotelCode>

				</hotelCodes>';

            }

            elseif($flag == 'hotel')

            {

                $newXml .= '<hotelCodes>

				<hotelCode>'.$hCode.'</hotelCode>

				</hotelCodes>';

            }

            $newXml.='<roomsInformation>'.$xml.'</roomsInformation>

			</availabilityRequest>';

        }

        else

        {

            $hGroups = $hGroup->hotelgroupcode;

            $currentUrl = url('cities/'.$hGroups.'/'.str_replace(' ','-',$search_name));

            $newXml = '<?xml version="1.0" encoding="utf-8" ?>

			<availabilityRequest cancelpolicy="Y" hotelfees="Y">

			<control>

			<userName>'.$this->APiUser.'</userName>

			<passWord>'.$this->ApiPassword.'</passWord>

			</control>

			<checkIn>'.$checkin.'</checkIn>

			<checkOut>'.$checkout.'</checkOut>

			<noOfRooms>'.$request->input("total_rooms").'</noOfRooms>

			<noOfNights>'.$nights.'</noOfNights>

			<country>US</country>

			<state/><hotelGroupCode>'.$hGroups.'</hotelGroupCode>

			<hotelCodes>

			<hotelCode>0</hotelCode>

			</hotelCodes>';

            $newXml .= '<roomsInformation>'.$xml.'</roomsInformation>

			</availabilityRequest>';

        }


        //$url = 'http://ws0.bonotel.com/bonotelapps/bonotel/reservation/GetAvailability.do';

        $url = $this->provider . 'bonotelapps/bonotel/reservation/GetAvailability.do';

        $request->session()->set("adults",array_sum($Arr_adlt));

        $request->session()->set("totalChild",array_sum($Arr_child));

        $request->session()->set("adultsArr",$Arr_adlt);

        $request->session()->set("childAges",$age);

        $request->session()->set("childAgesArr",$Arr_age);

        $request->session()->set("childsArr",$Arr_child);

        $request->session()->save();

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

            if($flag == 'hotelgroupname')

            {

                $message =  "Sorry about that. We couldn’t find any deals for selected <span>Area</span>";

            }

            else

            {

                if(empty($flag))

                {

                    $message =  "Sorry about that. We couldn’t find any deals for selected <span>City</span>";

                }

                else

                {

                    $message =  "Sorry about that. We couldn’t find any deals for selected <span>".$flag."</span>";

                }

            }

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
            $minPrice = 99999;


            $Harr = Helper::removeElementsFromHotelArray($Harr);


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

                    if(intval(str_replace(',','',$currMinDeal[0]['rateInformation']['totalRate'])) > $maxPrice)

                    {

                        $maxPrice = intval(str_replace(',','',$currMinDeal[0]['rateInformation']['totalRate']));

                    }
                    else{
                        if($minPrice > intval(str_replace(',','',$currMinDeal[0]['rateInformation']['totalRate']))){
                            $minPrice = intval(str_replace(',','',$currMinDeal[0]['rateInformation']['totalRate']));
                        }
                    }

                }

                else

                {

                    if(intval(str_replace(',','',$currMinDeal['rateInformation']['totalRate'])) > $maxPrice)

                    {

                        $maxPrice = intval(str_replace(',','',$currMinDeal['rateInformation']['totalRate']));

                    }
                    else{
                        if($minPrice > intval(str_replace(',','',$currMinDeal['rateInformation']['totalRate']))){
                            $minPrice = intval(str_replace(',','',$currMinDeal['rateInformation']['totalRate']));
                        }
                    }

                }

                $hotel_code = $hotel["hotelCode"];

                $hCodes[] = $hotel_code;

                /*============================== rating section =================================*/

                $class = "";

                List($rating, $class, $starCount) = Helper::starChecker($hotel["starRating"], $starCount);

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

            $facs = array();

            curl_close($ch);

            $maxPrice = ceil($maxPrice/$nights);

            $minPrice = ceil($minPrice/$nights);



            /*==== set search result in session for sort by function ====*/

            $request->session()->set("hGroup",$dests);

            $request->session()->set("allCodes",$hCodes);

            $request->session()->set("destCount",$destsCount);

            $request->session()->set("allDest",$allDest);

            $request->session()->set("checkArea",$hGroups);

            $request->session()->set('starCount',$starCount);

            $request->session()->set('hotels', $Harr);

            $request->session()->set("imgCount",0);

            $request->session()->set("reqFlag",1);

            $request->session()->set("filterChanged",-1);

            $request->session()->set("filterCombinations",array());

            /*==== set result result in session ====*/


            if($flag == 'hotel')

            {
                if(count($Harr)==0){
                    return redirect('no/inventory');
                }
                $nameSlug = str_replace(' ','-',$Harr[0]['name']);

                $stateSlug = str_replace(' ','-',$Harr[0]['stateProvince']);

                $citySlug = str_replace(' ','-',$Harr[0]['city']);

                $reUrl = url('deals').'/'.$stateSlug.'/'.$citySlug.'/'.$Harr[0]['hotelCode'];

                return redirect($reUrl);

            }

            else

            {

                return view('frontend.search',compact("hGroup","Harr","Harray","search_name",

                    "total_result","nights","facArr", "minPrice","facilityCount","starCount","dests","destsCount","allDest","facs","maxPrice","currentUrl"));

            }

        }

    }

    /*==================== end function to change search from header ==================*/



    /*============ function for getting chunk of 10 records with applied filters ============*/

    public function loadFilterRecords(Request $request){
        $filterFlag = $request->input('filters');
        $price  = $request->input('price');
        $amount = str_replace("$","",$price);
        $array = explode("-",$amount);
        $amt1 = $array[0];
        $amt2 = $array[1];
        $imgLimit = $request->session()->get('imgCount');
        $result = $request->session()->get('hotels');
        $flag = $request->session()->get('reqFlag');
        $nights = $request->session()->get('nights');
        if($filterFlag == 'true'){
            /*============ portion executed if filters applied ============*/
            $filterChanged = $request->session()->get("filterChanged");
            $filterComb = $request->session()->get('filterCombinations');
            $reside = "";
            $facs = $request->input('facss');
            $stars = $request->input('starss');
            $dests = $request->input('destss');
            if($facs == 0){
                $facs = array();
            }
            if($stars == 0){
                $stars = array();
            }
            if($dests == 0){
                $dests = array();
            }
            $startIndex;
            $signal = 0;
            $facCombFlag = '';
            for($c = 0; $c < count($filterComb); $c++){
				$facDiff = array_intersect($facs,$filterComb[$c]['facs']);
                $starDiff = array_intersect($stars,$filterComb[$c]['stars']);
                $destDiff = array_intersect($dests,$filterComb[$c]['dests']);
                if(count($facDiff) == count($facs) && count($facs) == count($filterComb[$c]['facs'])){
                    $reside .= "First";
                    if(count($starDiff) == count($stars) && count($stars) == count($filterComb[$c]['stars'])){
                        $reside .= "Second";
                        if(count($destDiff) == count($dests) && count($dests) == count($filterComb[$c]['dests'])){
                            $reside .= "Third";
                            $facCombFlag = $c;
                            $signal = 1;
                            break;
                        }
                    }
                }
            }
            if($signal > 0){
                if($filterChanged == $facCombFlag){
                    $startIndex = $filterComb[$facCombFlag]['lastIndex'];
                }elseif($filterChanged != $facCombFlag){
                    $filterComb[$facCombFlag]['lastIndex'] = 0;
                    $filterComb[$facCombFlag]['records'] = array();
                    $startIndex = $filterComb[$facCombFlag]['lastIndex'];
                }
            }else{
                $reside .= "In else part";
                $facCombFlag = count($filterComb);
                $filterComb[$facCombFlag]['facs'] = $facs;
                $filterComb[$facCombFlag]['stars'] = $stars;
                $filterComb[$facCombFlag]['dests'] = $dests;
                $filterComb[$facCombFlag]['identity'] = 'filter'.$facCombFlag;
                $filterComb[$facCombFlag]['records'] = array();
                $filterComb[$facCombFlag]['lastIndex'] = 0;
                $startIndex = $filterComb[$facCombFlag]['lastIndex'];
            }
            $request->session()->set("imgCount",0);
            $request->session()->save();
            if($flag == 0){
                return response()->json(['error'=>1,'msg'=>'','identity'=>$filterComb[$facCombFlag]['identity']]);
            }
            if($startIndex == count($result)){
                return response()->json(['error'=>1,'msg'=>'','identity'=>$filterComb[$facCombFlag]['identity']]);
            }
            $request->session()->set("reqFlag",0);
            $request->session()->set("filterChanged",$facCombFlag);
            $request->session()->save();
            $html = "";
            $hotelCount = 0;
            $lastIndexCounter = 0;
            if($startIndex > 0){
                $startIndex = $startIndex+1;
            }
            for($i = $startIndex; $i < count($result); $i++){
                $hotel_code = $result[$i]["hotelCode"];
                /*============================== rating section =================================*/
                List($class, $hotelRating, $rating) = Helper::starCheckerWithoutCounter($result[$i]["starRating"]);
                /*============================== end rating section ==============================*/
                /*======================== check if stars match with hotel rating =============*/
                if(count($stars) > 0){
                    if(!in_array($hotelRating,$stars)){
                        continue;
                    }
                }
                /*======================== end check if stars match with hotel rating =========*/
                /*================== check if destination match with hotel destination ========*/
                if(count($dests) > 0){
                    if(!in_array($result[$i]['city'],$dests)){
                        continue;
                    }
                }
                /*============== end check if destination match with hotel destination ========*/
                $curFacs = "";
                /*================== check if facilities match with hotel facilities ==========*/
                if(is_array($facs)){
                    if(count($facs) > 0){
                        DB::setFetchMode(\PDO::FETCH_ASSOC);
                        $checkValidFacs = DB::select("SELECT facility_name_code from tblfacilities WHERE hotel_id = '$hotel_code'");
                        if(count($checkValidFacs) > 0){
                            $checkValidFacs = array_column($checkValidFacs,'facility_name_code');
                            $facExist = array_intersect($facs,$checkValidFacs);
							if(count($facExist) == 0){
                                continue;
                            }
                        }
                        
                    }
                }
                /*================ end check if facilities match with hotel facilities ==========*/
                /*============================== images section =================================*/
                if(!isset($result[$i]['image'])){
                    $url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$hotel_code;
                    $ch1 = curl_init();
                    curl_setopt($ch1, CURLOPT_URL, $url1);
                    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch1, CURLOPT_POST, false);
                    curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
                    $result1 = curl_exec($ch1);
                    curl_close($ch1);
                    $hotelImages = @simplexml_load_string($result1);
                    if(isset($hotelImages->code)){
                        $result[$i]['image'] = (String)$result[$i]['thumbNailUrl'];
                    }else{
                        $result[$i]['image'] = (String)$hotelImages->hotel->images->image[0];    
                    }
                    /*$curImg = DB::table('hotel')->where('hotelCode',$hotel_code)->select('image')->first();
                    if(isset($curImg->image) && !empty($curImg->image)){
                        $result[$i]['image'] = (String)$curImg->image;
                    }else{
                        $result[$i]['image'] = (String)$result[$i]['thumbNailUrl'];
                    }*/
                    $imgName = array('image' => $result[$i]['image'], 'code' => (string)$result[$i]["hotelCode"]);
                    $request->session()->push('hImages',$imgName);
                }
                /*============================== images section =================================*/

                /*============================== rates section ==================================*/
                $currMinDeal = $result[$i]["roomInformation"];
				$rateInfo = array();
               	foreach($currMinDeal as $deal){
                   if(!isset($deal['rateInformation'])){
                       $rateInfo[] = (int) str_replace(',', '',$currMinDeal['rateInformation']['totalRate']);
                   }
                   else{
                       $abc = $deal['rateInformation'];
                       $rateInfo[] = (int) str_replace(',', '', $abc['totalRate']);
                   }
               }
			   $sortArray = sort($rateInfo);
               $newrate = $rateInfo[0];
                //$newrate = Helper::getCalculatedPrice($newrate);
                //if ((($amt1-1) <= ($newrate/$nights)) && ($amt2 >= ($newrate/$nights))){
                    $lastIndexCounter++;
                    $roomUrl = url("/rooms");
                    $bookUrl = url("/payment")."/".$hotel_code;
                    $cityClass = str_replace(" ","-",$result[$i]["city"]);
                    $html .= '<div class="hotel-desp-box common-srch satr-num-'.$hotelRating.' '.$curFacs.' '.$filterComb[$facCombFlag]['identity'].' '.$hotel_code.' '.$cityClass.'" id="s-'.$hotelRating.'"><a href="'.$roomUrl.'?hotel='.$hotel_code.'" class="desp-link"></a>'.
                        '<div class="hotel-img">'.
                        '<img style="height:200px; width:300px;" src="'.$result[$i]["image"].'">'.
                        '</div>'.
                        '<div class="hotel-desp">'.
                        '<span class="hotel-rating '.$class.' check-price">'.$rating.'</span>'.
                        '<div class="hotel-name-price">'.
                        '<div class="left-align">'.$result[$i]["name"]. '<span>'.$result[$i]["address"] .", ". $result[$i]["city"].
                        '</span></div>';
                    $html .= '<div class="right-align">$'.round($newrate/$nights,2).'<span>/night</span></div>'.
                        '</div>'.
                        '<p>';
                    $des = "";
                    if(isset($result[$i]["shortDescription"])) {
                        if(is_array($result[$i]["shortDescription"])){
                            $desc = implode(" ",$result[$i]["shortDescription"]);
                            @$pos=strpos($desc, ' ', 150);
                            $des = substr($desc,0,$pos )." "."...";
                        }else{
                            @$pos = strpos($result[$i]["shortDescription"], ' ', 150);
                            $des = substr($result[$i]["shortDescription"],0,$pos )." "."...";
                        }
                    }
                    $html .=  $des.'</p></a>'.
                        '<div class="hotel-links">'.
                        '<div class="left-align">'.
                        '<ul>'.
                        '<li>'.
                        '<a href="'.$roomUrl.'?hotel='.$hotel_code.'&section=overview">Overview</a>'.
                        '</li>'.
                        '<li>'.
                        '<a href="'.$roomUrl.'?hotel='.$hotel_code.'&section=rooms">Room Details</a>'.
                        '</li>'.
                        ' </ul>'.
                        '</div>'.
                        '<div class="right-align">'.
                        '<a href="'.$bookUrl.'">Book Rooms<i class="ion-ios-arrow-thin-right"></i></a>'.
                        '</div>'.
                        '</div>'.
                        '</div>'.
                        '<div class="clear"></div>'.
                        '</div>';
                    $filterComb[$facCombFlag]['lastIndex'] = $i;
                    $recordLen = count($filterComb[$facCombFlag]['records']);
                    $filterComb[$facCombFlag]['records'][$recordLen] = $result[$i];
                //}
        
                /*============================== making html section ================================*/

                if($lastIndexCounter == 15){

                    break;

                }

            }

            if($lastIndexCounter < 15)

            {

                $filterComb[$facCombFlag]['lastIndex'] = count($result);

            }

            $request->session()->set('hotels',$result);

            $request->session()->set('filterCombinations',$filterComb);

            $request->session()->set('reqFlag',1);

            $request->session()->save();

            return response()->json(['error'=>0,'msg'=>$html,'identity'=>$filterComb[$facCombFlag]['identity'],'count'=>$lastIndexCounter

                ,'lastindex'=>$filterComb[$facCombFlag]['lastIndex'],'startIndex'=>$startIndex,'reside'=>$reside]);

            /*============ end portion executed if filters applied =========*/

        }

        else

        {

            /*============ portion executed if filters not applied =========*/

            $hotelsLen = count($result);

            if($imgLimit >= $hotelsLen || $flag == 0)

            {

                return response()->json(['error'=>1,'msg'=>'','identity'=>'withoutFilter']);

            }

            $curLen = $imgLimit+15;

            if($curLen > $hotelsLen)

            {

                $diff = $hotelsLen-$imgLimit;

                $curLen = $imgLimit+$diff;

            }

            $request->session()->set("reqFlag",0);

            $request->session()->set("filterChanged",-1);

            $request->session()->set('imgCount',$curLen);

            $request->session()->save();

            $price  = $request->input('price');

            $amount = str_replace("$","",$price);


            $array = explode("-",$amount);



            $amt1 = $array[0];

            $amt2 = $array[1];

            $nights = $request->session()->get('nights');

            $html = "";

            for($i = $imgLimit; $i < $curLen; $i++)

            {

                $hotel_code = $result[$i]["hotelCode"];

                /*============================== rating section =================================*/


                List($class, $hotelRating, $rating) = Helper::starCheckerWithoutCounter($result[$i]["starRating"]);

                /*============================== rating section =================================*/



                /*============================== images section =================================*/

                if(!isset($result[$i]['image']))

                {

                    $url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$hotel_code;

                    $ch1 = curl_init();

                    curl_setopt($ch1, CURLOPT_URL, $url1);

                    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);

                    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

                    curl_setopt($ch1, CURLOPT_POST, false);

                    $result1 = curl_exec($ch1);

                    curl_close($ch1);

                    $hotelImages = @simplexml_load_string($result1);

                    if(isset($hotelImages->code))

                    {

                        $result[$i]['image'] = (String)$result[$i]['thumbNailUrl'];

                    }

                    else

                    {

                        $result[$i]['image'] = (String)$hotelImages->hotel->images->image[0];

                    }

                    /*$curImg = DB::table('hotel')->where('hotelCode',$hotel_code)->select('image')->first();

                    if(isset($curImg->image) && !empty($curImg->image))

                    {

                        $result[$i]['image'] = (String)$curImg->image;

                    }

                    else

                    {

                        $result[$i]['image'] = (String)$result[$i]['thumbNailUrl'];

                    }*/

                    $imgName = array('image' => $result[$i]['image'], 'code' => (string)$result[$i]["hotelCode"]);

                    $request->session()->push('hImages',$imgName);

                }

                /*============================== images section ====================================*/

                $newrate = 0;

                /*============================== rates section =====================================*/

                $currMinDeal = array();

                $currMinDeal = $result[$i]["roomInformation"];

                if(isset($currMinDeal[0]['roomCode']))

                {

                    uasort($currMinDeal, function ($a, $b) {

                        return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

                    });

                    $currMinDeal = array_values($currMinDeal);

                }

                if(empty($currMinDeal[0]["rateInformation"]["totalRate"]))

                {

                    $rate = $currMinDeal["rateInformation"]["totalRate"];

                    $newrate = str_replace( ',', '', $rate);

                }

                else

                {
                    $rate = Helper::getOptimalRate($currMinDeal);

                    $newrate = str_replace( ',', '', $rate );

                }

                /*============================== end rates section ==================================*/



                /*============================== add taxes by admin =================================*/

                $rate = Helper::Rate();

                $actualTax  = floatVal(str_replace(",","",$rate[0]->global_value));

                $actualDis  = floatVal(str_replace(",","",$rate[0]->global_discount));

                $rateType   = $rate[0]->global_type;



                if($rateType == 0)

                {

                    $taxAmount = floatVal(($newrate*$actualTax)/100);

                    $discountAmount = floatVal(($actualDis*$newrate)/100);

                    $totalRate = floatVal($totalRate+$taxAmount-$discountAmount);

                }

                elseif($rateType == 1)

                {

                    $totalRate = floatVal($newrate+$actualTax-$actualDis);

                }

                if($actualTax > 0)

                {

                    $totalRent = round($totalRate/$nights,2);

                }

                else

                {

                    $totalRent = round($newrate/$nights,2);

                }

                /*============================== making html section ================================*/

                if (($amt1 <= ($newrate/$nights)) && ($amt2 >= ($newrate/$nights)))

                {

                    $cityClass = str_replace(" ","-",$result[$i]["city"]);

                    $roomUrl = url("/rooms");

                    $bookUrl = url("/payment")."/".$result[$i]["hotelCode"];

                    $html .= '<div class="hotel-desp-box common-srch satr-num-'.$hotelRating.' '.' withoutFilter '.$result[$i]['hotelCode'].' '.$cityClass.'" id="s-'.$hotelRating.'"><a href="'.$roomUrl.'?hotel='.$hotel_code.'" class="desp-link"></a>'.

                        '<div class="hotel-img">'.

                        '<img style="height:200px; width:300px;" src="'.$result[$i]["image"].'">'.

                        '</div>'.

                        '<div class="hotel-desp">'.

                        '<span class="hotel-rating '.$class.' check-price">'.$rating.'</span>'.

                        '<div class="hotel-name-price">'.

                        '<div class="left-align">'.$result[$i]["name"]. '<span>'.$result[$i]["address"] .", ". $result[$i]["city"].

                        '</span></div>';

                    $html .= '<div class="right-align">$'.$totalRent.'<span>/night</span></div>'.

                        '</div>'.

                        '<p>';

                    $des = "";

                    if(isset($result[$i]["shortDescription"])) {

                        if(is_array($result[$i]["shortDescription"]))

                        {

                            $desc = implode(" ",$result[$i]["shortDescription"]);

                            @$pos=strpos($desc, ' ', 150);

                            $des = substr($desc,0,$pos )." "."...";

                        }

                        else

                        {

                            @$pos = strpos($result[$i]["shortDescription"], ' ', 150);

                            $des = substr($result[$i]["shortDescription"],0,$pos )." "."...";

                        }

                    }

                    $html .=  $des.'</p></a>'.

                        '<div class="hotel-links">'.

                        '<div class="left-align">'.

                        '<ul>'.

                        '<li>'.

                        '<a href="'.$roomUrl.'?hotel='.$result[$i]["hotelCode"].'&section=overview">Overview</a>'.

                        '</li>'.

                        '<li>'.

                        '<a href="'.$roomUrl.'?hotel='.$result[$i]["hotelCode"].'&section=rooms">Room Details</a>'.

                        '</li>'.

                        ' </ul>'.

                        '</div>'.

                        '<div class="right-align">'.

                        '<a href="'.$bookUrl.'">Book Room<i class="ion-ios-arrow-thin-right"></i></a>'.

                        '</div>'.

                        '</div>'.

                        '</div>'.

                        '<div class="clear"></div>'.

                        '</div>';

                }

                /*============================== making html section ================================*/

            }

            $request->session()->set('hotels',$result);

            $request->session()->set('reqFlag',1);

            $request->session()->save();

            return response()->json(['error'=>0,'msg'=>$html,'identity'=>'withoutFilter','lastindex'=>$curLen]);

            /*======== end portion executed if filters not applied =========*/

        }

    }

    /*========= end function for getting chunk of 10 records with applied filters ===========*/



    /*====================== function for sorting hotels by price =======================*/

    public function sortByPrice(Request $request)

    {

        $priceArr = array();

        $nights = $request->session()->get('nights');

        $price  = $request->input('price');

        $amount = str_replace("$","",$price);

        $array = explode("-",$amount);

        $amt1 = $array[0];

        $amt2 = $array[1];

        /*===================== get applied filters data ===============*/

        $filterFlag = $request->input('filters');

        $filterChanged = $request->session()->get("filterChanged");

        $filterComb = $request->session()->get('filterCombinations');

        $hotels = $request->session()->get('hotels');

        $identity = "";

        $counter = 0;

        if($filterChanged == -1)

        {

            $Hotels = $request->session()->get('hotels');

            $counter = $request->session()->get('imgCount');

            $Hotels = array_slice($Hotels,0,$counter);

            $identity = "withoutFilter";

        }

        elseif($filterChanged >= 0)

        {

            $Hotels = $filterComb[$filterChanged]['records'];

            $counter = count($Hotels);

            $identity = $filterComb[$filterChanged]['identity'];

        }

        $html = "";

        foreach($hotels as $key => $value)

        {

            $currMinDeal = array();

            $currMinDeal = $hotels[$key]["roomInformation"];

            if(isset($currMinDeal[0]['roomCode']))

            {

                uasort($currMinDeal, function ($a, $b) {

                    return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

                });

                $currMinDeal = array_values($currMinDeal);

            }

            if(empty($currMinDeal[0]["rateInformation"]["totalRate"]))

            {

                $priceArr[$key] = intval(str_replace(',','',$currMinDeal["rateInformation"]["totalRate"]));

            }

            else

            {

                $priceArr[$key] = intval(str_replace(',','',$currMinDeal[0]["rateInformation"]["totalRate"]));

            }

        }

        array_multisort($priceArr, SORT_ASC,$hotels);



        $Hotels = array_slice($hotels,0,$counter);

        $filterComb[$filterChanged]['records'] = $Hotels;

        $request->session()->set('filterCombinations', $filterComb);

        $request->session()->get('hotels', $hotels);

        $request->session()->save();


        for($i = 0; $i < $counter; $i++)

        {

            $newrates = 0;

            /*======= rates calculation for current looped hotel ===========*/

            $currMinDeal = array();

            $currMinDeal = $Hotels[$i]["roomInformation"];


            if(isset($currMinDeal[0]['roomCode']))

            {

                uasort($currMinDeal, function ($a, $b) {

                    return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

                });

                $currMinDeal = array_values($currMinDeal);

            }

            if(empty($currMinDeal[0]["rateInformation"]["totalRate"]))

            {

                $rate = $currMinDeal["rateInformation"]["totalRate"];

                $rates = str_replace( ',', '', $rate);

            }

            else

            {

                $rate = $currMinDeal[0]["rateInformation"]["totalRate"];

                $rates = str_replace( ',', '', $rate );

            }

            $newtotal = str_replace( ',', '', $rates);



            $newrates += $newtotal;

            if (($amt1 <= ($newrates/$nights)) && ($amt2 >= ($newrates/$nights)))

            {

                List($class, $hotelRating, $rating) = Helper::starCheckerWithoutCounter($Hotels[$i]["starRating"]);

                /*======= end check for current hotel star rating =========*/



                /*======= check for taxes if any by admin =========*/



                $totalRent = Helper::getCalculatedPrice($newrates);


                /*======= check for taxes if any by admin =========*/

                $cityClass = str_replace(" ","-",$Hotels[$i]["city"]);

                $roomUrl = url("/rooms");

                $bookUrl = url("/payment")."/".$Hotels[$i]["hotelCode"];

                $image = DB::table('hotel')->where('hotelCode', '=', $Hotels[$i]["hotelCode"])->first();
                if($image==null){
                    $image = $Hotels[$i]['thumbNailUrl'];
                }
                else{
                    $image = $image->image;
                }

                $html .= '<div class="hotel-desp-box common-srch satr-num-'.$hotelRating.' '.$identity.' '.$Hotels[$i]['hotelCode'].' '.$cityClass.'" id="s-'.$hotelRating.'"><a href="'.$roomUrl.'?hotel='.$Hotels[$i]["hotelCode"].'" class="desp-link"></a><div class="hotel-img">'.

                    '<img style="height:200px; width:300px;" src="'.$image.'">'.

                    '</div>'.

                    '<div class="hotel-desp">'.

                    '<span class="hotel-rating '.$class.' check-price">'.$rating.'</span>'.

                    '<div class="hotel-name-price">'.

                    '<div class="left-align">'.$Hotels[$i]["name"]. '<span>'.$Hotels[$i]["address"] .", ". $Hotels[$i]["city"].

                    '</span></div>';

                $html .= '<div class="right-align">$'.round($totalRent/$nights,2).'<span>/night</span></div>'.

                    '</div>'.

                    '<p>';

                $des = "";

                if(isset($Hotels[$i]["shortDescription"])) {

                    if(is_array($Hotels[$i]["shortDescription"]))

                    {

                        $desc = implode(" ",$Hotels[$i]["shortDescription"]);

                        @$pos=strpos($desc, ' ', 150);

                        $des = substr($desc,0,$pos )." "."...";

                    }

                    else

                    {

                        @$pos = strpos($Hotels[$i]["shortDescription"], ' ', 150);

                        $des = substr($Hotels[$i]["shortDescription"],0,$pos )." "."...";

                    }

                }

                $html .=  $des.'</p>'.

                    '<div class="hotel-links">'.

                    '<div class="left-align">'.

                    '<ul>'.

                    '<li>'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$i]["hotelCode"].'&section=overview">Overview</a>'.

                    '</li>'.

                    '<li>'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$i]["hotelCode"].'&section=rooms">Room Details</a>'.

                    '</li>'.

                    ' </ul>'.

                    '</div>'.

                    '<div class="right-align">'.

                    '<a href="'.$bookUrl.'">Book Room<i class="ion-ios-arrow-thin-right"></i></a>'.

                    '</div>'.

                    '</div>'.

                    '</div>'.

                    '<div class="clear"></div>'.

                    '</div>';

            }

        }

        if(!empty($html))

        {

            echo json_encode($html);

        }

        else

        {

            $html = '<h3>No record found</h3>';

            echo json_encode($html);

        }

        exit;

    }

    /*==================== end function for sorting hotels by price =====================*/



    /*==================== function for sorting hotels by stars rating ==================*/

    public function sortByStars(Request $request)

    {

        $starArr = array();

        $nights = $request->session()->get('nights');

        $price  = $request->input('price');

        $amount = str_replace("$","",$price);

        $array = explode("-",$amount);

        $amt1 = $array[0];

        $amt2 = $array[1];

        /*===================== get applied filters data ===============*/

        $filterFlag = $request->input('filters');

        $filterChanged = $request->session()->get("filterChanged");

        $filterComb = $request->session()->get('filterCombinations');

        $hotels = $request->session()->get('hotels');

        $identity = "";

        $counter = 0;

        if($filterChanged == -1)

        {

            $Hotels = $request->session()->get('hotels');

            $counter = $request->session()->get('imgCount');

            $Hotels = array_slice($Hotels,0,$counter);

            $identity = "withoutFilter";

        }

        elseif($filterChanged >= 0)

        {

            $Hotels = $filterComb[$filterChanged]['records'];

            $counter = count($Hotels);

            $identity = $filterComb[$filterChanged]['identity'];

        }

        /*===================== end get applied filters data =============*/

        foreach ($hotels as $key => $row)

        {

            $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$row["starRating"]);

            $starArr[$key] = $arr[0];

        }

        // echo "<pre>";

        // var_dump($Hotels);

        // var_dump($hotels);
        // exit;

        array_multisort($starArr,SORT_DESC,$hotels);

        $html = "";

        $Hotels = array_slice($hotels,0,$counter);

        $filterComb[$filterChanged]['records'] = $Hotels;

        $request->session()->set('filterCombinations', $filterComb);

        $request->session()->get('hotels', $hotels);

        $request->session()->save();

        for ($a = 0; $a < $counter; $a++)

        {

            $newrates = 0;

            /*======= rates calculation for current looped hotel ===========*/

            $currMinDeal = array();

            $currMinDeal = $Hotels[$a]["roomInformation"];

            if(isset($currMinDeal[0]['roomCode']))

            {

                uasort($currMinDeal, function ($a, $b) {

                    return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

                });

                $currMinDeal = array_values($currMinDeal);

            }

            if(empty($currMinDeal[0]["rateInformation"]["totalRate"]))

            {

                $rate = $currMinDeal["rateInformation"]["totalRate"];

                $rates = str_replace( ',', '', $rate);

            }

            else

            {

                $rate = $currMinDeal[0]["rateInformation"]["totalRate"];

                $rates = str_replace( ',', '', $rate );

            }

            $newtotal = str_replace( ',', '', $rates);

            $newrates += $newtotal;


            /*======= end rates calculation for current looped hotel ===========*/

            if (($amt1 <= ($newrates/$nights)) && ($amt2 >= ($newrates/$nights)))

            {

                List($class, $hotelRating, $rating) = Helper::starCheckerWithoutCounter($Hotels[$a]["starRating"]);

                /*======= end check for current hotel star rating =========*/



                /*======= check for taxes if any by admin =========*/

                $rate = Helper::Rate();

                $actualTax  = floatVal(str_replace(",","",$rate[0]->global_value));

                $actualDis  = floatVal(str_replace(",","",$rate[0]->global_discount));

                $rateType   = $rate[0]->global_type;



                $totalRent = Helper::getCalculatedPrice($newrates);


                /*======= end check for taxes if any by admin =========*/

                $cityClass = str_replace(" ","-",$Hotels[$a]["city"]);

                $roomUrl = url("/rooms");

                $bookUrl = url("/payment")."/".$Hotels[$a]["hotelCode"];

                $image = DB::table('hotel')->where('hotelCode', '=', $Hotels[$a]["hotelCode"])->first();
                if($image==null){
                    $image = $Hotels[$a]['thumbNailUrl'];
                }
                else{
                    $image = $image->image;
                }

                $html .= '<div class="hotel-desp-box common-srch satr-num-'.$hotelRating.' '.$identity.' '.$cityClass.'" id="s-'.$hotelRating.'">'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$a]["hotelCode"].'" class="desp-link"></a><div class="hotel-img">'.

                    '<img style="height:200px; width:300px;" src="'.$image.'">'.

                    '</div>'.

                    '<div class="hotel-desp">'.

                    '<span class="hotel-rating '.$class.' check-star">'.$rating.'</span>'.

                    ' <div class="hotel-name-price">'.

                    '<div class="left-align">'.$Hotels[$a]["name"]. '<span>'.$Hotels[$a]["address"] .", ". $Hotels[$a]["city"].

                    '</span></div>';

                $html .= '<div class="right-align">$'.round($totalRent/$nights,2).'<span>/night</span></div>'.

                    '</div>'.

                    '<p>';

                $des = "";

                if(isset($Hotels[$a]["shortDescription"])) {

                    if(is_array($Hotels[$a]["shortDescription"]))

                    {

                        $desc = implode(" ",$Hotels[$a]["shortDescription"]);

                        @$pos=strpos($desc, ' ', 150);

                        $des = substr($desc,0,$pos )." "."...";

                    }

                    else

                    {

                        @$pos = strpos($Hotels[$a]["shortDescription"], ' ', 150);

                        $des = substr($Hotels[$a]["shortDescription"],0,$pos )." "."...";

                    }

                }

                $html .=  $des.'</p>'.

                    '<div class="hotel-links">'.

                    '<div class="left-align">'.

                    '<ul>'.

                    '<li>'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$a]["hotelCode"].'&section=overview">Overview</a>'.

                    '</li>'.

                    '<li>'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$a]["hotelCode"].'&section=rooms">Room Details</a>'.

                    '</li>'.

                    ' </ul>'.

                    '</div>'.

                    '<div class="right-align">'.

                    '<a href="'.$bookUrl.'">Book Room<i class="ion-ios-arrow-thin-right"></i></a>'.

                    '</div>'.

                    '</div>'.

                    '</div>'.

                    '<div class="clear"></div>'.

                    '</div>';

            }

        }

        if(empty($html))

        {

            $html = '<h3>No record found</h3>';

            echo json_encode($html);

        }

        else

        {

            echo json_encode($html);

        }

        exit;

    }

    /*================== end function for sorting hotels by stars rating ===============*/



    /*===================== function for sorting hotels by names =======================*/

    public function sortByHotelNames(Request $request)

    {

        $nameArr = array();

        $nights = $request->session()->get('nights');

        $price  = $request->input('price');

        $amount = str_replace("$","",$price);

        $array = explode("-",$amount);

        $amt1 = $array[0];

        $amt2 = $array[1];

        /*===================== get applied filters data ===============*/

        $filterFlag = $request->input('filters');

        $filterChanged = $request->session()->get("filterChanged");

        $filterComb = $request->session()->get('filterCombinations');

        $hotels = $request->session()->get('hotels');

        $identity = "";

        $counter = 0;

        if($filterChanged == -1)

        {

            $Hotels = $request->session()->get('hotels');

            $counter = $request->session()->get('imgCount');

            $Hotels = array_slice($Hotels,0,$counter);

            $identity = "withoutFilter";

        }

        elseif($filterChanged >= 0)

        {

            $Hotels = $filterComb[$filterChanged]['records'];

            $counter = count($Hotels);

            $identity = $filterComb[$filterChanged]['identity'];

        }

        /*===================== end get applied filters data =============*/

        foreach($hotels as $key => $row)

        {

            $nameArr[$key] = $row["name"];

        }

        array_multisort($nameArr,SORT_ASC,$hotels);


        $Hotels = array_slice($hotels,0,$counter);

        $filterComb[$filterChanged]['records'] = $Hotels;

        $request->session()->set('filterCombinations', $filterComb);

        $request->session()->get('hotels', $hotels);

        $request->session()->save();

        $html = "";

        for($t = 0; $t < $counter; $t++)

        {

            $newrates = 0;

            /*======= rates calculation for current looped hotel ===========*/

            $currMinDeal = array();

            $currMinDeal = $Hotels[$t]["roomInformation"];

            if(isset($currMinDeal[0]['roomCode']))

            {

                uasort($currMinDeal, function ($a, $b) {

                    return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

                });

                $currMinDeal = array_values($currMinDeal);

            }

            if(empty($currMinDeal[0]["rateInformation"]["totalRate"]))

            {

                $rate = $currMinDeal["rateInformation"]["totalRate"];

                $rates = str_replace( ',', '', $rate);

            }

            else

            {

                $rate = $currMinDeal[0]["rateInformation"]["totalRate"];

                $rates = str_replace( ',', '', $rate );

            }

            $newtotal = str_replace( ',', '', $rates);

            $newrates += $newtotal;

            /*======= end rates calculation for current looped hotel ===========*/

            if (($amt1 <= ($newrates/$nights)) && ($amt2 >= ($newrates/$nights)))

            {

                List($class, $hotelRating, $rating) = Helper::starCheckerWithoutCounter($Hotels[$t]["starRating"]);

                /*======= end check for current hotel star rating =========*/



                /*======= check for taxes if any by admin =========*/

                $rate = Helper::Rate();

                $actualTax  = floatVal(str_replace(",","",$rate[0]->global_value));

                $actualDis  = floatVal(str_replace(",","",$rate[0]->global_discount));

                $rateType   = $rate[0]->global_type;

                $totalRent = Helper::getCalculatedPrice($newrates);

                /*======= check for taxes if any by admin =========*/

                $cityClass = str_replace(" ","-",$Hotels[$t]["city"]);

                $roomUrl = url("/rooms");

                $bookUrl = url("/payment")."/".$Hotels[$t]["hotelCode"];
                $image = DB::table('hotel')->where('hotelCode', '=', $Hotels[$t]["hotelCode"])->first();
                if($image==null){
                    $image = $Hotels[$t]['thumbNailUrl'];
                }
                else{
                    $image = $image->image;
                }
                $html .= '<div class="hotel-desp-box common-srch satr-num-'.$hotelRating.' '.$identity.' '.$cityClass.'" id="s-'.$hotelRating.'">'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$t]["hotelCode"].'" style="text-decoration:none" class="desp-link"></a>'.

                    '<div class="hotel-img">'.

                    '<img style="height:200px; width:300px;" src="'.$image.'">'.

                    '</div>'.

                    '<div class="hotel-desp">'.

                    '<span class="hotel-rating '.$class.' check-hotels">'.$rating.'</span>'.

                    ' <div class="hotel-name-price">'.

                    '<div class="left-align">'.$Hotels[$t]["name"]. '<span>'.$Hotels[$t]["address"] .", ".$Hotels[$t]["city"].

                    '</span></div>';

                $html .= '<div class="right-align">$'.round($totalRent/$nights,2).'<span>/night</span></div>'.

                    '</div>'.

                    '<p>';

                $des = "";

                if(isset($Hotels[$t]["shortDescription"])) {

                    if(is_array($Hotels[$t]["shortDescription"]))

                    {

                        $desc = implode(" ",$Hotels[$t]["shortDescription"]);

                        @$pos=strpos($desc, ' ', 150);

                        $des = substr($desc,0,$pos )." "."...";

                    }

                    else

                    {

                        @$pos = strpos($Hotels[$t]["shortDescription"], ' ', 150);

                        $des = substr($Hotels[$t]["shortDescription"],0,$pos )." "."...";

                    }

                }

                $html .=  $des.'</p>'.

                    '<div class="hotel-links">'.

                    '<div class="left-align">'.

                    '<ul>'.

                    '<li>'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$t]["hotelCode"].'&section=overview">Overview</a>'.

                    '</li>'.

                    '<li>'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$t]["hotelCode"].'&section=rooms">Room Details</a>'.

                    '</li>'.

                    ' </ul>'.

                    '</div>'.

                    '<div class="right-align">'.

                    '<a href="'.$bookUrl.'">Book Room<i class="ion-ios-arrow-thin-right"></i></a>'.

                    '</div>'.

                    '</div>'.

                    '</div>'.

                    '<div class="clear"></div>'.

                    '</div>';

                /*======= end check if current hotel price is within range selected by user =========*/

            }

        }

        if(empty($html))

        {

            $html = '<h3>No record found</h3>';

            echo json_encode($html);

        }

        else

        {

            echo json_encode($html);

        }

        exit;

    }

    /*===================== end function for sorting hotels by names ==================*/



    /*====== function for searching hotel selected from dropdown on search page =======*/

    public function filterByHotelName(Request $request)

    {

        $hotel =  $request->input("hotel");

        $nights = $request->session()->get('nights');

        $price  = $request->input('price');

        $amount = str_replace("$","",$price);

        $array = explode("-",$amount);

        $amt1 = $array[0];

        $amt2 = $array[1];

        /*===================== get applied filters data ===============*/

        $filterFlag = $request->input('filters');

        $filterChanged = $request->session()->get("filterChanged");

        $filterComb = $request->session()->get('filterCombinations');

        $hotels = $request->session()->get('hotels');



        if($filterChanged == -1)

        {

            $Hotels = $request->session()->get('hotels');

        }

        elseif($filterChanged >= 0)

        {

            $Hotels = $filterComb[$filterChanged]['records'];

        }

        /*===================== end get applied filters data ==========*/

        $html = "";

        $count = 0;

        for($m = 0; $m < count($Hotels); $m++)

        {

            /*======= check if current hotel name matches selected hotel name by user =========*/

            if (strpos(strtolower($Hotels[$m]["name"]), strtolower($hotel)) !== false)

            {

                /*============================== images section =================================*/

                if(!isset($Hotels[$m]['image']))

                {

                    $url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$Hotels[$m]["hotelCode"];

                    $ch1 = curl_init();

                    curl_setopt($ch1, CURLOPT_URL, $url1);

                    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);

                    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

                    curl_setopt($ch1, CURLOPT_POST, false);

                    $result1 = curl_exec($ch1);

                    curl_close($ch1);

                    $hotelImages = @simplexml_load_string($result1);

                    if(isset($hotelImages->code))

                    {

                        $Hotels[$m]['image'] = (String)$Hotels[$m]['thumbNailUrl'];

                    }

                    else

                    {

                        $Hotels[$m]['image'] = (String)$hotelImages->hotel->images->image[0];

                    }

                    $imgName = array('image' => $Hotels[$m]['image'], 'code' => (string)$Hotels[$m]["hotelCode"]);

                    $request->session()->push('hImages',$imgName);

                }

                /*============================== images section =================================*/

                $newrates = 0;

                /*======= rates calculation for current looped hotel ===========*/

                $currMinDeal = array();

                $currMinDeal = $Hotels[$m]["roomInformation"];

                if(isset($currMinDeal[0]['roomCode']))

                {

                    uasort($currMinDeal, function ($a, $b) {

                        return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

                    });

                    $currMinDeal = array_values($currMinDeal);

                }

                if(empty($currMinDeal[0]["rateInformation"]["totalRate"]))

                {

                    $rate = $currMinDeal["rateInformation"]["totalRate"];

                    $rates = str_replace( ',', '', $rate);

                }

                else

                {

                    $rate = $currMinDeal[0]["rateInformation"]["totalRate"];

                    $rates = str_replace( ',', '', $rate );

                }

                $newtotal = str_replace( ',', '', $rates);

                $newrates += $newtotal;

                /*======= rates calculation for current looped hotel ===========*/



                /*======= check if current hotel price is within range selected by user =========*/

                if (($amt1 <= ($newrates/$nights)) && ($amt2 >= ($newrates/$nights)))

                {

                    List($class, $hotelRating, $rating) = Helper::starCheckerWithoutCounter($Hotels[$m]["starRating"]);

                    /*======= end check for current hotel star rating =========*/



                    /*======= check for taxes if any by admin =========*/

                    $rate = Helper::Rate();

                    $actualTax  = floatVal(str_replace(",","",$rate[0]->global_value));

                    $actualDis  = floatVal(str_replace(",","",$rate[0]->global_discount));

                    $rateType   = $rate[0]->global_type;



                    if($rateType == 0)

                    {

                        $taxAmount = floatVal(($newrates*$actualTax)/100);

                        $discountAmount = floatVal(($actualDis*$newrates)/100);

                        $totalRate = floatVal($totalRate+$taxAmount-$discountAmount);

                    }

                    elseif($rateType == 1)

                    {

                        $totalRate = floatVal($newrates+$actualTax-$actualDis);

                    }

                    if($actualTax > 0)

                    {

                        $totalRent = round($totalRate/$nights,2);

                    }

                    else

                    {

                        $totalRent = round($newrates/$nights,2);

                    }

                    /*======= check for taxes if any by admin =========*/

                    $cityClass = str_replace(" ","-",$Hotels[$m]["city"]);

                    $roomUrl = url("/rooms");

                    $bookUrl = url("/payment")."/".$Hotels[$m]["hotelCode"];

                    $html .= '<div class="hotel-desp-box common-srch satr-num-'.$hotelRating.' '.$cityClass.'" id="s-'.$hotelRating.'">'.

                        '<a href="'.$roomUrl.'?hotel='.$Hotels[$m]["hotelCode"].'" class="desp-link"></a><div class="hotel-img">'.

                        '<img style="height:200px; width:300px;" src="'.$Hotels[$m]['image'].'">'.

                        '</div>'.

                        '<div class="hotel-desp">'.

                        '<span class="hotel-rating '.$class.'">'.$rating.'</span>'.

                        ' <div class="hotel-name-price">'.

                        '<div class="left-align">'.$Hotels[$m]["name"]. '<span>'.$Hotels[$m]["address"] .", ". $Hotels[$m]["city"].

                        '</span></div>';

                    $html .= '<div class="right-align">$'.$totalRent.'<span>/night</span></div>'.

                        '</div>'.

                        '<p>';

                    $des = "";

                    if(isset($Hotels[$m]["shortDescription"]))

                    {

                        if(is_array($Hotels[$m]["shortDescription"]))

                        {

                            $desc = implode(" ",$Hotels[$m]["shortDescription"]);

                            @$pos=strpos($desc, ' ', 150);

                            $des = substr($desc,0,$pos )." "."...";

                        }

                        else

                        {

                            @$pos = strpos($Hotels[$m]["shortDescription"], ' ', 150);

                            $des = substr($Hotels[$m]["shortDescription"],0,$pos )." "."...";

                        }

                    }

                    $html .=  $des.'</p>'.

                        '<div class="hotel-links">'.

                        '<div class="left-align">'.

                        '<ul>'.

                        '<li>'.

                        '<a href="'.$roomUrl.'?hotel='.$Hotels[$m]["hotelCode"].'&section=overview">Overview</a>'.

                        '</li>'.

                        '<li>'.

                        '<a href="'.$roomUrl.'?hotel='.$Hotels[$m]["hotelCode"].'&section=rooms">Room Details</a>'.

                        '</li>'.

                        ' </ul>'.

                        '</div>'.

                        '<div class="right-align">'.

                        '<a href="'.$bookUrl.'">Book Room<i class="ion-ios-arrow-thin-right"></i></a>'.

                        '</div>'.

                        '</div>'.

                        '</div>'.

                        '<div class="clear"></div>'.

                        '</div>';

                }

                /*======= end check if current hotel price is within range selected by user ========*/

                break;

            }

            /*======= end check if current hotel name matches selected hotel name by user =========*/

        }

        if(!empty($html))

        {

            echo json_encode($html);

        }

        else

        {

            $html = '<h3>No record found</h3>';

            echo json_encode($html);

        }

        exit;

    }

    /*==== end function for searching hotel selected from dropdown on search page =====*/



    /*==================== function to filter hotels by price range ===================*/

    public function filterByPrice(Request $request)

    {

        $nights = $request->session()->get('nights');

        $price  = $request->input('price');

        $amount = str_replace("$","",$price);

        $array = explode("-",$amount);

        $amt1 = $array[0];

        $amt2 = $array[1];

        /*===================== get applied filters data ===============*/

        $filterFlag = $request->input('filters');

        $filterChanged = $request->session()->get("filterChanged");

        $filterComb = $request->session()->get('filterCombinations');

        $hotels = $request->session()->get('hotels');

        $identity = "";

        $counter = 0;

        if($filterChanged == -1)

        {

            $Hotels = $request->session()->get('hotels');

            $counter = $request->session()->get('imgCount');

            $identity = "withoutFilter";

        }

        elseif($filterChanged >= 0)

        {

            $Hotels = $filterComb[$filterChanged]['records'];

            $counter = count($Hotels);

            $identity = $filterComb[$filterChanged]['identity'];

        }
        $totalHotels = count($hotels);
        /*===================== end get applied filters data ==========*/

        $html = "";

        $count = 0;

        $record = 0;

        $Hotels = $hotels;

        for($m = 0; $m < $totalHotels; $m++)

        {

            $newrates = 0;

            /*======= rates calculation for current looped hotel ===========*/

            $currMinDeal = array();

            $currMinDeal = $Hotels[$m]["roomInformation"];

            if(isset($currMinDeal[0]['roomCode']))

            {

                uasort($currMinDeal, function ($a,$b){

                    return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

                });

                $currMinDeal = array_values($currMinDeal);

            }

            if(empty($currMinDeal[0]["rateInformation"]["totalRate"]))

            {

                $rate = $currMinDeal["rateInformation"]["totalRate"];

                $rates = str_replace( ',', '', $rate);

            }

            else

            {

                $rate = Helper::getOptimalRate($currMinDeal);

                $rates = str_replace( ',', '', $rate );

            }

            $newtotal = str_replace( ',', '', $rates);

            $newrates += $newtotal;

            /*======= rates calculation for current looped hotel ===========*/



            /*======= check if current looped hotel within price range selected by user =========*/

            if (($amt1 <= ($newrates/$nights)) && ($amt2 >= ($newrates/$nights)))

            {

                /*============================== images section =================================*/

                if(!isset($Hotels[$m]['image']))

                {

                    $url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$Hotels[$m]["hotelCode"];

                    $ch1 = curl_init();

                    curl_setopt($ch1, CURLOPT_URL, $url1);

                    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);

                    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

                    curl_setopt($ch1, CURLOPT_POST, false);

                    $result1 = curl_exec($ch1);

                    curl_close($ch1);

                    $hotelImages = @simplexml_load_string($result1);

                    if(isset($hotelImages->code))

                    {

                        $Hotels[$m]['image'] = (String)$Hotels[$m]['thumbNailUrl'];

                    }

                    else

                    {

                        $Hotels[$m]['image'] = (String)$hotelImages->hotel->images->image[0];

                    }

                    $imgName = array('image' => $Hotels[$m]['image'], 'code' => (string)$Hotels[$m]["hotelCode"]);

                    $request->session()->push('hImages',$imgName);

                }

                /*============================== images section =================================*/
                List($class, $hotelRating, $rating) = Helper::starCheckerWithoutCounter($Hotels[$m]["starRating"]);

                /*======= end check for current hotel star rating =========*/



                /*======= check for taxes if any by admin =========*/

                $rate = Helper::Rate();

                $actualTax  = floatVal(str_replace(",","",$rate[0]->global_value));

                $actualDis  = floatVal(str_replace(",","",$rate[0]->global_discount));

                $rateType   = $rate[0]->global_type;



                if($rateType == 0)

                {

                    $taxAmount = floatVal(($newrates*$actualTax)/100);

                    $discountAmount = floatVal(($actualDis*$newrates)/100);

                    $totalRate = floatVal($totalRate+$taxAmount-$discountAmount);

                }

                elseif($rateType == 1)

                {

                    $totalRate = floatVal($newrates+$actualTax-$actualDis);

                }

                if($actualTax > 0)

                {

                    $totalRent = round($totalRate/$nights,2);

                }

                else

                {

                    $totalRent = round($newrates/$nights,2);

                }

                /*======= check for taxes if any by admin =========*/

                $cityClass = str_replace(" ","-",$Hotels[$m]["city"]);

                $roomUrl = url("/rooms");

                $bookUrl = url("/payment")."/".$Hotels[$m]["hotelCode"];

                $html .= '<div class="hotel-desp-box common-srch satr-num-'.$hotelRating.' '.$cityClass.' '.$identity.' " id="s-'.$hotelRating.'">'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$m]["hotelCode"].'" class="desp-link"></a><div class="hotel-img">'.

                    '<img style="height:200px; width:300px;" src="'.$Hotels[$m]['image'].'">'.

                    '</div>'.

                    '<div class="hotel-desp">'.

                    '<span class="hotel-rating '.$class.'">'.$rating.'</span>'.

                    ' <div class="hotel-name-price">'.

                    '<div class="left-align">'.$Hotels[$m]["name"]. '<span>'.$Hotels[$m]["address"] .", ". $Hotels[$m]["city"].

                    '</span></div>';

                $html .= '<div class="right-align">$'.$totalRent.'<span>/night</span></div>'.

                    '</div>'.

                    '<p>';

                $des = "";

                if(isset($Hotels[$m]["shortDescription"]))

                {

                    if(is_array($Hotels[$m]["shortDescription"]))

                    {

                        $desc = implode(" ",$Hotels[$m]["shortDescription"]);

                        @$pos=strpos($desc, ' ', 150);

                        $des = substr($desc,0,$pos )." "."...";

                    }

                    else

                    {

                        @$pos = strpos($Hotels[$m]["shortDescription"], ' ', 150);

                        $des = substr($Hotels[$m]["shortDescription"],0,$pos )." "."...";

                    }

                }

                $html .=  $des.'</p>'.

                    '<div class="hotel-links">'.

                    '<div class="left-align">'.

                    '<ul>'.

                    '<li>'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$m]["hotelCode"].'&section=overview">Overview</a>'.

                    '</li>'.

                    '<li>'.

                    '<a href="'.$roomUrl.'?hotel='.$Hotels[$m]["hotelCode"].'&section=rooms">Room Details</a>'.

                    '</li>'.

                    ' </ul>'.

                    '</div>'.

                    '<div class="right-align">'.

                    '<a href="'.$bookUrl.'">Book Room<i class="ion-ios-arrow-thin-right"></i></a>'.

                    '</div>'.

                    '</div>'.

                    '</div>'.

                    '<div class="clear"></div>'.

                    '</div>';

                $record++;

            }

            /*======= end check if current hotel price is within range selected by user ========*/

        }

        if(!empty($html))

        {

            echo json_encode($html);

        }

        else

        {

            $html = '<h3>No record found</h3>';

            echo json_encode($html);

        }

        exit;

    }

    /*==================== end function to filter hotels by price range ===============*/



    /*========= function to get hotel names for dropdown on search page ===============*/

    function getHotelNames(Request $request)

    {

        $resp = array();

        $Hotels = $request->session()->get('hotels');

        if($Hotels != null && count($Hotels) > 0)

        {

            $count = count($Hotels);

            for($i = 0; $i < $count; $i++)

            {

                $resp[] = $Hotels[$i]['name'];

            }

        }

        echo json_encode($resp);

        exit;

    }

    /*========= end function to get hotel names for dropdown on search page ==========*/



    /*========= function to get hotel facilities for search page =====================*/

    function getHotelFacs(Request $request)
    {
        dd('here');
        $html = "";
        $Hotels = $request->session()->get('hotels');
        $codes = $request->session()->get('allCodes');
        $count = count($Hotels);
        $codesList = implode(',',$codes);
        $allHotels = DB::select("SELECT DISTINCT(MFC.facility_name),MFC.facility_name_code from tblfacilities AS MFC where MFC.hotel_id IN (".$codesList.")");
        dd($allHotels);
        $html .='<h4>Amenities</h4>

		<div class="sidebar-content">

		<ul>

		<li>

		<div class="rating-check">

		<input type="checkbox" id="common-srch" class="fac-filter">

		<i class="icon ion-checkmark-round"></i>

		</div>

		<div class="rating-stars">

		<span>All amenities</span>

		</div>

		</li>';

        foreach($allHotels as $fac)

        {

            $curFac = $fac->facility_name_code;

            $facsCount = DB::select("SELECT COUNT(*) AS fac_count from tblfacilities AS FC WHERE FC.facility_name_code = '$curFac' AND FC.hotel_id IN (".$codesList.")");

            $html .='<li class="outer-fac-filter">

			<div class="rating-check">

			<input type="checkbox" class="fac-filter" id="'.$fac->facility_name_code.'">

			<i class="icon ion-checkmark-round"></i>

			</div>

			<div class="rating-stars">

			<span>'.$fac->facility_name.'</span>

			</div>

			<span class="star-qty" >'.$facsCount[0]->fac_count.'</span>

			</li>';

        }

        $html .='</ul>

        <a class="see-more" href="javascript:void(0)" id="more-facs"><i class="icon ion-ios-arrow-thin-down"></i>See more</a>

        <a class="see-more" href="javascript:void(0)" id="less-facs" style="display:none;">

        <i class="icon ion-ios-arrow-thin-up"></i>See less</a>

		</div>';

        echo json_encode($html);

        exit;

    }

    /*========= end function to get hotel facilities for search page =================*/

    /*========================== end search controller ===================================*/

}
