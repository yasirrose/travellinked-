<?php

	$code = session()->get("code");

	$flag = session()->get("srcFlage");

?>

<form action="{{url('changeSearch')}}" method="get" class="sticky-form">

    <input type="hidden" id="nightsSticky" name="nights" value="{{session()->get('nights')}}">

    <input type="hidden" name="id" id="input_hotelSticky" value="<?php echo $code; ?>">

    <input type="hidden" name="sflag" id="stypeSticky" value="<?php echo $flag; ?>">

    <div class="destination-autofill input-div">

    <input type="text" placeholder="Where you going?" class="control-field search_hotel_sticky" autocomplete="off" name="location_name" value="{{session()->get('destination')}}">

        <div id="error_location_name" style="display: none;" class="error_location_name">Please enter the location/hotel Name.</div>

    <div class="search-list-holder-sticky"> <datalist class="search_result_sticky" style="width:auto !important;"></datalist></div>

    <?php if(session()->has("serchBack")){ ?>

    <span style="color:red;"><?php echo session()->get("serchBack"); ?></span>   

    <?php }?>

    </div>

    <div class="staying-days">

        <input type="text" placeholder="Check In" id="datepicker_in_sticky" name="checkin" autocomplete="off" value="{{session()->get('checkin')}}" class="control-field">

        <div class="sticky_tooltip_in" style="display:none;"></div>

        <span class="check-arrow"> <i class="icon ion-ios-arrow-thin-right"></i> </span>

        <input type="text" placeholder="Check Out" id="datepicker_out_sticky" name="checkout" autocomplete="off" value="{{session()->get('checkout')}}" class="control-field">

        <div class="sticky_tooltip_out" style="display:none;"></div>

        <a href="javascript:void(0)" id="clearDates"> <i class="icon ion-close-round"></i> </a>

    	<!--<input type="hidden" class="datepicker_in_sticky">-->

	    <div class="datepicker-container-sticky" id="sticky_date_container" style="display:none;"></div>

    </div>
        <div id="error_datePicker2" class="error_datePicker2" style="display: none;">Please enter the location/hotel Name.</div>

    <div class="rooms-and-guests horiz-search">

        <div class="icon-control horiz-search">

            <?php 

            $selAdlt = session()->get("adults"); 

            $selChild = session()->get("totalChild");

			$roomsHoriz = intval(session()->get("num_rooms"));

            ?>

            <input class="control-field horiz-search" id="adultsChildSticky" value="<?php echo $roomsHoriz ?> rooms, <?php echo $selAdlt+$selChild ?> guests" readonly>

            <span class="ion ion-arrow-down-b" class="horiz-search"></span>

        </div>

        @include('frontend.partial_rooms')

    </div>

    <button type="submit" id="search-btn">Search</button>

</form>