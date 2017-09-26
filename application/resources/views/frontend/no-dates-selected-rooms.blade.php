@extends('layouts.no-dates-selected')

@section('content')

<style>

.roomBlocks .pform-1{

	display:none;

}

.radius-last{

	border-bottom-left-radius:3px;

	border-bottom-right-radius:3px;

}

</style>

<?php 

$nights = session()->get("nights");

$rate = Helper::Rate();

$actualTax  = floatVal(str_replace(",","",$rate[1]->global_value));

$actualDis  = floatVal(str_replace(",","",$rate[1]->global_discount));

$rateType   = $rate[1]->global_type;

?>



<div class="search-loader overlay" style="display:none;">

@include('layouts.loader')

</div>

<?

if(empty($retHotel) || empty($hotelPolicy))

{

	die("<h1>Requested page not found please try another</h1>");

}

$roomsArrCheck = $retHotel['roomInformation'];

$roomsArr = (object)$retHotel['roomInformation'];

$minDeal = array();

$minDeal = $roomsArrCheck;

if(isset($roomsArrCheck[0]['roomCode']))

{

	uasort($minDeal, function ($a, $b) {

			return intval(str_replace(',','',$a['rateInformation']['totalRate'])) - intval(str_replace(',','',$b['rateInformation']['totalRate']));

		});

	$minDeal = array_values($minDeal);

}

?>

<link href="{{url('/assets/css/demo.css')}}" rel="stylesheet">

