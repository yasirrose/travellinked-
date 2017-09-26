@extends('layouts.main')
@section('content')
<?php
	$code = session()->get("code");
	$flag = session()->get("srcFlage");
 ?>
<div class="body-section">
    <div class="container">
        <div class="sorry-page">
            <div class="sorry-page-inner">
                <h2>Sorry :(</h2>
                <p>
				<?php 
				echo session()->get('msg'); 
				session()->set('msg','');
				?>
                </p>
                <div class="hb-center">
                    <form action="{{url('changeSearch')}}" method="get" class="sticky-form">
                    <input type="hidden" id="nightsSticky" name="nights" value="{{session()->get('nights')}}">
                    <input type="hidden" name="id" id="input_hotelSticky" value="<?php echo $code; ?>">
                    <input type="hidden" name="sflag" id="stypeSticky" value="<?php echo $flag; ?>">
                    
                    <div class="destination-autofill input-div">
<input type="text" placeholder="Where you going?" class="control-field search_hotel_sticky" autocomplete="off" name="location_name" value="{{session()->get('destination')}}">
                <div class="search-list-holder-sticky"> <datalist class="search_result_sticky" style="width:auto !important;"></datalist></div>
                <?php if(session()->has("serchBack")){ ?>
                <span style="color:red;"><?php echo session()->get("serchBack"); ?></span>   
                <?php }?>
                    </div>
                    <div class="staying-days">
                        <input type="text" placeholder="Check In" id="datepicker_in_sticky" name="checkin" value="{{session()->get('checkin')}}" class="control-field">
                        <div class="sticky_tooltip_in" style="display:none;"></div>
                        <span class="check-arrow"> <i class="icon ion-ios-arrow-thin-right"></i> </span>
                        <input type="text" placeholder="Check Out" id="datepicker_out_sticky" name="checkout" value="{{session()->get('checkout')}}" class="control-field">
                        <div class="sticky_tooltip_out" style="display:none;"></div>
                        <a href="#"> <i class="icon ion-close-round"></i> </a>
                    	<!--<input type="hidden" class="datepicker_in_sticky">-->
	   					<div class="datepicker-container-sticky" id="sticky_date_container" style="display:none;"></div>
                    </div>
                    <div class="rooms-and-guests horiz-search">
                        <div class="icon-control horiz-search">
                        	<?php 
							$selAdlt = session()->get("adults"); 
							$selChild = session()->get("totalChild");
							$roomsSorry = intval(session()->get("num_rooms"));
							?>
                            <input class="control-field horiz-search" value="<?php echo $roomsSorry ?> rooms, <?php echo $selAdlt+$selChild ?> guests" readonly>
                            <span class="ion ion-arrow-down-b" class="horiz-search"></span>
                    	</div>
                        @include('frontend.partial_rooms')
                    </div>
                    <button type="submit" id="search-btn">Search</button>
                </form>
                </div>
                <p class="psorry-page-btm"><span>If your still lost here are some other options to get you back on track</span></p>
                <ul>
                    <li>
                        <a href="{{url('/')}}">Go home</a>
                    </li>
                    <li>
                        <a href="#">Get into you account</a>
                    </li>
                    <li>
                        <a href="#">Send us feedback</a>
                    </li>
                </ul>
            </div>        
        </div>        
    </div>
</div>
@endsection