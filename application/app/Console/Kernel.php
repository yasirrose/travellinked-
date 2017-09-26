<?php



namespace App\Console;


use DB;
use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;



class Kernel extends ConsoleKernel

{

    /**

     * The Artisan commands provided by your application.

     *

     * @var array

     */

    protected $commands = [

        // Commands\Inspire::class,

    ];

    /**

     * Define the application's command schedule.

     *

     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule

     * @return void

     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')        //          ->hourly();
      $schedule->call(function () {
          $saveID  = array();
            $rec =   DB::table('tblbooking')->groupBy('hotelCode')->where([['booking_serviceprovider','=','bonotel'],['crond_job','=',0]])->orderBy('count', 'desc')->take(3)
                ->get(['hotelCode','booking_id', DB::raw('count(hotelCode) as count')]);
            if(count($rec)<3){
                DB::table('tblbooking')->update(['crond_job'=>0]);
            }
            for($x=0;$x<count($rec);$x++){
                $saveID[$x] = $rec[$x]->booking_id;
            }
            DB::table('tblbooking')->whereIn('booking_id', $saveID)->update(['crond_job' => 1]);
      })->everyMinute();
    }


}