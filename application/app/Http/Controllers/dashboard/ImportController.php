<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests;
use App\Deals;


use Illuminate\Http\Request;

use DB;

use App\Http\Controllers\Controller;

use App\Hotelswithcodes;

class ImportController extends Controller

{

    /*============================= controller constructor ===============================*/

    public function __construct()

    {}



    /*============================= function to load import view ========================*/

    public function import(Request $request)

    {

        $title = 'Import Hotel Groups';
        $activeID = 'import';
        return view('dashboard.hotelGroup',compact('title','activeID'));

    }

    /*============================ end function to load import view =====================*/



    /*==================== function to import hotel group codes to db ===================*/

    public function importFile(Request $request)

    {

        $file = $request->file("hotelGroup");

        $path = $file->getPathName();

        /*====== check if codes exist =====*/

        $check = DB::table("tblhotelgroupcodes")->count();

        /*====== check if codes exist =====*/

        if($check > 0)

        {

            DB::table("tblhotelgroupcodes")->delete();

        }

        /*========= Check again if all record has been deleted ====*/

        $cAgain = DB::table("tblhotelgroupcodes")->count();

        /*========= Check again if all record has been deleted ====*/



        if($cAgain == 0)

        {

            /*====== Start importing file into db=====*/

            $handle = fopen($path, "r");

            $c = 0;

            while(($filesop = fgetcsv($handle, 1000, ",")) !== false)

            {

                $c = $c + 1;

                if($c > 0)

                {

                    DB::table("tblhotelgroupcodes")->insert(["hotelgroupcode"=>$filesop[0],"hotelgroupname"=>$filesop[1],

                        "hotelgroupdescriptions"=>$filesop[2]]);

                }

            }

            return redirect()->back()->with("success","Successfully updated ".$c." records");

        }

        else

        {

            return redirect()->back()->with("error","Unknown error occured, please try again");

        }

    }

    /*==================== end function to import hotel group codes to db ===================*/



    /*============================= function to load import view ========================*/

    public function importFacility(Request $request)

    {

        $title = 'Import Facilities';

        $activeID= 'facilities';

        return view('dashboard.facilitiesImport',compact('title','activeID'));

    }

    public function importDeals(Request $request){
        $title = 'Import Deals';

        return view('dashboard.dealsImport',compact('title'));
    }

    /*============================ end function to load import view =====================*/



    /*==================== function to import hotel facilities to db ===================*/

    public function importDealsFile(Request $request){


        $validator = \Validator::make($request->all(), [

            'deals' => 'required|mimes:csv,txt'

        ]);



        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput()->with('error','Please upload a valid csv file');

        }



        $file = $request->file("deals");

        $path = $file->getPathName();

        /*====== check if codes exist =====*/

        $check = 0;

        $check = DB::table("bonotel_deals")->count();


        /*====== check if codes exist =====*/

        if($check > 0)

        {

            DB::table("bonotel_deals")->truncate();

        }

        /*========= Check again if all record has been deleted ====*/

        $cAgain = DB::table("bonotel_deals")->count();

        /*========= Check again if all record has been deleted ====*/



        if($cAgain == 0)