<div class="rooms-landing-top">

    <div class="rooms-topbar">

        <div class="container">

            <label><a href="{{url($topBarData['link'])}}"><i class="icon ion-ios-arrow-thin-left"></i>View All {{$topBarData['text']}} Hotels</a></label>

            <ul class="rooms-topbar-social">

                <li>

                	<?php 

						$mailurl = 'Subject= Travel Linked';

						$mailurl.= '&Body='.$retHotel['name'].' '.$retHotel['city'].' '.$retHotel['stateProvince'].' '.$retHotel['country'];

					?>

                    <div id="mailContent" style="display:none;" class="<?php echo $mailurl ?>"></div>

                    <a class="f-xs" href="javascript:void(0)" id="mailShare">

                    <i class="fa fa-paper-plane"></i>

                    </a>

                </li>

                <li>

                	<?php 

						$fburl = 'title='.urlencode('Travel Linked');

						$fburl.= '&picture='.$retHotel['image'];

						$fburl.= '&description='.urlencode($retHotel['name'].' '.$retHotel['city'].' '.$retHotel['stateProvince'].' '.$retHotel['country']);

					?>

                    <div id="fbContent" style="display:none;" class="<?php echo $fburl ?>"></div>

                    <a class="f-sm" href="javascript:void(0)" id="fbShare" target="_blank">

                    <i class="fa fa-facebook"></i>

                    </a>

                </li>

                <li>

                	<?php 

						$twitterurl = 'text='.urlencode($retHotel['name'].' '.$retHotel['city'].' '.$retHotel['stateProvince'].' '.$retHotel['country']);

						$twitterurl.= '&image='.$retHotel['image'];

					?>

                    <div id="twitterContent" style="display:none;" class="<?php echo $twitterurl ?>"></div>

                    <a href="javascript:void(0)" target="_blank" id="twitterShare" target="_blank">

                    <i class="fa fa-twitter"></i>

                    </a>

                </li>

                <li>

                	<?php 

						$pinurl = 'media='.$retHotel['image'];

						$pinurl.= '&description='.urlencode($retHotel['name'].' '.$retHotel['city'].' '.$retHotel['stateProvince'].' '.$retHotel['country']);

					?>

                    <div id="pinContent" style="display:none;" class="<?php echo $pinurl ?>"></div>

                    <a href="javascript:void(0)" target="_blank" id="pinShare" target="_blank">

                    <i class="fa fa-pinterest"></i>

                    </a>

                </li>

                 <li>

                    <a class="f-sm" href="javascript:void(0)" target="_blank" id="gShare">

                    <i class="fa fa-google-plus"></i>

                    </a>

                </li>

            </ul>

        </div>        

    </div>



	<?

	if(isset($minDeal[0]['rateInformation']))

	{

		$actualRate = str_replace(',','',$minDeal[0]['rateInformation']['totalRate']);

	}

	else

	{

		$actualRate = str_replace(',','',$minDeal['rateInformation']['totalRate']);

	}

	if($rateType == 0)

	{

		$taxAmount = floatVal(($actualRate*$actualTax)/100);

		$discountAmount = floatVal(($actualDis*$acualRate)/100);

		$rateWithTax = floatVal($actualRate+$taxAmount-$discountAmount);

	}

	elseif($rateType == 1)

	{

		$rateWithTax = floatVal($actualRate+$actualTax-$actualDis);

	} 

	$rating = "";

	$class = "";

	if(is_array($retHotel["starRating"]))

	{

		$arr[0] = 0;

		$rating = "";

	}

	else

	{

		$arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$retHotel["starRating"]);

	}                                                               

	if($arr[0] == 1 || $arr[0] == 1.5){

		$rating = "1 Star Hotel";

		$class = "hotel-rating one-star";

	}

	elseif($arr[0] == 2 || $arr[0] == 2.5){

		$rating = "2 Star Hotel";

		$class = "hotel-rating two-star";

	}

	elseif($arr[0] == 3 || $arr[0] == 3.5){

		$rating = "3 Star Hotel";

		$class = "hotel-rating three-star";

	}

	elseif($arr[0] == 4 || $arr[0] == 4.5){

		$rating = "4 Star Hotel";

		$class = "hotel-rating four-star";

	}

	elseif($arr[0] == 5 || $arr[0] == 5.5){

		$rating = "5 Star Hotel";

		$class = "hotel-rating five-star";

	}

	?>

    <div class="callbacks_container">

      <ul class="rslides" id="slider4">

      <? 

	  if(count($sliderArr) > 0){

	  foreach($sliderArr as $key => $value){ ?>

        <li>

            <img src="<? echo $sliderArr[$key] ?>" alt="">

            <div class="container">

                <div class="caption">

                    <div class="left-caption">

                        <a href="javascript:void(0)" class="<?php echo $class ?>"><? echo $rating ?></a>

                        <h3><? echo $retHotel['name'] ?></h3>

                        <p class=""><? echo $retHotel['city'].", ".$retHotel['stateProvince'] ?></p>

                    </div>

                    <div class="right-caption">

                        <div class="top_bttn_nowp payment-signin ">

                            <a href="#" class="minDeal">See Availability</a>

                        </div>

                    </div>

                </div>

            </div>

        </li>

       <? } }else{ ?>

           <li class="no-image-banner">

            <img src="{{url('assets/images/tl-no-image.jpg')}}" alt="">

            <div class="container">

				<div class="no-image-content">

					<i class="icon ion-image"></i>

					<span>No Image</span>

				</div>

                <div class="caption">

                    <div class="left-caption">

                        <a href="javascript:void(0)" class="<?php echo $class ?>"><? echo $rating ?></a>

                        <h3><? echo $retHotel['name'] ?></h3>

                        <p class=""><? echo $retHotel['city'].", ".$retHotel['stateProvince'] ?></p>

                    </div>

                    <div class="right-caption">

                        <div class="top_bttn_nowp payment-signin ">

                            <a href="#" class="minDeal">See Availability</a>

                        </div>

                    </div>

                </div>

            </div>

        </li>

       <? } ?>

      </ul>

    </div>

</div>

<?php if($actualTax == 0){ ?>

<div id="defaultMin" class="<?php echo round($actualRate/$nights , 2); ?>" style="display:none;"></div>

<?php }else{ ?>

<div id="defaultMin" class="<?php echo round($rateWithTax/$nights , 2); ?>" style="display:none;"></div>

<?php } ?>

