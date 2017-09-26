@extends('layouts.main')
@section('content')
<div class="search-loader" style="display:none;">
@include('layouts.loader')
</div>
   <?php
$page = Route::getCurrentRoute()->getPath();
    if($page == "/" && (empty(session()->get('userLogin')) || session()->get('userLogin') == 0) ){ ?>
<div class="body-section">
<?php } else{ ?>
<div class="body-section scf1123aa">
<?php }    ?>
    <div class="container">
        <div class="section-main-nav">
            <ul>
                <li><a href="#">Find a Deal</a></li>
                <li><a href="#">List Your Property</a></li>
                <li><a href="#">Travel Agents</a></li>
                <li><a href="#">Become an Affiliate</a></li>
                <li><a href="#">Travel Linked for Business</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="section-main-1">
        <form action="{{url('search')}}" method="get" class="search-form">
            <div class="search-engine-box">
                <h2>Get the Best Accommodation Deals</h2>
                <p>Over 230,000 Hotels Worldwide all at <b>Unbeatable Rates</b></p>
                <div class="search-engine-form">
                    <div class="search-engine-row">
                        <label>Where would you like to go?</label>
                        <div class="icon-control input-div">
                        <input type="hidden" name="id" id="input_hotel">
                        <input type="hidden" name="sflag" id="stype">
                        <input type="text" class="control-field search_hotel" autocomplete="off" name="location_name" placeholder="Enter destination, city or hotel name" id="locName">
                        <h4 id="error_locName" style="" class="error">This field is required</h4>
                        <span class="ion ion-ios-search"></span>
                        <div class="search-list-holder">
                            <datalist class="search_result"></datalist>
                        </div>
                        </div>
                    </div>
                    <div class="search-engine-row">
                        <div class="rows-3 psn-rlt">
                            <div class="w-180">
                                <label>Check In</label>
                                <div class="icon-control">
                                    <input type="text" id="datepicker_in" name="checkin" autocomplete="off" class="control-field" placeholder="mm/dd/yyyy">
                                    <span class="ion ion-arrow-down-b"></span>
                                    <div class="main_tooltip" style="display:none;"></div>
                                    <div id="error_datePicker" style="" class="error_datePicker">Please select checkIn properly</div>
                                </div>
                            </div>
                            <div class="w-180">
                                <label>Check Out</label>
                                <div class="icon-control">
                                    <input type="text" id="datepicker_out" name="checkout" autocomplete="off" class="control-field" placeholder="mm/dd/yyyy">
                                    <span class="ion ion-arrow-down-b"></span>
                                    <div class="main_tooltip" style="display:none;"></div>
                                    <div id="error_datePicker" style="" class="error_datePicker">Please select checkout properly</div>
                                </div>
                            </div>
                            <div class="w-54">
                                <label>Nights</label>
                                <div class="nights-select">
                                    <input type="text" class="control-field" id="nights" name="nights" placeholder="0" readonly="readonly">
                                </div>
                            </div>
                            <input type="hidden" class="datepicker_in">
							<div class="datepicker-container" id="main_date_container" style="display:none;"></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php
					for($mr = 1; $mr<=5; $mr++){
					$style = "";
					if($mr > 1) {
						$style = 'style="display:none"';
					}
					$curAges = array();
					$children = '0 Children';
					$childAgeStyle = 'style="display:none"';
					for($a = 0; $a < 8; $a++) {
						$childAgeStyle = 'style="display:none"';
						$index = count($curAges);
						$curAges[$index]['age'] = 0;
						$curAges[$index]['style'] = 'disabled="disabled"';
					}
					?>
                    <div class="search-engine-row search-engine-row-display-hide" <?php echo $style ?>>
						<?php if($mr == 1){ ?>
                            <div class="rows-3">
                                <div class="w-100">
                                <label>Rooms</label>
                                <div class="icon-control">
                                    <select class="control-field" id="rooms_count" name="num_rooms">
                                        <option value="1" selected="selected">1 Room</option>
                                        <option value="2">2 Rooms</option>
                                        <option value="3">3 Rooms</option>
                                        <option value="4">4 Rooms</option>
                                        <option value="5">5 Rooms</option>
                                    </select>
                                    <span class="ion ion-arrow-down-b"></span>
                                </div>
                            </div>
                            <?php }else{ ?>
                            <div class="rm-num-row">
                                <div class="room-label">
                                    <label>Room <?php echo $mr ?></label>
                                </div>
                            <?php } ?>
                            <div class="w-157">
                                <label>Adults</label>
                                <div class="icon-control">
                                    <select class="control-field" id="adultmain-<?php echo $mr ?>" name="adults_<?php echo $mr ?>">
                                         <option value="1">1 Adult</option>
                                         <option value="2" selected="selected">2 Adults</option>
                                         <option value="3">3 Adults</option>
                                         <option value="4">4 Adults</option>
                                         <option value="5">5 Adults</option>
                                    </select>
                                    <span class="ion ion-arrow-down-b"></span>
                                </div>
                            </div>
                            <input type="hidden" name="total_child" class="total_child" />
                            <div class="w-157">
                                <label>Children</label>
                                <div class="icon-control">
                                    <select class="control-field total_children search-engine-child select-child-<?php echo $mr ?>" name="children_<?php echo $mr ?>" id="total_child_main<?php echo $mr ?>">
                                        <option value="">No Children</option>
                                        <option value="1">1 Child</option>
                                        <option value="2">2 Children</option>
                                        <option value="3">3 Children</option>
                                        <option value="4">4 Children</option>
                                        <option value="5">5 Children</option>
                                        <option value="6">6 Children</option>
                                        <option value="7">7 Children</option>
                                        <option value="8">8 Children</option>
                                    </select>
                                    <span class="ion ion-arrow-down-b"></span>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="chldr-age-row Children-<?php echo $mr ?> total_child_main<?php echo $mr ?>_ages" <?php echo $childAgeStyle ?>>
                            <label>Children’s Ages (0 - 17)</label>
                            <div class="age-select-boxes">
                                <div class="icon-control">
                                    <select class="control-field age-1" name="children_<?php echo $mr ?>_age_1" <?php echo $curAges[0]['style'] ?> id="childmain_<?php echo $mr ?>_ages_1">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option vlalue="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                    </select>
                                    <span class="ion ion-arrow-down-b"></span>
                                </div>
                                <div class="icon-control">
                                    <select class="control-field age-2" name="children_<?php echo $mr ?>_age_2" <?php echo $curAges[1]['style'] ?> id="childmain_<?php echo $mr ?>_ages_2">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option vlalue="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                    </select>
                                    <span class="ion ion-arrow-down-b"></span>
                                </div>
                                <div class="icon-control">
                                    <select class="control-field age-3" name="children_<?php echo $mr ?>_age_3" <?php echo $curAges[2]['style'] ?> id="childmain_<?php echo $mr ?>_ages_3">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option vlalue="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                    </select>
                                    <span class="ion ion-arrow-down-b"></span>
                                </div>
                                <div class="icon-control">
                                    <select class="control-field age-4" name="children_<?php echo $mr ?>_age_4" <?php echo $curAges[3]['style'] ?> id="childmain_<?php echo $mr ?>_ages_4">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option vlalue="2">2</option>
                                        <option value="3">3</option>

                                        <option value="4">4</option>

                                        <option value="5">5</option>

                                        <option value="6">6</option>

                                        <option value="7">7</option>

                                        <option value="8">8</option>

                                        <option value="9">9</option>

                                        <option value="10">10</option>

                                        <option value="11">11</option>

                                        <option value="12">12</option>

                                        <option value="13">13</option>

                                        <option value="14">14</option>

                                        <option value="15">15</option>

                                        <option value="16">16</option>

                                        <option value="17">17</option>

                                    </select>

                                    <span class="ion ion-arrow-down-b"></span>

                                </div>

                                <div class="icon-control">

                                    <select class="control-field age-5" name="children_<?php echo $mr ?>_age_5" <?php echo $curAges[4]['style'] ?> id="childmain_<?php echo $mr ?>_ages_5">

                                        <option value=""></option>

                                        <option value="1">1</option>

                                        <option vlalue="2">2</option>

                                        <option value="3">3</option>

                                        <option value="4">4</option>

                                        <option value="5">5</option>

                                        <option value="6">6</option>

                                        <option value="7">7</option>

                                        <option value="8">8</option>

                                        <option value="9">9</option>

                                        <option value="10">10</option>

                                        <option value="11">11</option>

                                        <option value="12">12</option>

                                        <option value="13">13</option>

                                        <option value="14">14</option>

                                        <option value="15">15</option>

                                        <option value="16">16</option>

                                        <option value="17">17</option>

                                    </select>

                                    <span class="ion ion-arrow-down-b"></span>

                                </div>

                                <div class="icon-control">

                                    <select class="control-field age-6" name="children_<?php echo $mr ?>_age_6" <?php echo $curAges[5]['style'] ?> id="childmain_<?php echo $mr ?>_ages_6">

                                         <option value=""></option>

                                        <option value="1">1</option>

                                        <option vlalue="2">2</option>

                                        <option value="3">3</option>

                                        <option value="4">4</option>

                                        <option value="5">5</option>

                                        <option value="6">6</option>

                                        <option value="7">7</option>

                                        <option value="8">8</option>

                                        <option value="9">9</option>

                                        <option value="10">10</option>

                                        <option value="11">11</option>

                                        <option value="12">12</option>

                                        <option value="13">13</option>

                                        <option value="14">14</option>

                                        <option value="15">15</option>

                                        <option value="16">16</option>

                                        <option value="17">17</option>

                                    </select>

                                    <span class="ion ion-arrow-down-b"></span>

                                </div>

                                <div class="icon-control">

                                    <select class="control-field age-7" name="children_<?php echo $mr ?>_age_7" <?php echo $curAges[6]['style'] ?> id="childmain_<?php echo $mr ?>_ages_7">

                                        <option value=""></option>

                                        <option value="1">1</option>

                                        <option vlalue="2">2</option>

                                        <option value="3">3</option>

                                        <option value="4">4</option>

                                        <option value="5">5</option>

                                        <option value="6">6</option>

                                        <option value="7">7</option>

                                        <option value="8">8</option>

                                        <option value="9">9</option>

                                        <option value="10">10</option>

                                        <option value="11">11</option>

                                        <option value="12">12</option>

                                        <option value="13">13</option>

                                        <option value="14">14</option>

                                        <option value="15">15</option>

                                        <option value="16">16</option>

                                        <option value="17">17</option>

                                    </select>

                                    <span class="ion ion-arrow-down-b"></span>

                                </div>

                                <div class="icon-control">

                                    <select class="control-field age-8" name="children_<?php echo $mr ?>_age_8" <?php echo $curAges[7]['style'] ?> id="childmain_<?php echo $mr ?>_ages_8">

                                        <option value=""></option>

                                        <option value="1">1</option>

                                        <option vlalue="2">2</option>

                                        <option value="3">3</option>

                                        <option value="4">4</option>

                                        <option value="5">5</option>

                                        <option value="6">6</option>

                                        <option value="7">7</option>

                                        <option value="8">8</option>

                                        <option value="9">9</option>

                                        <option value="10">10</option>

                                        <option value="11">11</option>

                                        <option value="12">12</option>

                                        <option value="13">13</option>

                                        <option value="14">14</option>

                                        <option value="15">15</option>

                                        <option value="16">16</option>

                                        <option value="17">17</option>

                                    </select>

                                    <span class="ion ion-arrow-down-b"></span>

                                </div>

                            </div>

                            <div class="clear"></div>

                        </div>

                    </div>

                    <?php } ?>

                    <div class="search-engine-submit">

                        <button type="submit">Search</button>

                    </div>

                </div>

           </form>

            </div>

            <?php


			$nameSlug = str_replace(' ','-',$singDealx->name);


		//	$stateSlug = str_replace(' ','-',$singDealx->name);


			$citySlug = str_replace(' ','-',$singDealx->city);

			$rating ="";

			$class = "";


			if(is_array($singDealx->starRating))

			{

				$arr[0] = 0;

				$rating = "";

			}

			else

			{

				$arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$singDealx->starRating);

			}



			if($arr[0] == 1 || $arr[0] == 1.5){

				$class = "one-star";

				$rating = "1 Star Hotel";

			}

			elseif($arr[0] == 2 || $arr[0] == 2.5){

				$class = "two-star";

				$rating = "2 Star Hotel";

			}

			elseif($arr[0] == 3 || $arr[0] == 3.5){

				$class = "three-star";

				$rating = "3 Star Hotel";

			}

			elseif($arr[0] == 4 || $arr[0] == 4.5){

				$class = "four-star";

				$rating = "4 Star Hotel";

			}

			elseif($arr[0] == 5 || $arr[0] == 5.5){

				$class = "five-star";

				$rating = "5 Star Hotel";

			}

			?>

            <div class="image-product">

            	<a href="{{url('viewHotel').'/'.$citySlug.'/'.$singDealx->hotelCode}}">

                <div class="deal-of-day">
                    <img src="<?php echo $singDealx->hdImage[0]; ?>">

                    <div class="deal-of-day-content">

                        <div class="dod-top">

                            <h2>Deal of the week</h2>

                            <p>Get up to 75% off</p>

                        </div>

                        <div class="dod-btm">

                            <span class="hotel-rating <?php echo $class ?>"><?php echo $rating ?></span>

                            <h2><?php echo $singDealx->name ?></h2>

                            <p><?php echo $singDealx->city.', '.$singDealx->name; ?></p>

                        </div>

                    </div>

                </div>

                </a>

            </div>

            <div class="clear"></div>

        </div>

        <div class="section-main-2">

            <div class="title-section">

                <h2>Top 3 Picks of the Day</h2>

                <p>Take a look at our most exclusive deals of the week</p>

            </div>

            <div class="daytop-picks">

              <?php

			  foreach($Hotels as $hotel){

				$nameSlug = str_replace(' ','-',$hotel->name);

			//	$stateSlug = str_replace(' ','-',$hotel->state);

				$citySlug = str_replace(' ','-',$hotel->city);

				$rating ="";

				$class = "";

				if(is_array($hotel->starRating))

				{

					$arr[0] = 0;

					$rating = "";

				}

				else

				{

					$arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$hotel->starRating);

				}



				if($arr[0] == 1 || $arr[0] == 1.5){

					$class = "one-star";

					$rating = "1 Star Hotel";

				}

				elseif($arr[0] == 2 || $arr[0] == 2.5){

					$class = "two-star";

					$rating = "2 Star Hotel";

				}

				elseif($arr[0] == 3 || $arr[0] == 3.5){

					$class = "three-star";

					$rating = "3 Star Hotel";

				}

				elseif($arr[0] == 4 || $arr[0] == 4.5){

					$class = "four-star";

					$rating = "4 Star Hotel";

				}

				elseif($arr[0] == 5 || $arr[0] == 5.5){

					$class = "five-star";

					$rating = "5 Star Hotel";

				}

			  ?>

                <div class="one-third">

                	<a href="{{url('viewHotel').'/'.$citySlug.'/'.$hotel->hotelCode}}">

                    <img style="width:380px; height:280px;" src="<?php echo $hotel->images->image; ?>">

                    <div class="top-pick-content">

                        <div class="top-pick-position">

                            <span class="hotel-rating {{$class}}"><?php echo $rating; ?></span>

                            <h3><?php echo $hotel->name; ?></h3>

                            <p><?php echo $hotel->city.', '.$hotel->state; ?></p>

                        </div>

                    </div>

                    </a>

                </div>

              <?php } ?>

            </div>

          <div class="clear"></div>

        </div>

        <div class="section-main-3">

            <div class="title-section">

                <h2>Explore Your World</h2>

                <p>Take a look at our most exclusive deals of the week</p>

            </div>

            <div class="grid-container">

                <div class="grid">

                	<?php

					foreach($dests as $dest){

					?>

                    <div class="grid-item <?php echo $dest['layout'] ?>" <?php echo $dest['extra'] ?>>

                        <div class="masonry-box">

                        	<a href="{{url('destinations').'/'.$dest['hotelgroupcode'].'/'.str_replace(' ','-',$dest['hotelgroupname'])}}">

                        	<?php if(empty($dest['hotelgroupimage'])){ ?>

                            <img src="{{url('assets/dashboard/images/destinations/default.jpg')}}" <?php echo $dest['style'] ?>>

                            <?php }else{ ?>

                            <img src="{{url('/').'/'.$dest['hotelgroupimage']}}" <?php echo $dest['style'] ?>>

                            <?php } ?>

                        	</a>

                            <div class="m-titlenav">

                            	<h2 class="m-titlenav-h">

                                <span class="title"><?php echo $dest['hotelgroupname'] ?> Deals</span>

                                <a href="javascript:void(0)" class="toggle-list">

                                    <i class="ion ion-arrow-down-b"></i>

                                </a>

                                </h2>

                                <!--==== start of toglle list ====-->

                                <div class="m-hover-nav">

                                    <ul>

                                    	<?php foreach($dest['hotelList'] as $hlist){

										$nameSlug = str_replace(' ','-',$hlist->name);

									//	$stateSlug = str_replace(' ','-',$hlist->state);

										$citySlug = str_replace(' ','-',$hlist->city);

										$urlString = '';

//										if(empty($stateSlug))
//
//										{
//
//											$urlString = '/USA/'.$citySlug.'/'.$hlist->hotelCode;
//
//										}
//
//										else
//
//										{

											$urlString = '/'.$citySlug.'/'.$hlist->hotelCode;

//										}

										?>

                                        <li>

                                            <a href="{{url('viewHotel').$urlString}}">

											<?php echo $hlist->name ?></a>

                                        </li>

                                        <?php } ?>

                                    </ul>

                                </div>

                                <!--==== end of toglle list ======-->

                            </div>

                        </div>

                    </div>

                    <?php } ?>

                </div>

            </div>

            <div class="clear"></div>

        </div>

        <div class="section-main-4">

            <div class="title-section">

                <h2>Top Picks for You</h2>

                <p>Take a look at our most exclusive deals of the week</p>

            </div>

            <?php

            $chunk = 0;

			foreach($deals  as  $deal){

		//	$stateSlug = str_replace(' ','-',$deal->state);


              $citySlug = str_replace(' ','-',$deal->city);


              $nameSlug = str_replace(' ','-',$deal->name);

           
            $rating ="";

            $class = "";

            if(is_array($deal->starRating))
            {

				$arr[0] = 0;

				$rating = "";

			}

			else
            {

				$arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$deal->starRating);

			}


			if($arr[0] == 1 || $arr[0] == 1.5){

				$class = "one-star";

				$rating = "1 Star Hotel";

			}

			elseif($arr[0] == 2 || $arr[0] == 2.5){

				$class = "two-star";

				$rating = "2 Star Hotel";

			}

			elseif($arr[0] == 3 || $arr[0] == 3.5){

				$class = "three-star";

				$rating = "3 Star Hotel";

			}

			elseif($arr[0] == 4 || $arr[0] == 4.5){

				$class = "four-star";

				$rating = "4 Star Hotel";

			}

			elseif($arr[0] == 5 || $arr[0] == 5.5){

				$class = "five-star";

				$rating = "5 Star Hotel";

			}

			if($chunk == 0){

			echo '<div class="top-picks-row">';

			}

			?>

            <div class="one-third">

                <a href="{{url('viewHotel').'/'.$citySlug.'/'.$deal->hotelCode}}">

                <img style="width:380px; height:280px;" src="<?php echo $deal->images->image[0]; ?>">

                <div class="top-pick-content">

                    <div class="top-pick-position">

                        <span class="hotel-rating {{$class}}"><?php echo $rating; ?></span>

                        <h3><?php echo $nameSlug; ?></h3>

                        <p><?php echo $citySlug; ?></p>
                    </div>
                </div>

                </a>

            </div>

			<?php

				$chunk++;

				if($chunk == 3){

				echo '</div>';

				$chunk = 0;

				}

			}


			if($chunk < 3){

			echo '</div>';

			}


			?>
            <div class="morex"></div>

            <div class="moredeals-btn">
                <button  id="twentyx" style="font-family: AvenirNextLTPro-Regular" >View More Deals</button>
            </div>

       	</div>

       </div>
	</div>

@endsection
@section('script')
    <script>
        $('#twentyx').click(function () {

            $.ajax({
                url: "{{url('/getTDeals')}}",
                type: "post",
                data: {
                    "_token": "{{csrf_token()}}"
                },
                success: function (data) {
                    data = JSON.parse(data);

                    if(data.status==true){
                    //   $('.top-picks-row').after(data.html);
                      $('.morex').append(data.html);
                    }
                }
            })
        })
    </script>
@endsection