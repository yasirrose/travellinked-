<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use App\Deals;

use App\Destinations;

use App\Helpers\Helper;
use function MongoDB\BSON\toPHP;

class HomeController extends Controller

{

    private $APiUser;

    private $ApiPassword;

    /*======================================== controller constructor ===================================================*/

    public function __construct()

    {

        // $this->APiUser = "luxVarTest_Xml";

        // $this->ApiPassword = "9kun3WP22K6GYuJ8";

        $this->APiUser = Helper::api()->api_user;

        $this->ApiPassword = Helper::api()->api_password;

    }

    /*=========================================== function to load home page ============================================*/


    public function getTDeals(Request $request){


        $deals = array();
        $actDeals = DB::table('bonotel_deals')->take(21)->groupBy('HotelID')->inRandomOrder()->get();



        foreach ($actDeals as $deal) {

            $url1 = "http://api.bonotel.com/index.cfm/user/" . $this->APiUser . "/action/hotel/hotelCode/" . $deal->HotelID;

            /****************** curl request to get hotel images ******************/

            $ch1 = curl_init();

            curl_setopt($ch1, CURLOPT_URL, $url1);

            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);

            curl_setopt($ch1, CURLOPT_POST, false);


            $result1 = curl_exec($ch1);

            curl_close($ch1);

            $xmlhotels = @simplexml_load_string($result1);


            if (empty($xmlhotels)) {
                return redirect()->to("500");
            }
            if (count($deals) == 0){
                $images[] = Helper::getHdImages($xmlhotels->hotel->hotelCode, $this->APiUser);
                // $xmlhotels->hotel->images->hdImage = $images[0];
                $deals[] = $xmlhotels->hotel;
                $deals[0] = json_decode(json_encode((array)$deals[0]));

                $deals[0]->hdImage = $images[0];
            } else {
                $deals[] = $xmlhotels->hotel;
            }

        }
        $deals = array_values(array_filter($deals));


