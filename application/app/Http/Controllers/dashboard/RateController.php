<?php
namespace App\Http\Controllers\dashboard;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Rate;
use App\Http\Controllers\Controller;
class RateController extends Controller
{
    /*============================= controller constructor ===============================*/
    public function __construct()
    {
    }

    /*========================== function to load b2cmarkup view ========================*/
    public function b2cMarkup(Request $request)
    {
        $rate = DB::table('tblglobalsetting')
            ->select('*')
            ->where('global_id','=',2)->first();
        $activeID = "rate";
        $title = 'B2C Markup';
        return view('dashboard.rate', compact("newRate", "title", "activeID","rate"));
    }
    /*========================= end function to load b2cmarkup view =====================*/

    /*========================= function to update b2cmarkup values =====================*/
    public function saveMarkup(Request $request, $id)
    {
         

         $status_field = $request->status_field;
         $margin_status = $request->marg;
         $margin = $request->margin;
         $markup_status = $request->mar;
        $markup = $request->markup;
        $tax_status =$request->t;
        $tax = $request->tax;
        $discount_status = $request->dis;
        $discount = $request->discount;


        if($status_field=='markup'){
            $status = 'markup';

        }
       elseif($status_field=='margin'){

            $status ='margin';
       }

        $rate = Rate::find($id);
        $rate->margin_status= $margin_status;
        $rate->margin= $margin;
        $rate->markup_status=$markup_status;
        $rate->markup=$markup;
        $rate->tax_status=$tax_status;
        $rate->tax=$tax;
        $rate->discount_status =$discount_status;
        $rate->discount = $discount;
        $rate->status = $status;
        $rate->save();
        return redirect('admin/b2c_markup');

//        $Rate = DB::table('tblglobalsetting')
//            ->where('global_id', $id)
//            ->update(['margin_status' => $margin_status, 'margin' => $margin, 'markup_status' => $markup_status, 'markup' => $markup,
//                'tax_status' => $tax_status, 'tax' => $tax, 'discount_status' => $discount_status, 'discount' => $discount,'status' =>$status
//            ]);


    }

    /*========================= end function to update b2cmarkup values ==================*/
    /*========================= end RateController ===========================================*/
}
