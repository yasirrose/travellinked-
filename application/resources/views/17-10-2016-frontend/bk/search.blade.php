@extends('layouts.inner_main')

@section('content')

<div class="body-section">
		<div class="container">
			<div class="search-container">
            	<div class="results-top-sect">
                    <div class="rt-left">
                        <span>Showing Results for</span>
                        <h4>Miami Beach Florida</h4>
                        <p>140 Deals found</p>
                    </div>
                    <div class="rt-right">
                    	<ul>
                        	<li>
                            	<a href="#">Question? (000) 000-000</a>
                            </li>
                            <li>
                            	<a href="#">Do I have to be a member to book?</a>
                            </li>
                            <li>
                            	<a href="#">What is the cancellation policy?</a>
                            </li>
                            <li>
                            	<a href="#">More...</a>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="results-btm-sect">
                    <div class="search-container-left">
                    	<h3>Filter By <a href="#">Clear all</a></h3>
                        <div class="sidebar-panel">
                        	<h4>Star Rating</h4>
                            <div class="sidebar-content">
                                <ul>
                                	 <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                        </div>
                                        <span class="star-qty" >17</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty" >8</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty" >4</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty" >0</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-panel">
                        	<h4>Price <label class="price-range"><input type="text" id="amount" readonly style="border:0;"></label></h4>
                            <div class="sidebar-content">
                                <div id="slider-range"></div>
                            </div>
                        </div>
                        <div class="sidebar-panel">
                        	<h4>Hotel Name</h4>
                            <div class="sidebar-content">
                                <input class="control-field" placeholder="Hotel name or brand" type="text">
                            </div>
                        </div>
                        <div class="sidebar-panel">
                        	<h4>Amenities</h4>
                            <div class="sidebar-content">
                                <ul>
                                	 <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>All amenities</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Free Wifi</span>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Gym</span>
                                        </div>
                                        <span class="star-qty" >17</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Spa</span>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Restaurant</span>
                                        </div>
                                        <span class="star-qty" >17</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Bar</span>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Pool</span>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                </ul>
                                <a class="see-more" href="#"><i class="icon ion-ios-arrow-thin-down"></i>See more</a>
                            </div>
                        </div>
                        <div class="sidebar-panel">
                        	<h4>Destination</h4>
                            <div class="sidebar-content">
                                <ul>
                                	 <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>All destinations</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Miami Beach, Florida</span>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>South Beach</span>
                                        </div>
                                        <span class="star-qty" >17</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>South Beach</span>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Miami Florida</span>
                                        </div>
                                        <span class="star-qty" >17</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Sunny Isles</span>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<span>Pool</span>
                                        </div>
                                        <span class="star-qty" >9</span>
                                    </li>
                                </ul>
                                <a class="see-more" href="#"><i class="icon ion-ios-arrow-thin-down"></i>See more</a>
                            </div>
                        </div>
                    </div>
                    <div class="search-container-right">
                    
                      <div class="row search-module-container">
      
                    
                    
                    	<div class="tabs-btn">
                        	<span class="sort-by">Sort By</span>
                            <ul id="tabs" class="tab-list">
                                <li><a href="#tab1">Recommended</a></li>
                                <li><a href="#tab2">Price</a></li>
                                <li><a href="#tab3">Star Rating</a></li>
                                <li><a href="#tab4">Hotel Name</a></li>
                                <li><a href="#tab5">Vacation Rentals</a></li>
                            </ul>
                            <span class="share-droplink">Share<i class="icon ion-arrow-down-b"></i></span>
                        </div>
                        
                        <div class="tabs-content">
      
	
                        	<div class="tab-container" id="tab1">
                            
        <?php 
	   if (!empty($message)) 
		{
		   echo $message;
		   
		}else{ ?>
		  <?php
          foreach($Harr as $Hotels){ 
            $url = "http://api.bonotel.com/index.cfm/user/luxVaRLive_xml/action/hotel/hotelCode/".$Hotels["hotelCode"];
            $url1 = "http://api.bonotel.com/index.cfm/user/luxVaRLive_xml/action/facility/hotelCode/".$Hotels["hotelCode"];
        
            $result = file_get_contents($url);
            $result1 = file_get_contents($url1);
            $images = simplexml_load_string($result);
            $facility = simplexml_load_string($result1);
		  
         ?>
               <div class="hotel-desp-box">
                <div class="hotel-img">
                <img style="height:200px; width:300px;" src="<?php echo $images->hotel->images->image; ?>">
                    
                </div>
                <div class="hotel-desp">
                    <span class="hotel-rating four-star"> <?php echo $Hotels["starRating"]." Hotel"; ?> </span>
                    <div class="hotel-name-price">
                        <div class="left-align"><?php echo $Hotels["name"]; ?> <span><?php echo $Hotels["address"] .", ". $Hotels["city"]; ?></span></div>
                       <?php $total = 0;
				
				//error_reporting(0);
				
					    $total += $Hotels["roomInformation"][0]["rateInformation"]["averageRate"]; ?>
                        <div class="right-align">$ {{ round($total/$nights,2)}}<span>/night</span></div>
                    </div>
                    <p>
      <?php 
	 if(isset($Hotels["shortDescription"])) {
		@$pos=strpos($Hotels["shortDescription"], ' ', 180);
		echo substr($Hotels["shortDescription"],0,$pos )." "."..."; }
	  ?>
          </p>
                                        <div class="hotel-links">
                                            <div class="left-align">
                                                <ul>
                                                    <li>
                                                        <a href="#">Overview</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Room Details</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right-align">
                                                <a href="#">Book Room<i class="ion-ios-arrow-thin-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                            	</div>  
             <?php 
			 
			 }} ?>                 
                          
                   </div>
                            
                         
                            <div class="tab-container" id="tab2">
                            	<div class="hotel-desp-box">
                                    <div class="hotel-img">
                                        <img src="{{url('/assets/images/img-6.jpg')}}">
                                    </div>
                                    <div class="hotel-desp">
                                        <span class="hotel-rating four-star">4 Star Hotel</span>
                                        <div class="hotel-name-price">
                                            <div class="left-align">Fontainebleau Miami Beach<span>Miami Beach, Florida</span></div>
                                            <div class="right-align">$239<span>/night</span></div>
                                        </div>
                                        <p>This luxe property with buzzing nightlife on Miami Beach, designed in the 1950s by architect Morris Lapidus, is 1.5 miles from Interstate 195, which travels from the Airport Expressway ...</p>
                                        <div class="hotel-links">
                                            <div class="left-align">
                                                <ul>
                                                    <li>
                                                        <a href="#">Overview</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Room Details</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right-align">
                                                <a href="#">Book Room<i class="ion-ios-arrow-thin-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                            	</div>
                                <div class="hotel-desp-box">
                                    <div class="hotel-img">
                                        <img src="{{url('/assets/images/img-6.jpg')}}">
                                    </div>
                                    <div class="hotel-desp">
                                        <span class="hotel-rating four-star">4 Star Hotel</span>
                                        <div class="hotel-name-price">
                                            <div class="left-align">Fontainebleau Miami Beach<span>Miami Beach, Florida</span></div>
                                            <div class="right-align">$239<span>/night</span></div>
                                        </div>
                                        <p>This luxe property with buzzing nightlife on Miami Beach, designed in the 1950s by architect Morris Lapidus, is 1.5 miles from Interstate 195, which travels from the Airport Expressway ...</p>
                                        <div class="hotel-links">
                                            <div class="left-align">
                                                <ul>
                                                    <li>
                                                        <a href="#">Overview</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Room Details</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right-align">
                                                <a href="#">Book Room<i class="ion-ios-arrow-thin-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                            	</div>
                            </div>
                            <div class="tab-container" id="tab3">
                            	<div class="hotel-desp-box">
                                    <div class="hotel-img">
                                        <img src="{{url('/assets/images/img-6.jpg')}}">
                                    </div>
                                    <div class="hotel-desp">
                                        <span class="hotel-rating four-star">4 Star Hotel</span>
                                        <div class="hotel-name-price">
                                            <div class="left-align">Fontainebleau Miami Beach<span>Miami Beach, Florida</span></div>
                                            <div class="right-align">$239<span>/night</span></div>
                                        </div>
                                        <p>This luxe property with buzzing nightlife on Miami Beach, designed in the 1950s by architect Morris Lapidus, is 1.5 miles from Interstate 195, which travels from the Airport Expressway ...</p>
                                        <div class="hotel-links">
                                            <div class="left-align">
                                                <ul>
                                                    <li>
                                                        <a href="#">Overview</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Room Details</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right-align">
                                                <a href="#">Book Room<i class="ion-ios-arrow-thin-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                            	</div>
                            </div>
                            <div class="tab-container" id="tab4">
                            	<div class="hotel-desp-box">
                                    <div class="hotel-img">
                                        <img src="{{url('/assets/images/img-6.jpg')}}">
                                    </div>
                                    <div class="hotel-desp">
                                        <span class="hotel-rating four-star">4 Star Hotel</span>
                                        <div class="hotel-name-price">
                                            <div class="left-align">Fontainebleau Miami Beach<span>Miami Beach, Florida</span></div>
                                            <div class="right-align">$239<span>/night</span></div>
                                        </div>
                                        <p>This luxe property with buzzing nightlife on Miami Beach, designed in the 1950s by architect Morris Lapidus, is 1.5 miles from Interstate 195, which travels from the Airport Expressway ...</p>
                                        <div class="hotel-links">
                                            <div class="left-align">
                                                <ul>
                                                    <li>
                                                        <a href="#">Overview</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Room Details</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right-align">
                                                <a href="#">Book Room<i class="ion-ios-arrow-thin-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                            	</div>        
                                <div class="hotel-desp-box">
                                    <div class="hotel-img">
                                        <img src="{{url('/assets/images/img-6.jpg')}}">
                                    </div>
                                    <div class="hotel-desp">
                                        <span class="hotel-rating four-star">4 Star Hotel</span>
                                        <div class="hotel-name-price">
                                            <div class="left-align">Fontainebleau Miami Beach<span>Miami Beach, Florida</span></div>
                                            <div class="right-align">$239<span>/night</span></div>
                                        </div>
                                        <p>This luxe property with buzzing nightlife on Miami Beach, designed in the 1950s by architect Morris Lapidus, is 1.5 miles from Interstate 195, which travels from the Airport Expressway ...</p>
                                        <div class="hotel-links">
                                            <div class="left-align">
                                                <ul>
                                                    <li>
                                                        <a href="#">Overview</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Room Details</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right-align">
                                                <a href="#">Book Room<i class="ion-ios-arrow-thin-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                            	</div>
                                <div class="hotel-desp-box">
                                    <div class="hotel-img">
                                        <img src="{{url('/assets/images/img-6.jpg')}}">
                                    </div>
                                    <div class="hotel-desp">
                                        <span class="hotel-rating four-star">4 Star Hotel</span>
                                        <div class="hotel-name-price">
                                            <div class="left-align">Fontainebleau Miami Beach<span>Miami Beach, Florida</span></div>
                                            <div class="right-align">$239<span>/night</span></div>
                                        </div>
                                        <p>This luxe property with buzzing nightlife on Miami Beach, designed in the 1950s by architect Morris Lapidus, is 1.5 miles from Interstate 195, which travels from the Airport Expressway ...</p>
                                        <div class="hotel-links">
                                            <div class="left-align">
                                                <ul>
                                                    <li>
                                                        <a href="#">Overview</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Room Details</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right-align">
                                                <a href="#">Book Room<i class="ion-ios-arrow-thin-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                            	</div>
                            </div>
                            
                            
                           	
                        </div>
                        
                    	<div class="clear"></div>
                    </div>
					<div class="clear"></div>
                </div>
			</div>
		</div>
	</div>
    

			


@endsection