<div class="body-section hotel-landing-page rooms-front-page">

		<div class="container">

        	<div class="search-container-left">

                <h3>Content</h3>

                <div class="sidebar-panel jumplinks-nav">

                	<ul>

                    	<li><a href="javascript:void(0)" data-scroll="roomAvlSection">Room Availability</a></li>

                        <li><a href="javascript:void(0)" data-scroll="hotelDesSection">Hotel Description</a></li>

                        <li><a href="javascript:void(0)" data-scroll="recSection">Recreation</a></li>

                        <li><a href="javascript:void(0)" data-scroll="whatToKnowSec">What to Know</a></li>

                        <li><a href="javascript:void(0)" data-scroll="mapSection">Map</a></li>

                        <li><a href="javascript:void(0)" data-scroll="locationSec">Location</a></li>

                        <li><a href="javascript:void(0)" data-scroll="cancelSec">Cancelation Policy</a></li>

                    </ul>

                </div>

                <div class="adjust_dates_buttons" id="adjustDatesFalse" style="display:none;">

					<?php

                    if($actualTax == 0){

                    ?>

                    <p class="nights-price"><span id="minDealLeft" style="display:none;">$<?php echo round($actualRate/$nights,2); ?></span>/night</p>

                    <?php }else{ ?>

                     <p class="nights-price"><span id="minDealLeft" style="display:none;">$<?php echo round($rateWithTax/$nights ,2); ?></span>/night</p>

                    <?php } ?>

                    <a href="javascript:void(0)" id="minDeal1" style="display:none;">Book Now <i class="icon ion-ios-arrow-thin-right"></i></a>

                </div>

                <div class="adjust_dates_buttons" id="adjustDatesTrue">

                    <p id="noRooms"></p>

                    <a href="javascript:void(0)" id="adjustDatesTrueButton">Choose Dates</a>

                </div>

            </div>

        	<div class="search-container-right">

            	<div class="top-room-description no-dates-selected">

                	<div class="top_bttn_nowp payment-signin ">

                    	<a href="javascript:void(0)" id="submit_booking" style="display:none;">Book Now</a>

                        <a href="javascript:void(0)" id="adjustDatesButton">Choose Dates</a>

                    </div>

                    <form method="post" id="updateSearchRoomPage">

                        <div class="pform-row" id="roomAvlSection" data-anchor="roomAvailability"> 

                           <h3>Room Availability</h3>

                           <div class="roomSearchBar">

                            <div class="pform-1 checkin">

                                <div class="icon-control">

                                    <input type="text" id="check_in" name="checkinRoomPage" autocomplete="off" class="control-field" placeholder="mm/dd/yyyy" required="required">

                                    <span class="ion ion-arrow-down-b"></span>

                                    <div class="main_tooltip" style="display:none;"></div>

                                </div>

                            </div>

                            <div class="pform-1">

                                <div class="icon-control">

                                    <input type="text" id="check_out" name="checkoutRoomPage" autocomplete="off" class="control-field" placeholder="mm/dd/yyyy" required="required">  

                                    <span class="ion ion-arrow-down-b"></span>

                                    <div class="main_tooltip" style="display:none;"></div>

                                    <input type="hidden" name="nightsRoomPage" id="nightsRoomPage" />

                                    <input type="hidden" name="hcodeRoomPage" value="<? echo $retHotel['hotelCode'] ?>"/>

                                </div>

                            </div>

                            <input type="hidden" class="check_in">

							<div class="checkin-container" style="display:none;"></div>

                            <div class="pform-1 width-200 rooms-horiz-box">

                                <div class="icon-control rooms-horiz-box">

									<?php 

									$selAdlt = session()->get("adults"); 

									$selChild = session()->get("totalChild");

									$roomsHoriz = intval(session()->get("num_rooms"));

									?>

                                    <input class="control-field rooms-horiz-box" id="adultChildSumRooms" value="<?php echo $roomsHoriz ?> rooms, <?php echo $selAdlt+$selChild ?> guests" readonly>

                                    <span class="ion ion-arrow-down-b" class="rooms-horiz-box"></span>

                                </div>

                                @include('frontend.horizbox_rooms')

                            </div>

                            <div class="pform-1 payment-signin reservation">

                                <input type="submit" class="control-field" value="Update" name="updateSearch">

                            </div>

                           </div>

                        </div>

                    </form>

                    <div class="pform-row pick-room mt-extra">

                    	<h3 id="roomMainHeading">Pick a Room</h3>

                        <form action="{{url('payment')}}" method="get" id="booking_form">

                            <div id="roomsReplacable">

								<?php

                                if(isset($roomsArrCheck[0]['roomCode'])){

                                $counter = 1;

								for($i = 1; $i<=Session::get('num_rooms');$i++){ ?>

								<div class="pform-row pick-room mt-extra roomBlocks" name="roomBlock<?php echo $i ?>">

                                <?php if(Session::get('num_rooms') > 1){ ?>

                                <h3>Room <?php echo $i ?></h3>

                                <?php } ?>

                                <?php foreach($roomsArr as $room){ ?>

                            	<div class="pform-1">

                                    <div class="left-check-title">

                                       	<input type="hidden" class="hotel_code hotets" value="<?php echo $retHotel["hotelCode"] ?>">

                                    	<div class="inner-right-title">

                                    		<h4><?php echo $room['roomType']; ?></h4>

                                    	</div>

                   <a href="javascript:void(0)" name="room<?php echo $counter ?>" onclick="showDesc(this.name)">More info</a>

                                    </div>

                                    <div class="right-amout">

										<button id="adjustDatesButton">See Availablity</button>

                                    </div>

                                    <div class="hide_box" style="display:none;" id="room<?php echo $counter ?>">

                                    	<h4 class="sm-minimize-text"><?php echo $room['roomType']; ?> <span><?php echo $room['bedType']; ?></span></h4>

                                    	<p><b>Adults : </b><?php echo $room['stdAdults'] ?></p>

                                    	<p><b>Children : </b>

											<?php 

                                            if(isset($roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child']))

                                            {

                                            echo $roomTypes[(string)$room['roomTypeCode']][(string)$room['bedTypeCode']]['child'];

                                            } 

                                            else

                                            {

                                            echo 0;

                                            }

                                            ?>

                                    	</p>

                                    	<p><?php echo implode(" ",$room['roomDescription']); ?></p>

                                    </div>

                                </div>    

								<?php $counter++; } ?>

                                </div>    

                                <div class="pform-row pick-room btn">

                                    <div class="pform-1 viewMoreOption" id="roomBlock<?php echo $i ?>">

                                        <a href="javascript:void(0)">View More Option&nbsp; <i class="icon ion-ios-arrow-thin-down"></i></a>

                                     </div>     

                                </div>

								<?php } }else{ 

								for($i = 1; $i<=Session::get('num_rooms');$i++){

								?>

									<div class="pform-row pick-room mt-extra roomBlocks" name="roomBlock<?php echo $i ?>">

									<?php if(Session::get('num_rooms') > 1){ ?>

                                    <h3>Room <?php echo $i ?></h3>

                                    <?php } ?>

                                    <div class="pform-1">

                                        <div class="left-check-title">

                                            <div class="rating-check">

                                                <input type="hidden" class="hotel_code hotets"value="<?php echo $retHotel["hotelCode"] ?>">

                                            </div>

                                            <div class="inner-right-title">

                                                <h4><?php echo $roomsArr->roomType; ?></h4>

                                            </div>

                                            <a href="javascript:void(0)" name="room1" onclick="showDesc(this.name)">More info</a>

                                        </div>

                                        <div class="right-amout">

                                            <button id="adjustDatesButton">See Availablity</button>

                                        </div>

                                        <div class="hide_box" style="display:none;" id="room1">

                                            <h4 class="sm-minimize-text"><?php echo $roomsArr->roomType; ?> <span><?php echo $roomsArr->bedType; ?></span></h4>

                                            <p><b>Adults : </b><?php echo $roomsArr->stdAdults ?></p>

                                            <p><b>Children : </b>

                                                <?php 

                                                if(isset($roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child']))

                                                {

                                                echo $roomTypes[(string)$roomsArr->roomTypeCode][(string)$roomsArr->bedTypeCode]['child'];

                                                } 

                                                else

                                                {

                                                echo 0;

                                                }

                                                ?>

                                            </p>

                                            <p><?php echo implode(" ",$roomsArr->roomDescription); ?></p>

                                        </div>

                                    </div>

                                    </div>    

                                    <div class="pform-row pick-room btn">

                                        <div class="pform-1 viewMoreOption" id="roomBlock<?php echo $i ?>">

                                            <a href="javascript:void(0)">View More Option&nbsp; <i class="icon ion-ios-arrow-thin-down"></i></a>

                                         </div>     

                                    </div>

                                <?php } } ?>

                            </div>

                        </form>

                      </div>

                </div>    

                <div class="btm-room-description" id="hotelDesSection">

                    <h3>Overview</h3>

                    <div class="hotel-description" data-anchor="hotelDes">

                        <h4>Hotel Description</h4>

                        <p><?php echo $hotelPolicy->hotel->description; ?></p>

                    </div>

                    <div class="hotel-description" id="recSection" data-anchor="recSection">

                        <h4>Recreation</h4>

                        <ul class="hotel-list">

                            <?php 

                            $recs = str_replace("<ul>","",$hotelPolicy->hotel->recreation);

                            $recs = str_replace("</ul>","",$recs);

                            echo $recs; 

                            ?>

                        </ul>

                    </div>

                    <div data-anchor="whatToKnow" class="hotel-description btm-0" id="whatToKnowSec">

                        <h4>What to know</h4>

                        <ul class="hotel-list">

                            <?php 

                            $what = str_replace("<ul>","",$hotelPolicy->hotel->facilities);

                            $what = str_replace("</ul>","",$what);

                            echo $what; 

                            ?>

                        </ul>

                    </div>

                </div>

                <div class="map-section" id="mapSection" data-anchor="mapTab">

                    <iframe width="100%" id="map" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $hotelPolicy->hotel->latitude; ?>,<?php echo $hotelPolicy->hotel->longitude; ?>&amp;key=AIzaSyDyV2wVxJWFHpbbmKGSwniwTpPwy4UgNbk"></iframe>

                </div>

                <div class="btm-room-description" id="locationSec" data-anchor="locationTab">

                	<div class="hotel-description">

                    	<h4>Location</h4>

                        <p><?php echo $hotelPolicy->hotel->address.", ".$hotelPolicy->hotel->city.", ".$hotelPolicy->hotel->state; ?></p>

                        <p><?php echo $hotelPolicy->hotel->country ?></p>

                       

                   	</div>

                    <div class="hotel-description" id="cancelSec">

                        <h4 data-anchor="cancelPol">Cancelation Policy</h4>

                        <ul class="hotel-list">

                        	<?php 

							$cancel = str_replace("<ul>","",$hotelPolicy->hotel->cancelPolicies);

							$cancel = str_replace("</ul>","",$cancel);

							echo $cancel; 

							?>

                        </ul>

                    </div>

                </div>

            </div>

        	<div class="clear"></div>

   		</div>

	</div>

   <div id="targetSection" class="{{$section}}" style="display:none;"></div>

    <script type="text/javascript">

			function showDesc(id)

			{

            	aText = $('a[name='+id+']').text();

				$("#"+id).slideToggle();

                if(aText === 'More info')

                {

                	$('a[name='+id+']').text('Minimize info');

               	}

                else if(aText === 'Minimize info')

                {

                	$('a[name='+id+']').text('More info');

               	}

			}

		

    </script>

    

@endsection