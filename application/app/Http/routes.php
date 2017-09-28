<?php
/*



|--------------------------------------------------------------------------



| Application Routes



|--------------------------------------------------------------------------



|



| Here is where you can register all of the routes for an application.



| It's a breeze. Simply tell Laravel the URIs it should respond to



| and give it the controller to call when that URI is requested.



|



*/

Route::get('404', function(){
    return view('frontend.404');
});
Route::get('login','SiteController@index');

Route::post('validateLogin', 'SiteController@validateLogin');

Route::group(['middleware' => ['siteauth']], function (){

    Route::get('flush',function(){
        Cache::flush();
    });
    Route::get('reset-this','RegisterController@resetlogin');
    Route::post('user_register', 'RegisterController@user_register');
    Route::get('set-password/{id}', 'RegisterController@set_password');
    Route::get('activate-account/{id}', 'RegisterController@activate_account');
    Route::post('update_Password', 'RegisterController@update_password');
    Route::post('forgot-password-email', 'RegisterController@send_mail_reset_password');
    Route::get('forget-password/{id}', 'RegisterController@forget_password');
    Route::get('resend-confirmation', 'RegisterController@resend_confirmation');
    Route::post('resend_email', 'RegisterController@resend_email');
    Route::get('cronDailyJob', 'HomeController@DailyCron');
    Route::get('cronJobWeekly', 'HomeController@cronWeekly');
    Route::get('testDeal','HomeController@singleDeal');
    Route::get('signup', 'RegisterController@signupUser');
    /* -------- Tested by Zee---------*/
    Route::get('userlogin/{type}','RegisterController@newLogin');
	Route::post('user_login','RegisterController@user_login');
	Route::get('/callback', 'RegisterController@handleProviderCallback');
    Route::get('user_logout', 'RegisterController@user_logout');
    Route::get('verify_email/{confirmation_code}','RegisterController@verifyUser');
    Route::post('submitForm', 'RegisterController@RegisterUser');
    Route::post('afterRegister','RegisterController@ConfiremAccountByEmail');

    /*Home page*/
    Route::get('/', 'HomeController@index');
    /*Search functionality*/
    Route::get('search', 'SearchController@search');
    Route::get('no/inventory', 'SearchController@Inventory_Not_Fount');
    Route::get('hotelImages', 'SearchController@loadFilterRecords');
    Route::get('hotelNames', 'SearchController@getHotelNames');
    Route::get('hotelFacs', 'SearchController@getHotelFacs');

    /* -------- Tested by Zee ---------*/


    Route::post('getTDeals','HomeController@getTDeals');
    Route::get('search_hotels', 'HomeController@search_hotels');
    Route::get('checkLocation', 'HomeController@checkLocation');

    Route::get('deals/{city}/{id}','DealsController@goToHotelLandingPage');
    Route::get('viewHotel/{city}/{id}','DealsController@ViewHotel');


    Route::get('deals/{city}/{id}','DealsController@goToHotelLandingPage1');

    Route::get('destinations/{id}/{name}','DealsController@goToSearchPageDestination');

    Route::get('cities/{city}/{code}/{cityCode}','DealsController@goToSearchPageCitites');

    Route::get('sortByPrice', 'SearchController@sortByPrice');

    Route::get('sortByStars', 'SearchController@sortByStars');

    Route::get('sortByHotelNames', 'SearchController@sortByHotelNames');

    Route::get('ClearAll', 'SearchController@ClearAll');

    Route::get('filterByHotelName', 'SearchController@filterByHotelName');

    Route::get('filterByPrice', 'SearchController@filterByPrice');

    Route::get('hotelFacilities', 'SearchController@hotelFacilities');

    Route::get('rooms', 'RoomController@hotelRooms');

    Route::get('searchWithNewParams', 'RoomController@searchWithNewParams');

    Route::get('goToPyament', 'RoomController@goToPyament');

    Route::get('payment', 'PaymentController@payment');

    Route::get('payment/{id}', 'PaymentController@paymentPortalWithCheapest');

    Route::get('check_out', 'PaymentController@check_out');

    Route::get('thankYou', 'PaymentController@thankYou');

    Route::get('500', 'ErrorController@index');

    Route::get('error', 'ErrorController@fbError');

    Route::group(['prefix' => 'user'], function(){

        Route::get('trip', 'UserPreference@TripSetting');

        Route::get('billInformation', 'UserPreference@BillInformation');

        Route::get('profile', 'UserPreference@MyProfile');

        Route::post('updateProfile', 'UserPreference@updateProfile');

        Route::get('deactivateAccount', 'UserPreference@deactivateAccount');

        Route::get('travelers', 'UserPreference@Travelers');

        Route::get('reservations', 'UserPreference@AllReservations');

        Route::get('password', 'UserPreference@ChangePassword');

        Route::get('billing', 'UserPreference@BillingInformation');

        Route::get('History', 'UserPreference@History');

        Route::post('update_password', 'UserPreference@UpdatePassword');

        Route::get('reservations/{bookingID}/cancel', 'UserPreference@CancelBooking');

        Route::get('reservations/{bookingID}/viewBooking', 'UserPreference@viewBooking');
        Route::post('getSearchRecords','UserPreference@getFilterRecord');
        Route::get('getPDF/{bookingID}','UserPreference@generatePDF');



    });

    /*======== Dashboard are routes ==========*/

    Route::group(['prefix' => 'admin'], function (){

        Route::get('login', 'dashboard\RegisterController@AdminLogin');

        Route::post('signin', 'dashboard\RegisterController@admin_login');

        Route::group(['middleware' => ['adminauth']], function () {

            Route::get('/', 'dashboard\DashboardController@index');

            Route::post('get_destinations','dashboard\DealsController@get_all_destination_deals');

            Route::get('create/customer','dashboard\DashboardController@create_customer');

            Route::post('updateCustomer/{id}','dashboard\UserController@updateUser');


            Route::get('get_sidenav_search', 'dashboard\DashboardController@get_sidenav_search');

            Route::post('register', 'dashboard\RegisterController@admin_register');

            Route::get('logout', 'dashboard\RegisterController@admin_logout');

            Route::get('registration', 'dashboard\RegisterController@adminRegister');

            /*===== rout for displaye booking on admin side====*/

            Route::get('booking', 'dashboard\BookingController@showBooking');

            Route::get('regbooking', 'dashboard\BookingController@regBooking');
            Route::get('customerDetail',function(){
                $title = 'Upload Bonotel Deals';
                return view('dashboard.customerDetail')->with('title', $title);
            });

            Route::get('cancel/{id}', 'dashboard\BookingController@cancellation');

            Route::get('refund/{id}','dashboard\BookingController@refund');


            Route::get('/bookings', 'dashboard\BookingController@Bookings');
            Route::post('/bookings_details', 'dashboard\BookingController@bookingDetails');


            Route::post('bookings/changeNotes','dashboard\BookingController@changenotes');

            Route::get('booking/detail/{id}', 'dashboard\BookingController@bookingDetail');

            Route::get('user/edit/{id}','dashboard\UserController@editUser');

            Route::get('approve/{id}', 'dashboard\BookingController@approved');

            Route::get('decline/{id}', 'dashboard\BookingController@bookingDecline');

            Route::post('get_bookings', 'dashboard\BookingController@get_bookings_filtered');

//            Route::post('get_deals', 'dashboard\DealsController@get_deals_filtered');

            Route::get('b2c_markup', 'dashboard\RateController@b2cMarkup');

            Route::post('save_markup/{id}', 'dashboard\RateController@saveMarkup');

            Route::get('allusers', 'dashboard\UserController@index');
            Route::post('users', 'dashboard\UserController@users');

            Route::get('viewUser/{id}','dashboard\UserController@viewUser');

            Route::post('/addCustomer', 'dashboard\UserController@insertUser');

            Route::post('user/disable', 'dashboard\UserController@disableUser');

            Route::get('api', 'dashboard\ApiController@Api');

            Route::post('addApi', 'dashboard\ApiController@addApi');

            Route::get('showApi', 'dashboard\ApiController@showApi');

            Route::get('api/edit/{id}', 'dashboard\ApiController@editApi');

            Route::post('updateApi/{id}', 'dashboard\ApiController@updateApi');

            Route::get('api/delete/{id}', 'dashboard\ApiController@deleteApi');

            Route::get('import', 'dashboard\ImportController@import');

            Route::post('importFile', 'dashboard\ImportController@importFile');

            Route::get('importFacility', 'dashboard\ImportController@importFacility');

            Route::post('importFacilityFile', 'dashboard\ImportController@importFacilityFile');

            Route::get('importDeals', 'dashboard\ImportController@importDeals');

            Route::post('importDealsFile', 'dashboard\ImportController@importDealsFile');

            Route::post('users/deleteuser','dashboard\UserController@deleteUser');



            Route::get('import-hotels-with-codes', 'dashboard\ImportController@importHotelsWithCodes');

            Route::post('update-hotels-with-codes', 'dashboard\ImportController@updateHotelsWithCodes');


            Route::POST('users/getFilteredRecords', 'dashboard\UserController@getFilteredRecords');

            Route::get('deals', 'dashboard\DealsController@index');
            Route::post('load_deals', 'dashboard\DealsController@loadDeals');

            //Route::get('bonoteldeals', 'dashboard\DealsController@bonotelDeals');

            Route::post('updatebonoteldeals', 'dashboard\DealsController@updateBonotelDeals');

            Route::get('getupdatedealstatus/{id}', 'dashboard\DealsController@getupdateDealStatus');

            Route::post('updatedealstatus', 'dashboard\DealsController@updateDealStatus');

            Route::post('updateApistatus','dashboard\ApiController@updateApiStatus');

            Route::get('create-deal', 'dashboard\DealsController@createDeal');

            Route::get('getall_hotels', 'dashboard\DealsController@getallHotels');

            Route::post('insert-deal', 'dashboard\DealsController@insertDeal');

            Route::get('destinationsPage', 'dashboard\DealsController@allDestinationPage');
            Route::post('destinations', 'dashboard\DealsController@allDestinations');

            Route::post('update-destination-status', 'dashboard\DealsController@updateDestinationStatus');

            Route::post('update-destination-image', 'dashboard\DealsController@updateDestinationImage');

            Route::get('createbooking', 'dashboard\BookingController@createBooking');

            Route::get('lockscreen','dashboard\UserController@LockScreen');

            Route::get('showLockScreen','dashboard\UserController@ShowLockScreen');

            Route::post('lock_password','RegisterController@check_lock_password');

//            Route::get('get_alarm_notification','dashboard\BookingController@notification_alarm');

            Route::get('mute_notification/{id}','dashboard\BookingController@mute_notification');

            Route::post('delete_booking','dashboard\BookingController@deleteBooking');

        });

    });

});
