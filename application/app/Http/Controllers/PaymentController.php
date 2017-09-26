<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use Auth;

use App\Helpers\Helper;

class PaymentController extends Controller

{

    private $APiUser;

    private $ApiPassword;

    /*============================= controller constructor ===============================*/

    public function __construct()

    {

        //$this->APiUser = "luxVarTest_Xml";

        //$this->ApiPassword = "9kun3WP22K6GYuJ8";

        $this->APiUser = Helper::api()->api_user;

        $this->ApiPassword = Helper::api()->api_password;

    }

    /*=================== function for loading payment portal page =======================*/

    public function payment(Request $request){
        if(session()->get('userLogin') != 1 || empty(session()->get('userLogin'))){
            $request->session()->set('SM_redirect', 'room');
            $request->session()->set('SM_redirect_RD', \Request::fullUrl());
            $request->session()->save();
            return redirect()->to("userlogin/room");
        }
        $searchChild = $request->session()->get("childsArr");
        $searchAdult = $request->session()->get("adultsArr");
        $room_code = $request->input("room_code");
        $tempCodes = $request->input("room_code");
        $nights =   $request->session()->get('nights');
        $checkin =  $request->session()->get('checkin');
        $checkout = $request->session()->get('checkout');
        $adults =    0;
        $childs =   0;
        $hotels =   $request->session()->get("oneHotel");
        /*====== check if user has changed checkin, checkout on rooms details page =======*/
        if($request->session()->has('hotelcodeRoom')) {
            $hCode = $request->session()->get('hotelcodeRoom');
            if($hCode == $hotels['hotelCode']) {
                $nights = $request->session()->get('nightsRoom');
                $checkin = $request->session()->get('checkinRoom');
                $checkout = $request->session()->get('checkoutRoom');
            }
        }
        /*====== end check if user has changed checkin, checkout on rooms details page =======*/
        /*============== check for selected hotel room types to get allowed children =========*/
        $url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$hotels['hotelCode'];
        $result2 = @file_get_contents($url2);
        if(empty($result2)) {
            return redirect()->to("500");
        }
        $roomBeds = simplexml_load_string($result2);
        $roomTypes = array();
        foreach($roomBeds->hotel->room as $room) {
            $roomType = (string)$room->roomTypeID;
            foreach($room->bed as $bed) {
                $bedType = (string)$bed->bedTypeID;
                $roomTypes[$roomType][$bedType]['adults'] = $bed->adults;
                $roomTypes[$roomType][$bedType]['child'] = $bed->children;
            }
        }
        /*======== end check for selected hotel room types to get allowed children =============*/
        $url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$hotels['hotelCode'];
        $result1 = @file_get_contents($url1);
        if(empty($result1)){
            return redirect()->to("500");
        }
        $hotelPolicy = simplexml_load_string($result1);
        /*============================== images section =================================*/
        if(!isset($hotels['image'])) {
            if(isset($result2->code)) {
                $hotels['image'] = (String)$hotelPolicy['thumbNailUrl'];
            } else {
                $hotels['image'] = (String)$hotelPolicy->hotel->images->image[0];
            }
        }
        /*============================== images section ====================================*/
        $roomsArrCheck = $hotels['roomInformation'];
        $roomsArr = (object)$hotels['roomInformation'];
        $totalRate =  0;
        $tax   =     0;
        $grandTotal = 0;
        $hotel_fee = 0;
        $policyFrom = "";
        $policyTo = "";
        $amendmentType = "";
        $nextChildAdult = 0;
        $dispRooms = array();
        if(isset($roomsArrCheck[0]['roomCode'])) {
            /*======== if selected hotel has multiple rooms =============*/
            foreach($roomsArr as $hotel) {
                if(in_array($hotel["roomCode"],$tempCodes)) {
                    $index = array_search($hotel["roomCode"], $tempCodes);
                    unset($tempCodes[$index]);
                    $tempCodes = array_values($tempCodes);
                    if(isset($roomTypes[(string)$hotel['roomTypeCode']][(string)$hotel['bedTypeCode']]['child'])) {
                        $hotel['children'] = $roomTypes[(string)$hotel['roomTypeCode']][(string)$hotel['bedTypeCode']]['child'];
                        $childs += $roomTypes[(string)$hotel['roomTypeCode']][(string)$hotel['bedTypeCode']]['child'];
                    } else {
                        $hotel['children'] = 0;
                        $childs += 0;
                    }
                    $hotel['childrenSearch'] = $searchChild[$nextChildAdult];
                    $hotel['adultSearch'] = $searchAdult[$nextChildAdult];
                    $dispRooms[] = $hotel;
                    if(isset($hotel["roomBookingPolicy"]["amendmentType"])) {
                        $policyFrom  .=   $hotel["roomBookingPolicy"]["policyFrom"].",";
                        $policyTo 	.=   $hotel["roomBookingPolicy"]["policyTo"].",";
                        $amendmentType .= $hotel["roomBookingPolicy"]["amendmentType"].',';
                    } else {
                        foreach($hotel["roomBookingPolicy"] as $policy) {
                            $policyFrom  .=   $policy["policyFrom"].",";
                            $policyTo 	.=   $policy["policyTo"].",";
                            $amendmentType .= $policy["amendmentType"].',';
                        }
                    }
                    $adults += $hotel['stdAdults'];
                    $totalRate += str_replace(",","",$hotel["rateInformation"]["totalRate"]);
                    if(isset($hotel["rateInformation"]["hotelFees"]["hotelFee"]["feeTotal"])) {
                        if(is_array($hotel["rateInformation"]["hotelFees"]["hotelFee"]["salesTax"])){
                            $resortFee = '$'.$hotel["rateInformation"]["hotelFees"]["hotelFee"]["feeBasedOnValue"];
                        } else{
                            $resortFee = '$'.$hotel["rateInformation"]["hotelFees"]["hotelFee"]["feeBasedOnValue"] .' + '.$hotel["rateInformation"]["hotelFees"]["hotelFee"]["salesTax"].' % sales tax';
                        }
                        $hotel_fee =  intval(str_replace(",","",$hotel["rateInformation"]["hotelFees"]["hotelFee"]["feeTotal"])) * intval(count($room_code));
                    }
                    $tax      +=  str_replace(",","",$hotel["rateInformation"]["taxInformation"]["tax"][0]["taxAmount"]);
                    $nextChildAdult++;
                }
            }
            /*======== end if selected hotel has multiple rooms =============*/
        } else {
            /*======== if selected hotel has single room =============*/
            if(isset($roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'])) {
                $roomsArr->children = (string)$roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'];
                $childs += $roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'];
            } else {
                $roomsArr->children = (string)0;
                $childs += 0;
            }
            $roomsArr->childrenSearch = $searchChild[0];
            $roomsArr->adultSearch = $searchAdult[0];
            $dispRooms[0] = (array)$roomsArr;
            if(isset($roomsArr->roomBookingPolicy["policyFrom"])) {
                $policyFrom  .=   $roomsArr->roomBookingPolicy["policyFrom"].",";
                $policyTo .= 	  $roomsArr->roomBookingPolicy["policyTo"].",";
                $amendmentType .= $roomsArr->roomBookingPolicy["amendmentType"].",";
            } else {
                foreach($roomsArr->roomBookingPolicy as $policy) {
                    $policyFrom  .=   $policy["policyFrom"].",";
                    $policyTo .= 	  $policy["policyTo"].",";
                    $amendmentType .= $policy["amendmentType"].",";
                }
            }
            $adults += $roomsArr->stdAdults;
            $totalRate += str_replace(",","",$roomsArr->rateInformation["totalRate"]);
            if(isset($roomsArr->rateInformation["hotelFees"]["hotelFee"]["feeTotal"])) {
                $hotel_fee =  str_replace(",","",$roomsArr->rateInformation["hotelFees"]["hotelFee"]["feeTotal"]);
            }
            $tax      +=  str_replace(",","",$roomsArr->rateInformation["taxInformation"]["tax"][0]["taxAmount"]);
            /*======== end if selected hotel has single room =============*/
        }
        /*======= check for taxes if any by admin =========*/
        $rate = Helper::Rate();
        /*======= check for taxes if any by admin =========*/
        $totalrooms  = count($room_code);
        $image  =      $hotels["image"];
        $cityName =    $hotels["city"];
        $address =     $hotels["address"];
        $hotel = 	   $hotels["name"];
        $apiRoomRate = $totalRate;
        $endamount = round(Helper::getCalculatedPrice($totalRate) , 2);
        $totalRate = $endamount;
        $actualTax =     round(Helper::getTaxFromBackend($endamount) + $tax , 2);
//       $amountToPay = round($endamount + $actualTax, 2);
        $amountToPay = round( $actualTax, 2);
        $grandTotal = round($actualTax + $hotel_fee , 2);
        /*===== store values in session for future usage =====*/
        $request->session()->set("roomCodes",$room_code);
        $request->session()->set("amountToPay",$amountToPay);
        $request->session()->set("totalTax",$tax);
        $request->session()->set("roomCode",$room_code);
        $request->session()->set("hotelCode",$hotels["hotelCode"]);
        $request->session()->set("totalRooms",$totalrooms);
        $request->session()->put("HotelFee",$hotel_fee);
        $username = session()->get('userName');
        /*=== end store values in session for future usage ===*/
        $userLastName = DB::table('tblusers')->select('last_name')->where('first_name',$username)->first();
        return view('frontend.payment',compact("hotel", "resortFee","id",  "nights","checkin","checkout","adults","childs","cityName","dispRooms","address","image","hotel_fee","tax","percentTax","actualTax","totalRate","totalrooms","grandTotal","policyFrom","policyTo","amendmentType", "hotelPolicy","userLastName","apiRoomRate"));
    }

    /*=================== end function for loading payment portal page ===================*/
    /*=========== function for loading payment portal without room selection =================*/

    public function paymentPortalWithCheapest(Request $request,$id){
        // ===========check User is login or not to complete this process
        if(session()->get('userLogin') != 1 || empty(session()->get('userLogin'))){
            $request->session()->set('SM_redirect', $id);
            $request->session()->save();
            return redirect()->to("userlogin/".$id);
        }
        //============ complete checking process to check user is log in or not
        $searchChild = $request->session()->get("childsArr");
        $searchAdult = $request->session()->get("adultsArr");
        $room_code = array();
        $hotelCode = $id;
        $nights =   $request->session()->get('nights');
        $checkin =  $request->session()->get('checkin');
        $checkout = $request->session()->get('checkout');
        $hotelsAll = $request->session()->get('hotels');
        $username = session()->get('userName');
        $adults =    0;
        $childs =   0;
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
        $allHotels = $request->session()->get('hotels');
        $retHotel = '';
        foreach($allHotels as $hotel)
        {
            if($hotel['hotelCode'] == $hotelCode)
            {
                $retHotel = $hotel;
                break;
            }
        }
        $request->session()->set('oneHotel',$retHotel);
        $request->session()->save();
        $retHotel = $request->session()->get('oneHotel');
        /*====== check if user has changed checkin, checkout on rooms details page =======*/
        if($request->session()->has('hotelcodeRoom'))
        {
            $hCode = $request->session()->get('hotelcodeRoom');
            if($hCode == $retHotel['hotelCode']) {
                $nights = $request->session()->get('nightsRoom');
                $checkin = $request->session()->get('checkinRoom');
                $checkout = $request->session()->get('checkoutRoom');
            }
        }
        /*====== end check if user has changed checkin, checkout on rooms details page =======*/
        /*============================== images section =================================*/
        if(!isset($retHotel['image']))
        {
            if(isset($result2->code))
            {
                $retHotel['image'] = (String)$hotelPolicy['thumbNailUrl'];
            }
            else
            {
                $retHotel['image'] = (String)$hotelPolicy->hotel->images->image[0];
            }
        }
        /*============================== images section ====================================*/
        $request->session()->set("oneHotel",$retHotel);
        $request->session()->save();
        $hotels =   $request->session()->get("oneHotel");
        $roomsArrCheck = $hotels['roomInformation'];
        $roomsArr = (object)$hotels['roomInformation'];
        $totalRate =  0;
        $tax   =     0;
        $grandTotal = 0;
        $hotel_fee = 0;
        $policyFrom = "";
        $policyTo = "";
        $amendmentType = "";
        $dispRooms = array();
        $currentRoom = array();
        if(isset($roomsArrCheck[0]['roomCode']))
        {
            /*======== if selected hotel has multiple rooms =============*/
            uasort($roomsArrCheck, function ($a, $b) {
                return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

            });
            $roomsArrCheck = array_values($roomsArrCheck);
            for($blockNo = 1; $blockNo <= (intval($request->session()->get('num_rooms'))); $blockNo++)
            {
                $checkCounter = 0;
                foreach($roomsArrCheck as $room)
                {
                    if($room['roomNo'] == $blockNo)
                    {
                        $room_code[] = $room['roomCode'];
                        if(isset($roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child']))
                        {
                            $room['children'] = $roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child'];
                            $childs += $roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child'];
                        }
                        else
                        {
                            $room['children'] = 0;
                            $childs += 0;
                        }
                        $room['childrenSearch'] = $searchChild[$blockNo-1];
                        $room['adultSearch'] = $searchAdult[$blockNo-1];
                        $dispRooms[] = $room;
                        if(isset($room["roomBookingPolicy"]["amendmentType"]))
                        {
                            $policyFrom  .=   $room["roomBookingPolicy"]["policyFrom"].",";  // "2017-04-17,"
                            $policyTo 	.=   $room["roomBookingPolicy"]["policyTo"].",";     // 2017-12-16
                            $amendmentType .= $room["roomBookingPolicy"]["amendmentType"].',';  // Cancel
                        }
                        else
                        {
                            foreach($room["roomBookingPolicy"] as $policy)
                            {
                                $policyFrom  .=   $policy["policyFrom"].",";
                                $policyTo 	.=   $policy["policyTo"].",";
                                $amendmentType .= $policy["amendmentType"].',';
                            }
                        }
                        $adults += $room['stdAdults'];
                        $totalRate += str_replace(",","",$room["rateInformation"]["totalRate"]);

                        if(isset($room["rateInformation"]["hotelFees"]["hotelFee"]["feeTotal"]))
                        {
                            $hotel_fee =  str_replace(",","",$room["rateInformation"]["hotelFees"]["hotelFee"]["feeTotal"]);

                        }
                        $tax      +=  str_replace(",","",$room["rateInformation"]["taxInformation"]["tax"][0]["taxAmount"]);
                        /*======== end if selected hotel has multiple rooms =============*/
                        break;
                    }
                }
            }
        }
        else
        {
            /*======== if selected hotel has single room =============*/
            for($blockNo = 1;$blockNo <= ($request->session()->get('num_rooms')); $blockNo++)
            {
                $room_code[] = $roomsArr->roomCode;
                if(isset($roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child']))
                {
                    $roomsArr->children = (string)$roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'];
                    $childs += $roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'];
                }
                else
                {
                    $roomsArr->children = (string)0;
                    $childs += 0;
                }
                $roomsArr->childrenSearch = $searchChild[$blockNo-1];
                $roomsArr->adultSearch = $searchAdult[$blockNo-1];
                $dispRooms[] = (array)$roomsArr;
                if(isset($roomsArr->roomBookingPolicy["policyFrom"]))
                {
                    $policyFrom  .=   $roomsArr->roomBookingPolicy["policyFrom"].",";
                    $policyTo .= 	  $roomsArr->roomBookingPolicy["policyTo"].",";
                    $amendmentType .= $roomsArr->roomBookingPolicy["amendmentType"].",";
                }
                else
                {
                    foreach($roomsArr->roomBookingPolicy as $policy) {
                        $policyFrom .= $policy["policyFrom"] . ",";
                        $policyTo .= $policy["policyTo"] . ",";
                        $amendmentType .= $policy["amendmentType"] . ",";
                    }
                }
                $adults += $roomsArr->stdAdults;
                $totalRate += str_replace(",","",$roomsArr->rateInformation["totalRate"]);
                if(isset($roomsArr->rateInformation["hotelFees"]["hotelFee"]["feeTotal"]))
                {
                    $hotel_fee =  str_replace(",","",$roomsArr->rateInformation["hotelFees"]["hotelFee"]["feeTotal"]);
                }
                $tax  +=  str_replace(",","",$roomsArr->rateInformation["taxInformation"]["tax"][0]["taxAmount"]);
                /*======== end if selected hotel has single room =============*/
            }
        }
        $totalrooms  = count($room_code);
        $image  =      $hotels["image"];
        $cityName =    $hotels["city"];
        $address =     $hotels["address"];
        $hotel =        $hotels["name"];
        $apiRoomRate = $totalRate;
        $endamount = round(Helper::getCalculatedPrice($totalRate) , 2);
        $totalRate = $endamount;
        $actualTax =     round(Helper::getTaxFromBackend($endamount) + $tax , 2);
//        $amountToPay = round($endamount + $actualTax, 2);
        $amountToPay = round( $actualTax, 2);
        $grandTotal = round( $actualTax + $hotel_fee , 2);
        /*===== store values in session for future usage =====*/
        $request->session()->set("roomCodes",$room_code);
        $request->session()->set("amountToPay",$amountToPay);
        $request->session()->set("totalTax",$tax);
        $request->session()->set("roomCode",$room_code);
        $request->session()->set("hotelCode",$hotels["hotelCode"]);
        $request->session()->set("totalRooms",$totalrooms);
        $request->session()->put("HotelFee",$hotel_fee);
        /*=== end store values in session for future usage ===*/
        $resortFee  = 0;
        $userLastName = DB::table('tblusers')->select('last_name')->where('first_name',$username)->first();

            $urlforDirectPayment =  \Request::fullUrl();
            $request->session()->set('roomDetailDirectPayment',3);
            $request->session()->set('urlforDirectPayment',$urlforDirectPayment);
            $request->session()->set('rooomHotelCodeDirectPayment',$retHotel['hotelCode']);
        return view('frontend.payment',compact("hotel","nights","id","resortFee","checkin","checkout","adults","childs","cityName","dispRooms","address","image","hotel_fee","tax","percentTax","actualTax","totalRate","totalrooms","grandTotal","policyFrom","policyTo","amendmentType", 'userLastName',"apiRoomRate","$urlforDirectPayment"));

    }

    /*=================== end function for loading payment portal without room selection ===================*/



    /*============= function to make payment and place a pending booking request =========*/

    public function check_out(Request $request)
    {
        @session_start();
        $totalrooms = $request->session()->get("totalRooms");
        $nights =   $request->session()->get('nights');
        $checkin =  $request->session()->get('checkin');
        $checkout = $request->session()->get('checkout');
        $hotels =   $request->session()->get("oneHotel");
        $roomsArrCheck = $hotels['roomInformation'];
        $roomsArr = (object)$hotels['roomInformation'];
        $hotelFee = $request->session()->get("HotelFee");
        $hCode = $hotels["hotelCode"];
        if($request->session()->has('hotelcodeRoom')) {
            $hCode = $request->session()->get('hotelcodeRoom');
            if($hCode == $hotels['hotelCode'])
            {
                $nights = $request->session()->get('nightsRoom');
                $checkin = $request->session()->get('checkinRoom');
                $checkout = $request->session()->get('checkoutRoom');
            }
        }
        $checkInObj = new \DateTime($checkin);
        $checkOutObj = new \DateTime($checkout);
        $chk_in = $checkInObj->format('d-M-Y');
        $chk_out = $checkOutObj->format('d-M-Y');
        $traveldate = date("Y-m-d",strtotime($chk_in));
        $traveldateend = date("Y-m-d",strtotime($chk_out));
        $roomcodes = $request->session()->get("roomCode");
        $tempCodes = $request->session()->get("roomCode");
        $codes = DB::table("tblpending_requests")
            ->where([["chekIn","<=",$traveldate],["checkOut",">=",$traveldate]])
            ->orWhere([["chekIn","<=",$traveldateend],["checkOut",">=",$traveldateend]])
            ->select("roomCodes")->get();
        foreach($roomcodes as $roomCode ) {
            foreach($codes as $rcode)
            {
                $oneCode = explode(",",$rcode->roomCodes);
                foreach($oneCode as $cod)
                {
                    if($roomCode == $cod)
                    {
                        $html1 = "<ul style='color:white;padding:10px;border-radius:10px;background:red;'><li>Booking failed.</li><li>Error Message : room already booked at this date, please select another!</li></ul>";
                        $html['error'] = 1;
                        $html['message'] = $html1;
                        echo json_encode($html);
                        exit;
                    }
                }
            }
        }

        $all = $request->all();
        $apiRoomRate = $request->apiRoomRate;
        $apiRoomRate  = $apiRoomRate;

        $amount = $request->session()->get("amountToPay");
        $date = date("Y-m-d H:i:s");

        /*======= check for taxes if any by admin =========*/

        $rate = Helper::Rate();
        $actualTax  = floatVal(str_replace(",","",$rate[0]->global_value));

        $actualDis  = floatVal(str_replace(",","",$rate[0]->global_discount));

        $rateType   = $rate[0]->global_type;

        if($actualTax > 0)

        {

            if($rateType == 0)

            {

                $taxAmount = floatVal(($amount*$actualTax)/100);

                $discountAmount = floatVal(($actualDis*$amount)/100);

                $amount = floatVal($amount+$taxAmount-$discountAmount);

            }

            elseif($rateType == 1)

            {

                $amount = floatVal($amount+$actualTax-$actualDis);

            }

        }

        /*======= check for taxes if any by admin =========*/





        /*========== Braintree request to make payment =====*/

        \Stripe\Stripe::setApiKey("sk_test_5UDILxpSajcREGk3jpGpbD44");

        // Token is created using Stripe.js or Checkout!
        // Get the payment token submitted by the form:
        $token = $request->stripeToken;

        // Charge the user's card:
        $charge = \Stripe\Charge::create(array(
            "amount" => ($amount*100),
            "currency" => "usd",
            "description" => "Example charge",
            "source" => $token,
        ));

        if($charge->status == "succeeded")

        {

            /*========== check for room types of selected hotel ==========*/

            $url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$hotels['hotelCode'];

            $result2 = @file_get_contents($url2);

            if(empty($result2))

            {

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

            /*========= end check for room types of selected hotel ========*/

            $searchChild = $request->session()->get("childsArr");

            $searchAdult = $request->session()->get("adultsArr");

            $nRooms = count($roomcodes);

            $rType = "";

            $rAdults = "";

            $rChild = "";

            $rTax = "";

            $rNum = "";

            $rTypeCode = "";

            $bedTypeCode = "";

            $rPlanCode = "";

            $nextChildAdult = 0;

            if(isset($roomsArrCheck[0]['roomCode']))

            {

                /*========= check if selected hotel has multiple rooms ========*/

                foreach($roomsArr as $hotel)

                {

                    if(in_array($hotel["roomCode"],$tempCodes))

                    {

                        $index = array_search($hotel["roomCode"], $tempCodes);

                        unset($tempCodes[$index]);

                        $tempCodes = array_values($tempCodes);

                        $rType .= $hotel["roomType"].",";

                        if(isset($hotel["rateInformation"]["taxInformation"]["tax"]["0"]["taxAmount"]))

                        {

                            $rTax .=  $hotel["rateInformation"]["taxInformation"]["tax"]["0"]["taxAmount"].",";

                        }

                        else

                        {

                            $rTax .=  $hotel["rateInformation"]["taxInformation"]["tax"]["taxAmount"].",";

                        }

                        /*if(isset($roomTypes[(string)$hotel["roomTypeCode"]][(string)$hotel["bedTypeCode"]]['child']))

                        {

                            $rChild .= $roomTypes[(string)$hotel["roomTypeCode"]][(string)$hotel["bedTypeCode"]]['child'].",";

                        }

                        else

                        {

                            $rChild .= "0,";

                        }*/

                        if(empty($searchChild[$nextChildAdult]))

                        {

                            $rChild .= "0,";

                        }

                        else

                        {

                            $rChild .= $searchChild[$nextChildAdult].",";

                        }

                        $rNum .= $hotel["roomNo"].",";

                        $rTypeCode .= $hotel["roomTypeCode"].",";

                        $bedTypeCode .= $hotel["bedTypeCode"].",";

                        $rPlanCode .= $hotel["rateInformation"]["ratePlanCode"].",";

                        //$rAdults .= $hotel["stdAdults"].",";

                        $rAdults .= $searchAdult[$nextChildAdult].",";

                        $nextChildAdult++;

                    }

                }

                /*========= end check if selected hotel has multiple rooms ========*/

            }

            else

            {

                /*========= check if selected hotel has single room ========*/

                $rType .= $roomsArr->roomType.",";

                if(isset($roomsArr->rateInformation["taxInformation"]["tax"]["0"]["taxAmount"]))

                {

                    $rTax .=  $roomsArr->rateInformation["taxInformation"]["tax"]["0"]["taxAmount"].",";

                }

                else

                {

                    $rTax .=  $roomsArr->rateInformation["taxInformation"]["tax"]["taxAmount"].",";

                }

                /*if(isset($roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child']))

                {

                    $rChild .= $roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'].",";

                }

                else

                {

                    $rChild .= "0,";

                }*/

                if(empty($searchChild[$nextChildAdult]))

                {

                    $rChild .= "0,";

                }

                else

                {

                    $rChild .= $searchChild[$nextChildAdult].",";

                }

                $rNum .= $roomsArr->roomNo.",";

                $rTypeCode .= $roomsArr->roomTypeCode.",";

                $bedTypeCode .= $roomsArr->bedTypeCode.",";

                $rPlanCode .= $roomsArr->rateInformation["ratePlanCode"].",";

                //$rAdults .= $roomsArr->stdAdults.",";

                $rAdults .= $searchAdult[$nextChildAdult].",";

                $nextChildAdult++;

                /*========= end check if selected hotel has single room ========*/

            }

            $service = "bonotel";

            $module  = "Hotels";

            $rstatus = "Pending";

            $bookedby= "Customer";

            $operator= "123456";

            $cancel  = 0;

            $bookdate = date("Y-m-d H:i:s");

            $book_date = date("Y-m-d");



            $rcode = "";

            foreach($roomcodes as $roomCode )

            {

                $rcode .= $roomCode.",";

            }



            /*======= check for taxes if any by admin =========*/

            $rate = Helper::Rate();

            $actualTax  = floatVal(str_replace(",","",$rate[0]->global_value));

            $actualDis  = floatVal(str_replace(",","",$rate[0]->global_discount));

            $rateType   = $rate[0]->global_type;



            if($rateType == 0)

            {

                $taxAmount = floatVal(($amount*$actualTax)/100);

                $discountAmount = floatVal(($actualDis*$amount)/100);

                $withAdminTax = floatVal($amount+$taxAmount-$discountAmount);

                $addTax = $actualTax/100;

                $addDis = $actualDis/100;

                $perTax = $addTax-$addDis;

                $adminTax = $perTax."%";

            }

            elseif($rateType == 1)

            {

                $withAdminTax = floatVal($amount+$actualTax-$actualDis);

                $adTax = $actualTax - $actualDis;

                $adminTax= "$".$adTax;

            }

            /*======= end check for taxes if any by admin =========*/



            /*==== inserting complete data related to booking into db =====*/

            $uniqID = "guest-".uniqid();

            if(empty($request->session()->get('userLogin')) || $request->session()->get('userLogin') == 0)
            {
                /*==== inserting booking details into db (pending requests) =====*/

                $reqID = DB::table("tblpending_requests")->insertGetId(["adminTax"=>$adminTax,"user_id"=>$uniqID,"hotelCode"=>$hotels["hotelCode"],

                    "roomCodes"=>$rcode,"is_visitor"=>1,"chekIn"=>$traveldate,"is_read"=>0 ,"checkOut"=>$traveldateend,

                    "bookingDate"=>$book_date,"is_pending"=>1,"hotel_name"=>$hotels["name"],"no_rooms"=>$nRooms,"no_nights"=>$nights,

                    "room_types"=>$rType,"adults"=>$rAdults,"children"=>$rChild, "apiRoomRate"=>$apiRoomRate,"tax"=>$rTax,"total_amount"=>$amount,

                    "hote_fee"=>$hotelFee,"hotel_address"=>$hotels["address"],"hotel_city"=>$hotels["city"],

                    "hotel_state"=>$hotels["stateProvince"],"roomNo"=>$rNum,"roomTypeCode"=>$rTypeCode,"bedTypeCode"=>$bedTypeCode,

                    "ratePlanCode"=>$rPlanCode

                ]);

                /*==== end inserting booking details into db (pending requests) =====*/

                if($reqID)

                {
                    if(count($roomcodes) > 1){
                        $i = 1;
                        foreach($roomcodes as $x){
                            $userID = DB::table("traveler_info")->insertGetId(["request_id"=>$reqID,"traveler_title"=>$all["traveler_title".$i],"traveler_fname"=>$all["traveler_fname".$i],"traveler_lname"=>$all["traveler_lname".$i],"traveler_email"=>$all["traveler_email"]]);
                            $i++;
                        }
                    }
                    else{
                        $userID = DB::table("traveler_info")->insertGetId(["request_id"=>$reqID,"traveler_title"=>$all["traveler_title"],"traveler_fname"=>$all["traveler_fname"],"traveler_lname"=>$all["traveler_lname"],"traveler_email"=>$all["traveler_email"]]);
                    }

                    /*==== inserting billing details into db =====*/

                    $billingID = DB::table("billing_info")->insertGetId(["request_id"=>$reqID,"billing_country"=>$all["booking_country"]

                        ,"billing_address1"=>$all["booking_address1"],"billing_address2"=>$all["booking_address2"],"billing_city"=>$all["booking_city"]

                        ,"billing_state"=>$all["booking_state"],"billing_zipcode"=>$all["booking_zipcode"]

                    ]);

                    /*==== end inserting billing details into db =====*/



                    /*==== inserting payment details into db =====*/

                    $paymentID = DB::table("room_booking")->insert(["taxes"=>$rTax,"adminTaxes"=>$adminTax,"bookingID"=>$charge->id,

                        "request_id" => $reqID , "bookingType" => $charge->source->funding,

                        "currency" => $charge->currency, "amount" => $amount,"amountWithTax" => $amount,

                        "merchantAccountId"=>$charge->balance_transaction,"bookingDate"=>$date,

                        "cardType"=>$charge->source->brand,

                        "expirationYear"=>$charge->source->exp_year,

                        "expirationMonth"=>$charge->source->exp_month,

                        "customerLocation"=>($charge->source->address_city==null?"none":$charge->source->address_city)

                    ]);

                    /*==== end inserting payment details into db =====*/



                    /*==== inserting booking details into db =====*/

                    $bookingID = DB::table("tblbooking")->insertGetId(["booking_serviceprovider"=>$service,

                        "request_id"=>$reqID,"booking_email"=>$all["traveler_email"],"booking_module"=>$module,

                        "booking_status"=>$rstatus, "booking_traveldate"=>$traveldate,"booking_by"=>$bookedby,

                        "is_canceled"=>$cancel, "booking_date"=>$bookdate,"booking_traveldateEnd"=>$traveldateend,

                        "booking_operator_no"=>$operator,"roomeCode"=>$rcode,"hotelCode"=>$hCode,"hotelFee"=>$hotelFee

                    ]);

                    /*==== end inserting booking details into db =====*/

                    $html['error'] = 0;

                    $html['id'] = $reqID;

                    echo json_encode($html);

                    exit;

                }

            }

            elseif($request->session()->get('userLogin') == 1)

            {

                /*==== inserting booking details into db (pending requests)=====*/

                $userId = $request->session()->get('userId');

                $reqID = DB::table("tblpending_requests")->insertGetId(["adminTax"=>$adminTax,"user_id"=>$userId,"is_read"=>0

                    ,"hotelCode"=>$hotels["hotelCode"],"roomCodes"=>$rcode,"is_visitor"=>0,"chekIn"=>$traveldate,"checkOut"=>$traveldateend,

                    "bookingDate"=>$book_date,"is_pending"=>1,"hotel_name"=>$hotels["name"],"no_rooms"=>$nRooms,"no_nights"=>$nights,

                    "room_types"=>$rType,"adults"=>$rAdults,"children"=>$rChild,"apiRoomRate"=>$apiRoomRate,"tax"=>$rTax,"total_amount"=>$amount,

                    "hote_fee"=>$hotelFee,"hotel_address"=>$hotels["address"],"hotel_city"=>$hotels["city"],

                    "hotel_state"=>$hotels["stateProvince"],"roomNo"=>$rNum,"roomTypeCode"=>$rTypeCode,"bedTypeCode"=>$bedTypeCode,

                    "ratePlanCode"=>$rPlanCode

                ]);

                /*==== end inserting booking details into db (pending requests)=====*/



                if($reqID)

                {

                    /*==== inserting billing details into db =====*/

                    $billingID = DB::table("billing_info")->insertGetId(["request_id"=>$reqID,"billing_country"=>$all["booking_country"]

                        ,"billing_address1"=>$all["booking_address1"],"billing_address2"=>$all["booking_address2"],"billing_city"=>$all["booking_city"]

                        ,"billing_state"=>$all["booking_state"],"billing_zipcode"=>$all["booking_zipcode"]

                    ]);

                    /*==== end inserting billing details into db =====*/



                    /*==== inserting payment details into db =====*/

                    $paymentID = DB::table("room_booking")->insert(["taxes"=>$rTax,"adminTaxes"=>$adminTax,"bookingID"=>$charge->id,

                        "request_id"=>$reqID,"bookingType"=>$charge->source->funding,

                        "currency"=>$charge->currency, "amount"=>$amount,"amountWithTax"=>$amount,

                        "merchantAccountId"=>$charge->balance_transaction,"bookingDate"=>$date,

                        "cardType"=>$charge->source->brand,

                        "expirationYear"=>$charge->source->exp_year,

                        "expirationMonth"=>$charge->source->exp_month,

                        "customerLocation"=>($charge->source->address_city==null?"none":$charge->source->address_city)

                    ]);

                    /*==== end inserting payment details into db =====*/



                    /*==== inserting booking details into db =====*/

                    $bookingID = DB::table("tblbooking")->insertGetId(["booking_serviceprovider"=>$service,

                        "request_id"=>$reqID,"booking_email"=>$all["traveler_email"],"booking_module"=>$module,

                        "booking_status"=>$rstatus, "booking_traveldate"=>$traveldate,"booking_by"=>$bookedby,

                        "is_canceled"=>$cancel, "booking_date"=>$bookdate,"booking_traveldateEnd"=>$traveldateend,

                        "booking_operator_no"=>$operator,"roomeCode"=>$rcode,"hotelCode"=>$hCode,"hotelFee"=>$hotelFee

                    ]);

                    /*==== end inserting booking details into db =====*/

                    $html['error'] = 0;

                    $html['id'] = $reqID;

                    echo json_encode($html);

                    exit;

                }

            }

            else

            {

                $html1 = "<ul style='color:white;padding:10px;border-radius:10px;background:red;'><li>Booking failed.</li><li>Error Message : Unknown error please book again!</li></ul>";

                $html['error'] = 1;

                $html['message'] = $html1;

                echo json_encode($html);

                exit;

            }

            /*===close scop of success of braintree====*/

        }

        else

        {

            $html1 = "<ul style='color:white;padding:10px;border-radius:10px;background:red;'><li>Payment failed.</li><li>Error Message : </li></ul>";

            $html['error'] = 1;

            $html['message'] = $html1;

            echo json_encode($html);

            exit;

        }

    }

    /*========= end function to make payment and place a pending booking request =========*/



    /*============= function for redirecting to thank you page after booking =============*/

    public function thankYou(Request $request)

    {
        @session_start();

        $suer_id = $_GET["success"];

        $hotels =   $request->session()->get("oneHotel");

        $tempCodes =   $request->session()->get("roomCode");

        $searchChild = $request->session()->get("childsArr");

        $searchAdult = $request->session()->get("adultsArr");

        $roomsArrCheck = $hotels['roomInformation'];

        $roomsArr = (object)$hotels['roomInformation'];

        $nights = $request->session()->get('nights');

        $hCode = $hotels["hotelCode"];

        if($request->session()->has('hotelcodeRoom'))
        {
            $hCode = $request->session()->get('hotelcodeRoom');
            if($hCode == $hotels['hotelCode'])
            {
                $nights = $request->session()->get('nightsRoom');
            }
        }
        /*============= check for room types of selected hotel =============*/
        $url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/room/hotelCode/".$hCode;
        $result2 = @file_get_contents($url2);
        if(empty($result2))
        {
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

        /*============= end check for room types of selected hotel ==========*/
        $roomsDetail = array();
        $nextChildAdult = 0;
        if(isset($roomsArrCheck[0]['roomCode']))
        {
            /*========== check if selected hotel has multiple rooms =========*/

            $policyFrom = "";
            $policyTo   = "";
            $amendmentType = "";
            foreach($roomsArr as $hotel)
            {
                if(in_array($hotel["roomCode"],$tempCodes))
                {
                    $index = array_search($hotel["roomCode"], $tempCodes);
                    unset($tempCodes[$index]);
                    $tempCodes = array_values($tempCodes);
                    /*if(isset($roomTypes[(string)$hotel["roomTypeCode"]][(string)$hotel["bedTypeCode"]]['child']))

                    {

                        $hotel['child'] = $roomTypes[(string)$hotel["roomTypeCode"]][(string)$hotel["bedTypeCode"]]['child'];

                    }

                    else

                    {

                        $hotel['child'] = 0;

                    }*/

                    if(empty($searchChild[$nextChildAdult])) {
                        $hotel['child'] = 0;
                    }
                    else
                    {
                        $hotel['child'] = $searchChild[$nextChildAdult];
                    }
                    $hotel['stdAdults'] = $searchAdult[$nextChildAdult];
                    if(isset($hotel["roomBookingPolicy"]["policyFrom"]))
                    {
                        $policyFrom  .=   $hotel["roomBookingPolicy"]["policyFrom"].",";
                        $policyTo .= 	  $hotel["roomBookingPolicy"]["policyTo"].",";
                        $amendmentType .= $hotel["roomBookingPolicy"]["amendmentType"].",";

                    }
                    else
                    {
                        foreach($hotel["roomBookingPolicy"] as $policy)
                        {
                            $policyFrom  .=   $policy["policyFrom"].",";
                            $policyTo .= 	  $policy["policyTo"].",";
                            $amendmentType .= $policy["amendmentType"].",";
                        }

                    }

                    $roomsDetail[] = $hotel;

                    $nextChildAdult++;

                }

            }

            /*========== end check if selected hotel has multiple rooms =========*/

        }

        else
        {
            $policyFrom = "";
            $policyTo   = "";
            $amendmentType = "";
            /*========== check if selected hotel has single room =========*/

            /*if(isset($roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child']))

            {

                $hotel['child'] = $roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'];

            }

            else

            {

                $hotel['child'] = 0;

            }*/

            if(empty($searchChild[$nextChildAdult]))
            {
                $roomsArr->child = 0;
            }
            else
            {
                $roomsArr->child = $searchChild[$nextChildAdult];
            }
            $roomsArr->stdAdults = $searchAdult[$nextChildAdult];
            if(isset($roomsArr->roomBookingPolicy["policyFrom"]))
            {
                $policyFrom  .=   $roomsArr->roomBookingPolicy["policyFrom"];
                $policyTo .= 	  $roomsArr->roomBookingPolicy["policyTo"];
                $amendmentType .= $roomsArr->roomBookingPolicy["amendmentType"];
            }
            else
            {
                foreach($roomsArr->roomBookingPolicy as $policy)
                {
                    $policyFrom  .=   $policy["policyFrom"];
                    $policyTo .= 	  $policy["policyTo"];
                    $amendmentType .= $policy["amendmentType"];
                }
            }
            $roomsDetail[] = (array)$roomsArr;
            /*========== end check if selected hotel has single room =========*/

        }

        $policyInfo = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$hotels["hotelCode"];

        $result1 = @file_get_contents($policyInfo);

        if(empty($result1))

        {

            return redirect()->to("500");

        }

        $hotelPolicy = simplexml_load_string($result1);

        $travelDetail = "";

        $userDetail =   "";

        $mailName = "";

        $mailEmail = "";

        $email = new \stdClass();

        /*======= retrieving booking details from database ================*/

        if($request->session()->get('userLogin') == 1)
        {
            $userDetail = DB::table("tblpending_requests")->join("tblusers","tblusers.id","=","tblpending_requests.user_id")                    ->select("tblusers.*")
                    ->where('tblpending_requests.request_id',$suer_id)->first();
            $bookingDetail = DB::table("tblbooking")->select("*")->orderBy("booking_id","DESC")->where('request_id',$suer_id)                           ->first();
            $billingDetail = DB::table("billing_info")->select("*")->orderBy("billing_id","DESC")->where('request_id',$suer_id)->first();

                $room_booking = DB::table("room_booking")->select("*")->orderBy("roomBookId","DESC")->where('request_id',$suer_id)->first();
            if($userDetail == null)
            {
                $travelDetail = DB::table("traveler_info")->select("*")->where('request_id',$suer_id)->first();
                $email->name = $travelDetail->traveler_fname." ".$travelDetail->traveler_lname;
                $email->email = $travelDetail->traveler_email;
            }
            else
            {
                $email->name = $userDetail->first_name;
                $email->email = $userDetail->email;
            }
        }
        else

        {

            $travelDetail = DB::table("traveler_info")->select("*")->where('request_id',$suer_id)->first();
            $bookingDetail = DB::table("tblbooking")->select("*")->where('request_id',$suer_id)->first();
            $billingDetail = DB::table("billing_info")->select("*")->where('request_id',$suer_id)->first();
            $room_booking = DB::table("room_booking")->select("*")->where('request_id',$suer_id)->first();
            $email->name = $travelDetail->traveler_fname." ".$travelDetail->traveler_lname;
            $email->email = $travelDetail->traveler_email;
        }

        /*======= end retrieving booking details from database ============*/

        $rooms = $request->session()->get('roomCode');

        /*==== Mail function for users confirmation=====*/

        $roomInfo = DB::table("tblpending_requests")->select("*")->orderBy("request_id","DESC")->where('request_id',$suer_id)->first();

        $starRating = $hotels['starRating'];
        $realStar = Helper::starCheckerWithoutCounter($starRating);

        \Mail::send('mails.booking', array('roomInfo' => $roomInfo), function($message) use ($email)

        {

            $message->from('info@travellinked.com', 'Travel Linked');

            $message->to($email->email,$email->name)->subject('Booking request submited!');

        });

        /*==== End Mail function for users confirmation=====*/

        return view("frontend.confirm",compact("roomsDetail","room_booking","travelDetail","bookingDetail","billingDetail","hotels","rooms","nights","hotelPolicy","userDetail","policyFrom","policyTo","amendmentType","realStar"));

    }

    /*============ end function for redirecting to thank you page after booking ==========*/



    /*============= function for get extra taxes if any by admin ========================*/

    public function getTaxes()

    {

        $name = 'hotel';

        $dbObj = $this->configObj->connect();

        $query = $dbObj->prepare("SELECT * FROM tblGLOBALSETTING WHERE global_name = '$name'");

        $query->execute();

        $query->setFetchMode(PDO::FETCH_ASSOC);

        $result = $query->fetch();

        return $result;

    }

    /*============= end function for get extra taxes if any by admin ====================*/

}
