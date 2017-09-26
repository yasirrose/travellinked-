<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests;

use Illuminate\Http\Request;

use DB;

use App\Http\Controllers\Controller;

class DashboardController extends Controller

{

    /*============================= controller constructor ===============================*/

    public function __construct()

    {}

    /*============================= function to load admin dashboard =====================*/

    public function index(Request $request)

    {

        $title = 'Dashboard';
        $activeID = 'dashboard';

        return view('dashboard.dashboard',compact('title','activeID'));

    }

    public function create_customer(Request $request){


        $title = 'Customer';
        $activeID = "customers";

        return view('dashboard.create_customer',compact('title','activeID'));

    }

    /*============================= end function to load admin dashboard =================*/



    /*============================= function to get sidenav search =====================*/

    public function get_sidenav_search(Request $request)

    {

        $name = $request->input('params');

        $bookLike1 = '';

        $bookLike2 = '';

        $userLike = '';

        $allHtml = '';

        $usersHtml = '';

        $bookingHtml = '';

        if(!empty($name))

        {

            $bookLike1 .= 'AND (tp.total_amount LIKE "%'.$name.'%" OR tp.request_id LIKE "%'.$name.'%" OR u.first_name LIKE "%'.$name.'%" OR u.last_name LIKE "%'.$name.'%")';

            $bookLike2 .= 'AND (tp.total_amount LIKE "%'.$name.'%" OR tp.request_id LIKE "%'.$name.'%" OR t.traveler_fname LIKE "%'.$name.'%" OR t.traveler_lname LIKE "%'.$name.'%")';

            $nameArr = explode(' ',$name);

            $name1 = $name;

            $name2 = $name;

            if(count($nameArr) > 1)

            {

                $name1 = $nameArr[0];

                $name2 = $nameArr[1];

            }



            $userLike = 'first_name LIKE "%'.$name1.'%" OR last_name LIKE "%'.$name2.'%" OR email LIKE "%'.$name.'%" OR id LIKE "%'.$name.'%"';

        }

        $regBooking = DB::select("SELECT tp.is_visitor,tp.request_id,tp.is_pending,tp.bookingDate,tp.user_id,u.first_name as name,u.email FROM tblpending_requests tp  INNER JOIN tblusers u ON tp.user_id = u.id WHERE tp.is_visitor = 0 $bookLike1 ORDER BY tp.request_id DESC");



        $gestBooking = DB::select("SELECT tp.is_visitor,tp.request_id,tp.is_pending,tp.bookingDate,tp.user_id,CONCAT(t.traveler_fname,' ',t.traveler_lname) as name,t.traveler_email FROM tblpending_requests tp INNER JOIN traveler_Info t ON tp.request_id = t.request_id WHERE tp.is_visitor = 1 $bookLike2 ORDER BY tp.request_id DESC");



        $users = DB::select("SELECT id, first_name,last_name,email,img_url FROM tblusers WHERE $userLike");

        /*==== merge both table data====*/

        $collection = collect($regBooking);

        $merged = $collection->merge($gestBooking);

        $allBooking = $merged->all();

        if(count($allBooking) > 0 || count($users) > 0)

        {

            if(count($allBooking) > 0)

            {

                foreach($allBooking as $book)

                {

                    $bookingHtml .= '<div class="searched-item">

                        <div class="searched-item-avatar">

                            <a href="#">

                                <i class="icon ion-ios-bookmarks"></i>

                            </a>

                        </div>

                        <div class="searched-item-content">

                            <h2><a href="'.url('admin/booking/detail/'.$book->request_id).'">Booking #'.$book->request_id.'</a></h2>

                            <div class="searched-booking">

                                <p>Placed by <a href="#">'.$book->name.'</a> '.$book->bookingDate.'</p>

                            </div>

                        </div>

                    </div>';

                }

                $allHtml .= $bookingHtml;

            }

            else

            {

                $bookingHtml = '<div class="no-search-box">

							<div class="no-search-content">

								<h3>No results for “'.$name.'”</h3>

								<p>Refine your search terms or try searching something else.</p>

							</div>

							<div class="recent-searches">

							</div>

						</div>';

            }



            if(count($users) > 0)

            {

                foreach($users as $user)

                {

                    $currLinks = '';

                    $currBookings = DB::select("SELECT tp.request_id,tp.user_id FROM tblpending_requests tp WHERE tp.user_id = $user->id");

                    if(count($currBookings) > 0)

                    {

                        foreach($currBookings as $link)

                        {

                            $currLinks .= '<a href="'.url('admin/booking/detail/'.$link->request_id).'">#'.$link->request_id.'</a>';

                        }

                    }

                    else

                    {

                        $currLinks = '<a href="javascript:void(0)">No bookings</a>';

                    }

                    $usersHtml .= '<div class="searched-item">

					<div class="searched-item-avatar">

					<a href="#">';

                    if(!empty($user->img_url))

                    {

                        $usersHtml .= '<img src="'.$user->img_url.'" style="border-radius:50%;width:50px;height:48px;">';

                    }

                    else

                    {

                        $usersHtml .= '<i class="fa fa-user"></i>';

                    }

                    $usersHtml .= '</a>

					</div>

						<div class="searched-item-content">

							<h2><a href="#">'.$user->first_name.' '.$user->last_name.'</a></h2>

							<div class="searched-user-info">

								<ul>

									<li><span><i class="icon ion-android-phone-portrait"></i></span>7862109012</li>

									<li><span><i class="icon ion-email"></i></span>'.$user->email.'</li>

								</ul>

								<div class="bookings-links">

									<h5>Previous Bookings</h5>

									'.$currLinks.'

								</div>

							</div>

						</div>

					</div>';

                }

                $allHtml .= $usersHtml;

            }

            else

            {

                $usersHtml = '<div class="no-search-box">

							<div class="no-search-content">

								<h3>No results for “'.$name.'”</h3>

								<p>Refine your search terms or try searching something else.</p>

							</div>

							<div class="recent-searches">

							</div>

						</div>';

            }

        }

        else

        {

            $bookingHtml = '<div class="no-search-box">

							<div class="no-search-content">

								<h3>No results for “'.$name.'”</h3>

								<p>Refine your search terms or try searching something else.</p>

							</div>

							<div class="recent-searches">

							</div>

						</div>';

            $allHtml = $bookingHtml;

            $usersHtml = $bookingHtml;

        }

        return response()->json(['alldata'=>$allHtml,'bookings'=>$bookingHtml,'users'=>$usersHtml]);

    }

    /*============================= end function to get sidenav search ================*/



    /*============================= end DashboardController ==================================*/

}