        {

            /*====== Start importing file into db=====*/

            $handle = fopen($path, "r");


            $c = 0;

            while(($filesop = fgetcsv($handle, 9000, ",")) !== false)

            {
                $c = $c + 1;

                if($c > 1)

                {
                    $deal = new Deals;
                    $deal->HotelID = $filesop[0];
                    $deal->HotelName = $filesop[1];
                    $deal->roomTypeID = $filesop[2];
                    $deal->roomTypeName = $filesop[3];
                    $deal->DiscountBy = $filesop[4];
                    $deal->BookingDateStart = date('Y-m-d',  strtotime($filesop[5]));
                    $deal->BookingDateEnd = date('Y-m-d',  strtotime($filesop[6]));
                    $deal->StayDateStart = date('Y-m-d',  strtotime($filesop[7]));
                    $deal->StayDateEnd = date('Y-m-d',  strtotime($filesop[8]));
                    $deal->IsSupplementary = $filesop[9];
                    $deal->freeNightResortFee = $filesop[10];
                    $deal->NightsRequired = $filesop[11];
                    $deal->FreeNights = $filesop[12];
                    $deal->MaxFreeNights = $filesop[13];
                    $deal->CustomerSpecialCode = $filesop[14];
                    $deal->BlackoutDates = $filesop[15];
                    $deal->PromtionID = $filesop[16];
                    $deal->DayInclude = $filesop[17];
                    $deal->ApplyFreeNightsOnLastStayDays = $filesop[18];
                    $deal->PromotionType = $filesop[19];
                    $deal->DiscountFormat = $filesop[20];
                    $deal->DiscountValue = $filesop[21];
                    $deal->CombinabilityWithFreeNight = $filesop[22];
                    $deal->RFStartDate = date('Y-m-d',  strtotime($filesop[23]));
                    $deal->RFEndDate = date('Y-m-d',  strtotime($filesop[24]));
                    $deal->RFRoomTypeID = $filesop[25];
                    $deal->RFRoomTypeName = $filesop[26];
                    $deal->RFBedTypeID = $filesop[27];
                    $deal->RFBedTypeName = $filesop[28];
                    $deal->RFRateTypeID = $filesop[29];
                    $deal->RFRateTypeName = $filesop[30];
                    $deal->RFResortFeeAmt = $filesop[31];

                    $deal->save();


                    // DB::table("tblfacilities")->insert(["hotel_id"=>$filesop[0],"hotel_name"=>$filesop[1],"facility_group"=>$filesop[2],

                    // 				"facility_group_code"=>$filesop[3],"facility_name"=>$filesop[4],"facility_name_code"=>$filesop[5]]);

                }

            }

            return redirect()->back()->with("success","Successfully updated ".$c." records");

        }

        else

        {

            return redirect()->back()->with("error","Unknown error occured, please try again");

        }
    }

    public function importFacilityFile(Request $request)

    {

        $validator = \Validator::make($request->all(), [

            'facility' => 'required|mimes:csv,txt'

        ]);



        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput()->with('error','Please upload a valid csv file');

        }



        $file = $request->file("facility");

        $path = $file->getPathName();

        /*====== check if codes exist =====*/

        $check = DB::table("tblfacilities")->count();

        /*====== check if codes exist =====*/

        if($check > 0)

        {

            DB::table("tblfacilities")->truncate();

        }

        /*========= Check again if all record has been deleted ====*/

        $cAgain = DB::table("tblfacilities")->count();

        /*========= Check again if all record has been deleted ====*/



        if($cAgain == 0)

        {

            /*====== Start importing file into db=====*/

            $handle = fopen($path, "r");

            $c = 0;

            while(($filesop = fgetcsv($handle, 1000, ",")) !== false)

            {

                $c = $c + 1;

                if($c > 1)

                {

                    DB::table("tblfacilities")->insert(["hotel_id"=>$filesop[0],"hotel_name"=>$filesop[1],"facility_group"=>$filesop[2],

                        "facility_group_code"=>$filesop[3],"facility_name"=>$filesop[4],"facility_name_code"=>$filesop[5]]);

                }

            }

            return redirect()->back()->with("success","Successfully updated ".$c." records");

        }

        else

        {

            return redirect()->back()->with("error","Unknown error occured, please try again");

        }

    }

    /*==================== end function to import hotel facilities to db ===================*/



    /*=============== function to load import hotels and codes view ========================*/

    public function importHotelsWithCodes(Request $request)

    {

        $title = 'Import Hotels With Codes';

        $activeID = 'groupcodes';

        return view('dashboard.hotelswithcodes',compact('title','activeID'));

    }

    /*============================ end function to load import view =====================*/



    /*==================== function to import hotels and codes to db ===================*/

    public function updateHotelsWithCodes(Request $request)

    {

        $validator = \Validator::make($request->all(), [

            'hotelcodes' => 'required|mimes:csv,txt'

        ]);



        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput()->with('error','Please upload a valid csv file');

        }



        $file = $request->file("hotelcodes");

        $path = $file->getPathName();

        Hotelswithcodes::truncate();

        $handle = fopen($path, "r");

        $c = 0;

        while(($filesop = fgetcsv($handle, 1000, ",")) !== false)

        {

            $c = $c + 1;

            if($c > 1)

            {

                $curObj = new Hotelswithcodes;

                $curObj->hotelgroupcode = $filesop[0];

                $curObj->hotelid = $filesop[1];

                $curObj->hotelname = $filesop[2];

                $curObj->save();

            }

        }

        return redirect()->back()->with("success","Successfully updated ".$c." records");

    }

    /*==================== end function to import hotel facilities to db ===================*/



    /*==================== end of ImportController ==============================================*/

}

