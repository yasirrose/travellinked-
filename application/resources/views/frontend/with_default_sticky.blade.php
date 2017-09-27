<form action="{{url('search')}}" method="get" class="sticky-form">

    <input id="nightsSticky" name="nights" type="hidden">

    <input name="id" id="input_hotelSticky" type="hidden">

    <input name="sflag" id="stypeSticky" type="hidden">

    <div class="destination-autofill input-div">

    <input type="text" placeholder="Where you going?" class="control-field search_hotel_sticky" autocomplete="off" name="location_name" value="">
<div id="error_location_name" style="display: none;" class="error_location_name">Please enter the location/hotel Name.</div>
       <div class="search-list-holder-sticky"> <datalist class="search_result_sticky" style="width:auto !important;"></datalist></div>

    </div>
    

    <div class="staying-days">

        <input placeholder="Check In" id="datepicker_in_sticky" name="checkin" autocomplete="off" class="control-field" type="text">



        <div class="sticky_tooltip_in" style="display:none;"></div>

        <span class="check-arrow"> <i class="icon ion-ios-arrow-thin-right"></i> </span>

        <input placeholder="Check Out" id="datepicker_out_sticky" name="checkout" autocomplete="off" class="control-field" type="text">

        <div class="sticky_tooltip_out" style="display:none;"></div>

        <a href="javascript:void(0)" id="clearDates"> <i class="icon ion-close-round"></i> </a>

    	<!--<input type="hidden" class="datepicker_in_sticky">-->

	    <div class="datepicker-container-sticky" id="sticky_date_container" style="display:none;"></div>
        <div id="error_datePicker2" style="display: none;" class="error_datePicker2">This Field is Required</div>

    </div>
        


    <div class="rooms-and-guests horiz-search">

        <div class="icon-control horiz-search">

            <input class="control-field horiz-search" id="adultsChildSticky" placeholder="1 room, 2 guests" readonly>

            <span class="ion ion-arrow-down-b"></span>

        </div>

        @include('frontend.sticky_rooms')

    </div>

    <button type="submit" id="search-btn">Search</button>

</form>