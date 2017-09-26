@extends('adminlayouts.main')
@section('content')
<style type="text/css">
.datepicker-container{
	left: 0;
	position: absolute;
	top: 100%;
	z-index: 9;
}
</style>
<!--main content-->
<div class="admin-wrapper">
    <div class="admin-wrap-head">
        <div class="admin-w-left"> <i class="fa fa-check-square-o"></i> <span class="admin-breadcrumb"><a href="#">Booking</a> /</span> <span>Create Booking</span> </div>
        <div class="admin-w-right">
            <button class="btn btn-save">Create Booking</button>
        </div>
    </div>
    <div class="admin-wrap-inner"> @include('flash.flash')
		<div class="booking-detail create-booking">
            <div class="booking-detail-left">
                <div class="booking-detail-box">
                    <h2>Booking Detail</h2>
                    <div class="search-engine">
                        <form>
                            <div class="destination-autofill">
                                <input placeholder="Where you going?" class="control-field search_hotel" type="text" autocomplete="off" name="location_name" id="create_booking_search_hotel">
                                <div class="search-list-holder">
                                    <datalist class="search_result"></datalist> 
                                </div>
                            </div>
                            <div class="staying-days">
                            	<input type="hidden" id="nights" name="nights" />
                                <input class="control-field" type="text" id="datepicker_in" name="checkin" placeholder="mm/dd/yyyy">
                            	<span class="check-arrow">
                                <i class="icon ion-ios-arrow-thin-right"></i>
                            	</span>
                                <input type="text" id="datepicker_out" name="checkout" class="control-field" placeholder="mm/dd/yyyy">
                                <div class="datepicker-container" id="main_date_container" style=""></div>
                                <input type="hidden" class="datepicker_in" />
								<div class="main_tooltip"></div>
                            </div>
                            <div class="rooms-and-guests horiz-search">
                                <div class="icon-control">
                                    <input value="1 rooms,2 guests" class="control-field horiz-search" type="text" id="create_booking_guests">
                                    <span class="ion ion-arrow-down-b horiz-search"></span>
                                </div>
                                @include('frontend.partial_rooms')
                            </div>
                        </form>
                    </div>
                </div>
				<div class="booking-detail-box">
					<div class="booking-top-filter">
						<div class="left">
							<label>Label</label>
						</div>
						<div class="right">
							<div class="icon-control">
								<select class="control-field">
									<option>Choose</option>
								</select>
								<span class="ion ion-arrow-down-b"></span>
							</div>
						</div>
					</div>
				</div>
                <div class="booking-detail-box">
                    <div class="rooms-list">
                        <div class="room-label">Room 1</div>
                        <div class="qty-inroom">2 Adults, 2 Children</div>
                        <div class="room-opt-select">
                            <div class="icon-control">
                                <select class="control-field" >
                                    <option>Standard Excl Resort Fee</option>
                                </select>
                            <span class="ion ion-arrow-down-b"></span>
                            </div>
                        </div>
                        <div class="room-single-amount">
                            <input type="text" value="$2005" class="control-field">
                        </div>
                    </div>
                    <div class="rooms-list">
                        <div class="room-label">Room 1</div>
                        <div class="qty-inroom">2 Adults, 2 Children</div>
                        <div class="room-opt-select">
                            <div class="icon-control">
                                <select class="control-field" >
                                    <option>Standard Excl Resort Fee</option>
                                </select>
                            <span class="ion ion-arrow-down-b"></span>
                            </div>
                        </div>
                        <div class="room-single-amount">
                        
                        </div>
                    </div>
                </div>
                <div class="booking-detail-box">
                    <div class="notes-field">
                        <label>Notes</label>
                        <input class="control-field" type="text" placeholder="Add a note...">
                    </div>
                    <div class="room-invioce-box">
                        <div class="room-invioce-row">
                            <div class="left"><span>Add discount</span></div>
                            <div class="right"><span>- $5</span></div>
                        </div>
                        <div class="room-invioce-row">
                            <div class="left">Subtotal</div>
                            <div class="right">$6,000</div>
                        </div>
                        <div class="room-invioce-row">
                            <div class="left"><span>Taxes</span></div>
                            <div class="right">$100</div>
                        </div>
                        <div class="room-invioce-row">
                            <div class="left">Hotel fees (due at hotel)</div>
                            <div class="right">$227.60</div>
                        </div>
                        <div class="room-invioce-row">
                            <div class="left"><strong>Estimated grand total</strong></div>
                            <div class="right"><strong>$6,327.60</strong></div>
                        </div>
                        <div class="room-invioce-row sub-total">
                            <div class="left">Due now</div>
                            <div class="right">$6,100</div>
                        </div>
                    </div>
                </div>
                <div class="booking-detail-box">
                    <div class="crt-booking-btns">
                        <div class="left">EMAIL INVOICE</div>
                        <div class="right">
                            <button class="crt-btn crt-btn-primary">Email invoice</button>
                        </div>
                    </div>
                </div>
                <div class="booking-detail-box">
                    <div class="crt-booking-btns">
                        <div class="left">ACCEPT PAYMENT</div>
                        <div class="right">
                            <button class="crt-btn crt-btn-default">Mark as paid</button>
                            <button class="crt-btn crt-btn-default">Mark as pending</button>
                            <button class="crt-btn crt-btn-primary">Pay with credit card</button>
                        </div>
                    </div>
                </div>
            </div>
        <div class="booking-detail-right">
            <div class="detail-right-box-top">
                <div class="detail-right-box">
                    <h2>Customer <span class="customers-orders">1 order</span></h2>
                    <div class="customers-detail-sec">
                        <p><span class="clr-blue">User</span></p>
                        <p class="customer-category">Wholesaler</p>
                        <p class="discount-content">Customer recieves discount of 10% &amp; $5 off</p>
                    </div>
                </div>
                <div class="detail-right-box">
                    <h2>Contact<a class="Change-orders" href="#">Change</a></h2>
                    <div class="customer-user-list">
                        <ul>
                            <li><p>User </p></li>
                            <li><address>2201 Collins Ave <br> Miami Beach, FL 33139 <br> United States</address></li>
                            <li><a class="user-num" href="tel:(305) 938-3000">(305) 938-3000</a></li>
                            <li><a class="user-email" href="mailto:user_travel@example.com">user_travel@example.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="detail-right-box-top">
                <div class="detail-right-box">
                    <h2>Find or create a customer</h2>
                    <div class="detail-search-box find-customer">
                        <input placeholder="Find customers..." type="text">
                        <span class="fa fa-search"></span>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="detail-right-box-bottom">
                <h2>Tags<a class="box-tags" href="#">View all tags</a></h2>
                <div class="detail-search-box">
                    <input placeholder="Urgent, reviewed, wholesale" type="text">
                </div>
            </div>
        </div>
    </div>

    </div>
</div>
<!--main content-->
@endsection 