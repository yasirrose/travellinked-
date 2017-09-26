@extends('layouts.inner_main')

@section('content')

<style>

#loading-img {
    background: url(http://preloaders.net/preloaders/360/Velocity.gif) center center no-repeat;
    height: 100%;
    z-index: 20;
}

.overlay {
    background: #e9e9e9;
    display: none;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    opacity: 0.5;
}


</style>

<div class="overlay">
    <div id="loading-img"></div>
</div>

<div class="body-section">
		<div class="container">
			<div class="search-container">
            	<div class="results-top-sect">
                    <div class="rt-left">
                        <span>Showing Results for</span>
                        <h4>{{$search_name}}</h4>
                        <p>{{$total_result}} Deals found</p>
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
                    	<h3>Filter By <a href="#" class="clear-search">Clear all</a></h3>
                        <div class="sidebar-panel">
                        	<h4>Star Rating</h4>
                            <div class="sidebar-content">
                                <ul>
                                	 <li>
                                        <div class="rating-check">
                                            <input type="checkbox" id="star-5" value="5star" class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                        </div>
                                        <span class="star-qty" ><?php echo $star5 =="" ? '0' : $star5; ?></span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" name="rate[]" id="star-4" value="4star" class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty" ><?php echo $star4 =="" ? '0' : $star4; ?></span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" name="rate[]" id="star-3" value="3star" class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty" ><?php echo $star3 =="" ? '0' : $star3; ?></span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" name="rate[]" id="star-2" value="2star" class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty" ><?php echo $star2 =="" ? '0' : $star2; ?></span>
                                    </li>
                                    <li>
                                        <div class="rating-check">
                                            <input type="checkbox" name="rate[]" id="star-1" value="1star" class="star-filter">
                                            <i class="icon ion-checkmark-round"></i>
                                        </div>
                                        <div class="rating-stars">
                                        	<i class="icon ion-android-star"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                            <i class="icon ion-android-star empty"></i>
                                        </div>
                                        <span class="star-qty" ><?php echo $star1 =="" ? '0' : $star1; ?></span>
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
                                <input class="control-field name-filter" placeholder="Hotel name or brand" type="text">
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
                                <li><a href="#tab1" class="recommended">Recommended</a></li>
                                <li><a href="#tab2" class="price">Price</a></li>
                                <li><a href="#tab3" class="stars">Star Rating</a></li>
                                <li><a href="#tab4" class="hotels">Hotel Name</a></li>
                                <li><a href="#tab5" class="vacation">Vacation Rentals</a></li>
                            </ul>
                            <span class="share-droplink">Share<i class="icon ion-arrow-down-b"></i></span>
                        </div>
                        
                        <div class="tabs-content">
      
	
         <div class="tab-container filter-data" id="tab1">
                            
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
                <?php
				$arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$Hotels["starRating"]);                                                               
				
				if($arr[0] == 1){
					$class = "one-star";
				}
				if($arr[0] == 2){
					$class = "two-star";
				}
				if($arr[0] == 3){
					$class = "three-star";
				}
				if($arr[0] == 4 || $arr[0] == 4.5){
					$class = "four-star";
				}
				if($arr[0] == 5 || $arr[0] == 5.5){
					$class = "five-star";
				}
					
				 ?>
                    <span class="hotel-rating {{$class}}"> <?php echo $Hotels["starRating"]." Hotel"; ?> </span>
                    <div class="hotel-name-price">
                        <div class="left-align"><?php echo $Hotels["name"]; ?> <span><?php echo $Hotels["address"] .", ". $Hotels["city"]; ?></span></div>
                       <?php $newrates = 0;
						$rates = $Hotels["roomInformation"][0]["rateInformation"]["averageRate"];
						$newtotal = str_replace( ',', '', $rates );
					    $newrates += $newtotal; 
						
						
						?>
                        <div class="right-align">$ <?php echo round($newrates/$nights,2); ?><span>/night</span></div>
                    </div>
                    <p>
      <?php 
	 if(isset($Hotels["shortDescription"])) {
		@$pos=strpos($Hotels["shortDescription"], ' ', 150);
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
                            
                         
          <div class="tab-container sort_price" id="tab2">
                          
		   </div>
           
            <div class="tab-container sort_star" id="tab3">
                
            </div>
                            
            <div class="tab-container sort_hotels" id="tab4">
                
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


