@extends('layouts.main')

@section('content')

<div class="body-section">
		<div class="container">
        	<div class="section-main-nav">
            	<ul>
                	<li>
                    	<a href="#">Find a Deal</a>
                    </li>
                	<li>
                    	<a href="#">List Your Property</a>
                    </li>
                	<li>
                    	<a href="#">Travel Agents</a>
                    </li>
                	<li>
                    	<a href="#">Become an Affiliate</a>
                    </li>
                	<li>
                    	<a href="#">Travel Linked for Business</a>
                    </li>
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
                            <label>Where are you going?</label>
                            <div class="icon-control input-div">
                            <input type="hidden" name="id" id="input_hotel">
                                <input type="text" class="control-field search_hotel" autocomplete="off" name="location_name" placeholder="Enter destination or city">
                                <datalist class="search_result"></datalist>
                                <span class="ion ion-ios-search"></span>
                            </div>
                        </div>
                        <div class="search-engine-row">
                            <div class="rows-3">
                                <div class="w-180">
                                    <label>Check In</label>
                                    <div class="icon-control">
                                        <input type="text" id="datepicker_in" name="checkin" class="control-field" placeholder="mm/dd/yyyy">
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="w-180">
                                    <label>Check Out</label>
                                    <div class="icon-control">
                                        <input type="text" id="datepicker_out" name="checkout" class="control-field" placeholder="mm/dd/yyyy">
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="w-54">
                                    <label>Nights</label>
                                    <div class="nights-select">
                                        <select class="control-field" id="nights" name="nights">
                                             <option value=""> 0</option>

										<option value="1">1 </option>



                                            <option value="2">2 </option>



                                            <option value="3">3 </option>



                                            <option value="4">4 </option>



                                            <option value="5">5 </option>



                                            <option value="6">6 </option>



                                            <option value="7">7 </option>



                                            <option value="8">8 </option>



                                            <option value="9">9 </option>



                                            <option value="10">10 </option>



                                            <option value="11">11 </option>



                                            <option value="12">12 </option>



                                            <option value="13">13 </option>



                                            <option value="14">14 </option>



                                            <option value="15">15 </option>



                                            <option value="16">16 </option>



                                            <option value="17">17 </option>



                                            <option value="18">18 </option>



                                            <option value="19">19 </option>



                                            <option value="20">20 </option>



                                            <option value="21">21 </option>



                                            <option value="22">22 </option>



                                            <option value="23">23 </option>



                                            <option value="24">24 </option>



                                            <option value="25">25 </option>



                                            <option value="26">26 </option>



                                            <option value="27">27 </option>



                                            <option value="28">28 </option>



                                            <option value="29">29 </option>



                                            <option value="30">30 </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="search-engine-row">
                            <div class="rows-3">
                                <div class="w-100">
                                    <label>Rooms</label>
                                    <div class="icon-control">
                                        <select class="control-field" id="rooms_count" name="num_rooms">
                                            <option value="1">1 Room</option>
                                            <option value="2">2 Rooms</option>
                                            <option value="3">3 Rooms</option>
                                            <option value="4">4 Rooms</option>
                                            <option value="5">5 Rooms</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    
                                    <!--<input type="text"  class="control-field" readonly name="total_adults" value="0" id="total-adults">
                                    <input type="text"  class="control-field" readonly name="total_childs" value="0" id="total-childs">-->

                                    
                                </div>
                                <div class="w-157">
                                    <label>Adults</label>
                                    <div class="icon-control">
                                        <select class="control-field" id="adult-1" name="adults_1">
                                           <option value="0">0 Adults</option>
                                             <option value="1">1 Adults</option>
                                             <option value="2">2 Adults</option>
                                              <option value="3">3 Adults</option>
                                               <option value="4">4 Adults</option>
                                            <option value="5">5 Adults</option>
                                        </select> 
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="w-157">
                                    <label>Children</label>
                                    <div class="icon-control">
                                        <select class="control-field select-child-1" name="children_1" id="total_child1">
                                        <option value="0">0 Child</option>
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
                            <div class="chldr-age-row Children-1" style="display:none;">
                            	<label>Children’s Ages (0 - 17)</label>
                                <div class="age-select-boxes">
                                    <div class="icon-control">
                                        <select class="control-field age-1" name="children_1_age_1">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-2" name="children_1_age_2">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-3" name="children_1_age_3">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-4" name="children_1_age_4">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-5" name="children_1_age_5">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-6" name="children_1_age_6">
                                             <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-7" name="children_1_age_7">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-8" name="children_1_age_8">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                       <div class="clone">
                        <div class="search-engine-row cloned" style="display:none;">
                        	<div class="rm-num-row">
                            	<div class="room-label">
                                	<label>Room 2</label>
                                </div>
                                <div class="w-158">
                                    <label>Adults</label>
                                    <div class="icon-control">
                                        <select class="control-field" id="adult-2" name="adults_2">
                                            <option value="0">0 Adults</option>
                                             <option value="1">1 Adults</option>
                                             <option value="2">2 Adults</option>
                                              <option value="3">3 Adults</option>
                                               <option value="4">4 Adults</option>
                                            <option value="5">5 Adults</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="w-158">
                                    <label>Children</label>
                                    <div class="icon-control">
                                        <select class="control-field select-child-2" name="children_2" id="total_child2">
                                        <option value="0">0 Child</option>
                                             
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
                            </div>
                            <div class="chldr-age-row Children-2" style="display:none;">
                            	<label>Children’s Ages (0 - 17)</label>
                                <div class="age-select-boxes">
                                    <div class="icon-control">
                                        <select class="control-field age-1" disabled="disabled" name="children_2_age_1">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-2" disabled="disabled" name="children_2_age_2">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-3" disabled="disabled" name="children_2_age_3">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-4" disabled="disabled" name="children_2_age_4">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-5" disabled="disabled" name="children_2_age_5">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-6" disabled="disabled" name="children_2_age_6">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-7" disabled="disabled" name="children_2_age_7">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field age-8" disabled="disabled" name="children_2_age_8">
                                            <option value="0">0</option>
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
                                            <option value="11">11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        
                      
                       </div>
                      <div class="append-html">
                      
                      
                      </div> 
                      
                       <!-- <div class="search-engine-row">
                        	<div class="rm-num-row">
                            	<div class="room-label">
                                	<label>Room 3</label>
                                </div>
                                <div class="w-158">
                                    <label>Adults</label>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>2 Adults</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="w-158">
                                    <label>Children</label>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>8 Children</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="chldr-age-row">
                            	<label>Children’s Ages (0 - 17)</label>
                                <div class="age-select-boxes">
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>12</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>13</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>8</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field" disabled="disabled">
                                            <option>6</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field" disabled="disabled">
                                            <option>4</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field" disabled="disabled">
                                            <option>16</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field" disabled="disabled">
                                            <option>1</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="search-engine-row">
                        	<div class="rm-num-row">
                            	<div class="room-label">
                                	<label>Room 4</label>
                                </div>
                                <div class="w-158">
                                    <label>Adults</label>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>2 Adults</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="w-158">
                                    <label>Children</label>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>8 Children</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="chldr-age-row">
                            	<label>Children’s Ages (0 - 17)</label>
                                <div class="age-select-boxes">
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>12</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>13</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>11</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field">
                                            <option>8</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field" disabled="disabled">
                                            <option>6</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field" disabled="disabled">
                                            <option>4</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field" disabled="disabled">
                                            <option>16</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                    <div class="icon-control">
                                        <select class="control-field" disabled="disabled">
                                            <option>1</option>
                                        </select>
                                        <span class="ion ion-arrow-down-b"></span>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>-->
                        
                        <div class="search-engine-submit">
                            <button type="submit">Search</button>
                        </div>
                    </div>
               </form>     
                </div>
                <div class="image-product">
                	<div class="deal-of-day">
                    	<img src="{{url('/assets/images/img-5.jpg')}}">
                        <div class="deal-of-day-content">
                        	<div class="dod-top">
                            	<h2>Deal of the week</h2>
                                <p>Get up to 75% off</p>
                            </div>
                            <div class="dod-btm">
                            	<span class="hotel-stars">5 Star Hotel</span>
                                <h2>Fontainebleau Miami Beach</h2>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>  
            <div class="section-main-2">
            	<div class="title-section">
                	<h2>Top 3 Picks of the Day</h2>
                    <p>Take a look at our most exclusive deals of the week</p>
                </div>
                <div class="daytop-picks">
                	<div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating five-star">5 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating five-star">5 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating five-star">5 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                </div>
            	<div class="clear"></div>
            </div>
            <div class="section-main-3">
            	<div class="title-section">
                	<h2>Explore Your World</h2>
                    <p>Take a look at our most exclusive deals of the week</p>
                </div>
				<div class="grid-container">
					<div class="grid ">
						<div class="grid-item col-one-third">
							<div class="masonry-box">
								<img src="{{url('/assets/images/img-4.jpg')}}">
								<div class="m-titlenav">
									<span class="title">New York Deals</span>
									<a href="#" class="toggle-list">
										<i class="icon ion-android-arrow-dropdown"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="grid-item col-two-third">
							<div class="masonry-box">
								<img src="{{url('/assets/images/img-3.jpg')}}">
								<div class="m-titlenav">
									<span class="title">New York Deals</span>
									<a href="#" class="toggle-list">
										<i class="icon ion-android-arrow-dropdown"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="grid-item col-one-third">
							<div class="masonry-box">
								<img src="{{url('/assets/images/img-2.jpg')}}">
								<div class="m-titlenav">
									<span class="title">New York Deals</span>

									<a href="#" class="toggle-list">
										<i class="icon ion-android-arrow-dropdown"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="grid-item col-one-third">
							<div class="masonry-box">
								<img src="{{url('/assets/images/img-2.jpg')}}">
								<div class="m-titlenav">
									<span class="title">New York Deals</span>
									<a href="#" class="toggle-list">
										<i class="icon ion-android-arrow-dropdown"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="grid-item col-one-third">
							<div class="masonry-box">
								<img src="{{url('/assets/images/img-2.jpg')}}">
								<div class="m-titlenav">
									<span class="title">New York Deals</span>
									<a href="#" class="toggle-list">
										<i class="icon ion-android-arrow-dropdown"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="grid-item col-one-third">
							<div class="masonry-box">
								<img src="{{url('/assets/images/img-2.jpg')}}">
								<div class="m-titlenav">
									<span class="title">New York Deals</span>
									<a href="#" class="toggle-list">
										<i class="icon ion-android-arrow-dropdown"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="clear"></div>
            </div>
            <div class="section-main-4">
            	<div class="title-section">
                	<h2>Top Picks for You</h2>
                    <p>Take a look at our most exclusive deals of the week</p>
                </div>
            	<div class="top-picks-row">
                	<div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating five-star">5 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating four-star">4 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating three-star">3 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="top-picks-row">
                	<div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating five-star">5 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating four-star">4 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating three-star">3 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="top-picks-row">
                	<div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating five-star">5 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating four-star">4 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                    	<img src="{{url('/assets/images/img-2.jpg')}}">
                        <div class="top-pick-content">
                        	<div class="top-pick-position">
                                <span class="hotel-rating three-star">3 Star Hotel</span>
                                <h3>Fontainebleau Miami Beach</h3>
                                <p>Miami Beach, Florida</p>
                            </div>
                        </div>
                    </div>
				</div>            
			</div>	
			


@endsection


