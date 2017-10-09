@extends('layouts.inner_main')
@section('content')
    <style>
        .outer-fac-filter {
            display: none;
        }
    </style>
    <?php
    $url = urlencode(Request::fullurl());
    ?>
    <div class="overlay">
        <div id="loading-img"></div>
    </div>
    <div class="body-section">
        <div class="container">
            <div class="search-container">
                <div class="results-top-sect">
                    <div class="rt-left">
                        <span>Showing Results for</span>
                        <h4>{{session()->get("destination")}}</h4>
                        <p id="">{{$total_result}} Deals found</p>
                        <input type="hidden" id="totalDeals" value="{{$total_result}}"/>
                    </div>
                    <div class="rt-right">
                        <ul>
                            <li><a href="javascript:void(0)" class="policy-link">Question? (000) 000-000</a></li>
                            <li><a href="javascript:void(0)" class="policy-link">Do I have to be a member to book?</a>
                            </li>
                            <li><a href="javascript:void(0)" class="policy-link">What is the cancellation policy?</a>
                            </li>
                            <li><a href="javascript:void(0)" class="policy-link">More...</a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="results-btm-sect">
                    <div class="search-container-left">
                        <h3>Filter By</h3>
                        <div class="sidebar-panel" id="appendStars">
                            <h4>Star Rating</h4>
                            <div class="sidebar-content">
                                <ul>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" id="star-5start" value="5star" class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                        </div>
                                        <span class="star-qty"><?php echo $starCount['star5'] ?></span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" name="rate[]" id="star-4start" value="4star"
                                                   class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty"><?php echo $starCount['star4'] ?></span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" name="rate[]" id="star-3start" value="3star"
                                                   class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty"><?php echo $starCount['star3'] ?></span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" name="rate[]" id="star-2start" value="2star"
                                                   class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty"><?php echo $starCount['star2'] ?></span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" name="rate[]" id="star-1start" value="1star"
                                                   class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>

                                            <i class="icon ion-android-star empty"></i>

                                        </div>

                                        <span class="star-qty"><?php echo $starCount['star1'] ?></span>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="sidebar-panel">

                            <h4>Price <label class="price-range">

                                    <input type="text" id="amount" readonly style="border:0;">

                                </label>

                            </h4>

                            <div class="sidebar-content">

                                <div id="slider-range"></div>

                            </div>

                        </div>

                        <div class="sidebar-panel">

                            <h4>Hotel Name</h4>

                            <div class="sidebar-content">

                                <input class="control-field name-filter" placeholder="Hotel name or brand" type="text"
                                       id="nameTags">

                            </div>

                        </div>

                        <div class="sidebar-panel" id="Facilities">


                        </div>


                        <div class="sidebar-panel" id="allDests">

                            <?php

                            $checkArea = session()->get("checkArea");

                            if($checkArea != "") { ?>

                            <h4>Destination</h4>

                            <div class="sidebar-content">

                                <ul class="dest-count">

                                    <li style="display:none;">

                                        <div class="rating-check" style="display:none;">

                                            <input type="checkbox" for="common-srch" data-link="check"
                                                   id="<?php echo $allDest ?>" class="allDesFilter common-dest">

                                            <i class="icon ion-checkmark-round"></i>

                                        </div>

                                        <div class="rating-stars" style="display:none;">

                                            <span>All destinations</span>

                                        </div>

                                    </li>

                                    <?php

                                    $counter = 0;

                                    foreach($destsCount as $key => $value){

                                    ?>

                                    <li>

                                        <div class="rating-check">

                                            <input type="checkbox" id="<?php echo $key ?>"
                                                   class="dest-filters common-dest" for="common-srch"
                                                   data-link="dset-<?php echo $counter ?>">

                                            <i class="icon ion-checkmark-round"></i>

                                        </div>

                                        <div class="rating-stars">

                                            <span><?php echo $key ?></span>

                                        </div>

                                        <span class="star-qty"><?php echo $destsCount[$key] ?></span>

                                    </li>

                                    <?php $counter++; } ?>

                                </ul>

                            </div>

                            <?php } ?>

                        </div>

                    </div>

                    <div class="search-container-right">

                        <div class="row search-module-container">

                            <div class="tabs-btn">

                                <span class="sort-by">Sort By</span>

                                <ul id="tabs" class="tab-list">
                                    <li><a href="" id="recomended"  class="recommended">Recommended</a></li>
                                    <li><a href="#tab2" id="price"  onclick="getFilterHotels(this)"  class="price sortByPrice">Price</a></li>
                                    <li><a href="#tab3" id="stars"  onclick="getFilterHotels(this)"  class="stars">Star Rating</a></li>
                                    <li><a href="#tab4" id="names"  onclick="getFilterHotels(this)"  class="hotels">Hotel Name</a></li>
                                    <li><a href="#tab5" id="vacations" onclick="getFilterHotels(this)" class="vacation">Vacation Rentals</a></li>
                                </ul>
                                <div class="share-dropdown-link">
                                    <span class="share-droplink">Share<i class="icon ion-arrow-down-b"></i></span>
                                    <div class="share-dropdown">
                                        <h3>Share this hotel list</h3>
                                        <div class="share-dropdown-body">

                                            <ul>

                                                <li>

                                                    <?php

                                                    $mailurl = 'Subject= Travel Linked';

                                                    $mailurl .= '&Body= vivsit link to see hotel lists :' . $url;

                                                    ?>
                                                    <a href="mailto:?{{$mailurl}}" class="email-link">
                                                        <i class="fa fa-paper-plane"></i>Share with Email
                                                    </a>

                                                </li>

                                                <li>

                                                    <?php

                                                    $fburl = 'title=' . urlencode('Travel Linked');

                                                    $fburl .= '&picture=' . url('assets/images/share.jpg');

                                                    $fburl .= '&description= visit this link to see hotels list';

                                                    $fburl .= '&u=' . $url;

                                                    ?>

                                                    <a href="http://www.facebook.com/sharer.php?{{$fburl}}"
                                                       target="_blank" class="fb-link">

                                                        <i class="fa fa-facebook"></i>Share with Facebook

                                                    </a>

                                                </li>

                                                <li>

                                                    <?php

                                                    $twitterurl = 'text= visit this link to check hotels list';

                                                    $twitterurl .= '&url=' . $url;

                                                    ?>

                                                    <a href="https://twitter.com/share?{{$twitterurl}}" target="_blank"
                                                       class="twtr-link">

                                                        <i class="fa fa-twitter"></i>Share with Twitter

                                                    </a>

                                                </li>

                                                <li>

                                                    <?php

                                                    $gplusurl = '&url=' . $url;

                                                    ?>

                                                    <a href="https://plus.google.com/share?{{$gplusurl}}"
                                                       target="_blank" class="google-link">

                                                        <i class="fa fa-google-plus"></i>Share with Google

                                                    </a>

                                                </li>

                                            </ul>

                                            <div class="share-copylink">

                                                <span>Copy & paste the following link to share your hotel list with others</span>

                                                <input type="text" value="{{Request::fullurl()}}" readonly="readonly">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            {{--The below divs class are used to display search records of different tab views in a certain manner--}}
                        <div class="tabs-content">
                            <div class="tab-container recommended filter-data" id="tab1"></div>
                            <div class="tab-container sort_price filter-data" id="tab2"></div>
                            <div class="tab-container sort_star filter-data" id="tab3"></div>
                            <div class="tab-container sort_hotels filter-data" id="tab4"></div>
                            {{--The above divs class are used to display search records of different tab views in a certain manner--}}
                        </div>
                        <div class="clear"></div>

                    </div>

                    <div class="clear"></div>

                </div>

            </div>

        </div>

    </div>

    </div>

    <div id="infscr-loading" style="display: none;">

        <img alt="Loading..." style="width:50px; height:50px;" src="{{url('assets/images/loader.gif')}}">

        <div style="opacity: 1;" id="textMsg">Loading...</div>

    </div>

    <div id="maxPrice" class="{{$maxPrice}}" style="display:none;"></div>
    <?php
    if(isset($minPrice)){ ?>

    <div id="minPrice" class="{{$minPrice}}" style="display:none;"></div>

    <?php
    }
    else{
    ?>
    <div id="minPrice" class="0" style="display:none;"></div>
    <?php }?>
@endsection
@section('script')
    <script>
        $(function () {
            $('.tab-list li a').on('click', function () {
                $(".tab-list li").removeClass('active');
                $(this).parent('li').addClass('active');
            });
        });
    </script>
@endsection