        $html = Helper::GetT20Deals($deals);
        $obj = array();
        $obj['status'] = true;
        $obj['html'] = $html;
        echo json_encode($obj);

    }
    public function cronWeekly(){

        $singledeal  = DB::table('bonotel_deals')->take(1)->where('cronw_job','=',0)->first();

        if(count($singledeal)<1){
            DB::table('bonotel_deals')->update(['cronw_job'=>0]);
        }
        $id = $singledeal->HotelID;

        $max = DB::table('bonotel_deals')->where('HotelID','=', $id)->update(['cronw_job' => 1]);

    }

    public function DailyCron(){
        DB::table('tblbooking')
            ->update(['crond_job'=>0]);

        $saveID  = array();
        $rec =   DB::table('tblbooking')->groupBy('hotelCode')->where([['booking_serviceprovider','=','bonotel'],['crond_job','=',0]])->orderBy('count', 'desc')->take(3)
            ->get(['hotelCode','booking_id', DB::raw('count(hotelCode) as count')]);


        if(count($rec)<3){
            DB::table('tblbooking')->update(['crond_job'=>0]);
        }
        for($x=0;$x<count($rec);$x++){
            $saveID[$x] = $rec[$x]->hotelCode;
        }

        $sas = DB::table('tblbooking')->whereIn('hotelCode', $saveID)->update(['crond_job' => 1]);
    }

    /*--------------------------Main Function for home Page ---------------- */
    public function index(Request $request){
        /*==== get most populor booked , destination and deals hotels from db====*/
        $activeDeals = DB::table('bonotel_deals')->take(21)->groupBy('HotelID')->inRandomOrder()->get();
        $mostPopulor = DB::table('tblbooking')->groupBy('hotelCode')->where([['booking_serviceprovider','=','bonotel'],['crond_job','=',0]])->orderBy('count', 'desc')->take(3)
            ->get(['hotelCode','booking_id', DB::raw('count(hotelCode) as count')]);
       $activeDests =  Destinations::where('status','=',1)->orderBy('updated_at', 'desc')->take(9)->get()->toArray();
        /*==== get most populor booked , destination and deals hotels from db====*/

        $Hotels = array();
        $deals = array();
        $dests = array();
        $layoutArr = array(
            array('style'=>'style="width:100%;height:280px;"','layout'=>'col-two-third','extra'=>''),
            array('style'=>'style="width:100%;height:580px;"','layout'=>'col-one-third','extra'=>'style="float:right;"'),
            array('style'=>'style="width:100%;height:280px;"','layout'=>'col-one-third','extra'=>''),
            array('style'=>'style="width:100%;height:280px;"','layout'=>'col-one-third','extra'=>''),
            array('style'=>'style="width:100%;height:280px;"','layout'=>'col-one-third','extra'=>'style="float:right;"'),
            array('style'=>'style="width:100%;height:280px;"','layout'=>'col-two-third','extra'=>''),
            array('style'=>'style="width:100%;height:280px;"','layout'=>'col-one-third','extra'=>'style="float:right;"'),
            array('style'=>'style="width:100%;height:280px;"','layout'=>'col-one-third','extra'=>''),
            array('style'=>'style="width:100%;height:280px;"','layout'=>'col-one-third','extra'=>'')
        );
        $horizflag = 1;
        $vertiflag = 1;
        $squarflag = 1;
        $squarpos = array(2,3,4,6,7,8);
        $horizpos = array(0,5);
        $vertipos = array(1);
        $allindexes = array(0,1,2,3,4,5,6,7,8);
        foreach($activeDests as $key => $dest) {
            $dest['hotelList'] = DB::table('tblhotelswithcodes')->join('hotel','tblhotelswithcodes.hotelid','=','hotel.hotelCode')
                ->select('hotel.hotelCode','hotel.city','hotel.state','hotel.name')
                ->where('hotelgroupcode',$dest['hotelgroupcode'])
                ->take(8)
                ->get();
            $width = 0;
            $height = 0;
            if(!empty($dest['hotelgroupimage'])) {
                list($width,$height) = getimagesize($dest['hotelgroupimage']);
            }
            if($width <= 450 && $height >= 550){
                if($vertiflag < 2) {
                    $dest['style'] = $layoutArr[$vertipos[$vertiflag-1]]['style'];
                    $dest['layout'] = $layoutArr[$vertipos[$vertiflag-1]]['layout'];
                    $dest['extra'] = $layoutArr[$vertipos[$vertiflag-1]]['extra'];
                    $dest['type'] = 'vertical';
                    $dest['pos'] = $vertipos[$vertiflag-1];
                    $index = array_search($key,$allindexes);
                    unset($allindexes[$index]);
                    $allindexes = array_values($allindexes);
                    $vertiflag++;
                } else {
                    if($squarflag < 7) {
                        $dest['type'] = 'square';
                        $dest['style'] = $layoutArr[$squarpos[$squarflag-1]]['style'];
                        $dest['layout'] = $layoutArr[$squarpos[$squarflag-1]]['layout'];
                        $dest['extra'] = $layoutArr[$squarpos[$squarflag-1]]['extra'];
                        $dest['pos'] = $squarpos[$squarflag-1];
                        $index = array_search($key,$allindexes);
                        unset($allindexes[$index]);
                        $allindexes = array_values($allindexes);
                        $squarflag++;
                    }
                }
            } elseif($width >= 550 && $height <= 350) {
                if($horizflag < 3) {
                    $dest['type'] = 'horizontal';
                    $dest['style'] = $layoutArr[$horizpos[$horizflag-1]]['style'];
                    $dest['layout'] = $layoutArr[$horizpos[$horizflag-1]]['layout'];
                    $dest['extra'] = $layoutArr[$horizpos[$horizflag-1]]['extra'];
                    $dest['pos'] = $horizpos[$horizflag-1];
                    $index = array_search($key,$allindexes);
                    unset($allindexes[$index]);
                    $allindexes = array_values($allindexes);
                    $horizflag++;
                } else {
                    if($squarflag < 7) {
                        $dest['type'] = 'square';
                        $dest['style'] = $layoutArr[$squarpos[$squarflag-1]]['style'];
                        $dest['layout'] = $layoutArr[$squarpos[$squarflag-1]]['layout'];
                        $dest['extra'] = $layoutArr[$squarpos[$squarflag-1]]['extra'];
                        $dest['pos'] = $squarpos[$squarflag-1];
                        $index = array_search($key,$allindexes);
                        unset($allindexes[$index]);
                        $allindexes = array_values($allindexes);
                        $squarflag++;
                    }
                }
            } elseif($width >= 1390 && $height <= 796){
                if($horizflag < 3) {
                    $dest['type'] = 'horizontal';
                    $dest['style'] = $layoutArr[$horizpos[$horizflag-1]]['style'];
                    $dest['layout'] = $layoutArr[$horizpos[$horizflag-1]]['layout'];
                    $dest['extra'] = $layoutArr[$horizpos[$horizflag-1]]['extra'];
                    $dest['pos'] = $horizpos[$horizflag-1];
                    $index = array_search($key,$allindexes);
                    unset($allindexes[$index]);
                    $allindexes = array_values($allindexes);
                    $horizflag++;
                } else {
                    if($squarflag < 7) {
                        $dest['type'] = 'square';
                        $dest['style'] = $layoutArr[$squarpos[$squarflag-1]]['style'];
                        $dest['layout'] = $layoutArr[$squarpos[$squarflag-1]]['layout'];
                        $dest['extra'] = $layoutArr[$squarpos[$squarflag-1]]['extra'];
                        $dest['pos'] = $squarpos[$squarflag-1];
                        $index = array_search($key,$allindexes);
                        unset($allindexes[$index]);
                        $allindexes = array_values($allindexes);
                        $squarflag++;
                    }
                }
            } else {
                if($squarflag < 7) {
                    $dest['type'] = 'square';
                    $dest['style'] = $layoutArr[$squarpos[$squarflag-1]]['style'];
                    $dest['layout'] = $layoutArr[$squarpos[$squarflag-1]]['layout'];
                    $dest['extra'] = $layoutArr[$squarpos[$squarflag-1]]['extra'];
                    $dest['pos'] = $squarpos[$squarflag-1];
                    $index = array_search($key,$allindexes);
                    unset($allindexes[$index]);
                    $allindexes = array_values($allindexes);
                    $squarflag++;
                }
            }
            $dests[] = $dest;
        }
        if($vertiflag < 2) {
            for($i = 0; $i<count($allindexes); $i++) {
                if(isset($dests[$allindexes[$i]])) {
                    if($vertiflag < 2) {
                        $dests[$allindexes[$i]]['style'] = $layoutArr[$vertipos[$vertiflag-1]]['style'];
                        $dests[$allindexes[$i]]['layout'] = $layoutArr[$vertipos[$vertiflag-1]]['layout'];
                        $dests[$allindexes[$i]]['extra'] = $layoutArr[$vertipos[$vertiflag-1]]['extra'];
                        $dests[$allindexes[$i]]['type'] = 'vertical';
                        $dests[$allindexes[$i]]['pos'] = $vertipos[$vertiflag-1];
                        $index = array_search($key,$allindexes);
                        unset($allindexes[$index]);
                        $allindexes = array_values($allindexes);
                        $vertiflag++;
                    }
                } else {
                    break;
                }
            }
        }
        if($horizflag < 3) {
            for($i = 0; $i<count($allindexes); $i++) {
                if(isset($dests[$allindexes[$i]])) {
                    if($horizflag < 3) {
                        $dests[$allindexes[$i]]['style'] = $layoutArr[$horizpos[$horizflag-1]]['style'];
                        $dests[$allindexes[$i]]['layout'] = $layoutArr[$horizpos[$horizflag-1]]['layout'];
                        $dests[$allindexes[$i]]['extra'] = $layoutArr[$horizpos[$horizflag-1]]['extra'];
                        $dests[$allindexes[$i]]['type'] = 'horizontal';
                        $dests[$allindexes[$i]]['pos'] = $horizpos[$horizflag-1];
                        $index = array_search($key,$allindexes);
                        unset($allindexes[$index]);
                        $allindexes = array_values($allindexes);
                        $horizflag++;
                    }
                } else {
                    break;
                }

            }
        }
        usort($dests, function($a, $b) {
            return $a['pos'] > $b['pos'];
        });
        /*===========Most Papouler Deals section=========== */
        foreach($mostPopulor as $Populor) {
            $url1 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$Populor->hotelCode;
            /****************** curl request to get hotel images ******************/
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_URL, $url1);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch1, CURLOPT_POST, false);
            curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
            $result1 = curl_exec($ch1);
            curl_close($ch1);
            $xmlhotels = @simplexml_load_string($result1);
            if(isset($xmlhotels->description)){
                if($xmlhotels->description == "The requested hotel was not found."){
                    continue;
                }
            }
            if(empty($xmlhotels)) {
                return redirect()->to("500");
            }
            foreach($xmlhotels as $xmlhotel) {
                $Hotels[] = $xmlhotel;
            }
        }
        //For single deal of the week
        $singDealx = 0;
        $singleDeal = DB::table('bonotel_deals')->take(1)->where('cronw_job','=',0)->first();
        $url2 = "http://api.bonotel.com/index.cfm/user/".$this->APiUser."/action/hotel/hotelCode/".$singleDeal->HotelID;
        /****************** curl request to get hotel images ******************/
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url2);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch1, CURLOPT_POST, false);
        $result2 = curl_exec($ch1);
        curl_close($ch1);
        $xmlhotels = @simplexml_load_string($result2);
        if(empty($xmlhotels)) {
            return redirect()->to("500");
        }
        if($singDealx == 0){
            $images[] = Helper::getHdImages($xmlhotels->hotel->hotelCode, $this->APiUser);
            $singDealx = $xmlhotels->hotel;
            $singDealx = json_decode(json_encode((array)$singDealx));
            $singDealx->hdImage = $images[0];
        } else{
            $singDealx = $xmlhotels->hotel;
        }
        //end the single deal of week
        foreach($activeDeals as $deal) {
            $url1 = "http://api.bonotel.com/index.cfm/user/" . $this->APiUser . "/action/hotel/hotelCode/" . $deal->HotelID;
            /****************** curl request to get hotel images ******************/
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_URL, $url1);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch1, CURLOPT_POST, false);
            $result1 = curl_exec($ch1);
            curl_close($ch1);
            $xmlhotels = @simplexml_load_string($result1);
            if(empty($xmlhotels)) {
                return redirect()->to("500");
            }
            if(count($deals)==0){
                $images[] = Helper::getHdImages($xmlhotels->hotel->hotelCode, $this->APiUser);
                // $xmlhotels->hotel->images->hdImage = $images[0];
                $deals[] = $xmlhotels->hotel;
                $deals[0] = json_decode(json_encode((array)$deals[0]));
                $deals[0]->hdImage = $images[0];
            } else{
                $deals[] = $xmlhotels->hotel;
            }
         }
        $deals = array_values(array_filter($deals));
        return view('frontend.home',compact("Hotels","deals","dests","singDealx"));
    }
    /*============================================ end function to load home page ===========================================*/



    /*================== function to retrive cities, hotels and hotel groups for autocomplete on home page ==================*/

    public function search_hotels(Request $request)

    {

        $search = $request->input("name");

        $hGroup = DB::table("tblhotelgroupcodes")->select("hotelgroupname","hotelgroupcode")

            ->where('hotelgroupname', 'LIKE', $search.'%')->get();

        $cities = DB::table("hotel")->select("city","cityCode")->where('city', 'LIKE', $search.'%')->groupBy("city")->get();

        $hotels = DB::table("hotel")->select("name","hotelCode")->where('name', 'LIKE', $search.'%')->get();



        $array = array();

        foreach($cities as $city)

        {

            $array[] = $city;

        }

        $array1 = array();

        foreach($hotels as $hotel)

        {

            $array1[] = $hotel;

        }

        $array2 = array();

        foreach($hGroup as $Group)

        {

            $array2[] = $Group;

        }

        $merge_arr = array_merge($array2,$array,$array1);

        echo json_encode($merge_arr);

        exit;

    }

    /*================= end function to retrive cities, hotels and hotel groups for autocomplete on home page ================*/



    /*================== function to check whether user selected a valid location or not while searching =====================*/

    public function checkLocation(Request $request)

    {

        $locationName = $request->input('location_name');

        $city  =	DB::table("hotel")->select("*")->where('city','LIKE',$locationName.'%')

            ->orWhere('name','LIKE',$locationName.'%')->orWhere('state','LIKE',$locationName.'%')->first();

        $hGroup  =	DB::table("tblhotelgroupcodes")->select("*")->where('hotelgroupname','LIKE',$locationName.'%')->first();



        if($city != NULL)

        {

            return json_encode(true);

        }

        else

        {

            if($hGroup != NULL)

            {

                echo  json_encode(true);

                exit;

            }

            return json_encode(false);

        }

    }

    /*================ end function to check whether user selected a valid location or not while searching =================*/

}
