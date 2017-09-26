@extends('layouts.main')
@section('content')
<div class="body-section">
		<div class="travelers-container">
            @include('UserPreference.leftSideBar')
              <div class="your-reservation-right">
                          	<div class="your-reservation-top">
                              	<h2>Your Reservations</h2>
                                  <div class="top-right-filter">
                                  	<div class="top-right-filter-flied width_180 float-left margin-right-10">
                                          <input placeholder="Search your reservation by ID" value="" type="text">
                                      </div>
                                      <div class="icon-control width_100 float-left margin-right-10">
                                          <select class="control-field">
                                              <option>Day</option>
                                          </select>
                                          <span class="ion ion-arrow-down-b"></span>
                                      </div>
                                      <div class="icon-control width_120 float-left margin-right-10">
                                          <select class="control-field">
                                              <option>Year</option>
                                          </select>
                                          <span class="ion ion-arrow-down-b"></span>
                                      </div>
                                  </div>
                              </div>
                              @foreach($reservations as $reservation)

                                   <div class="reservation-box">
                                              	<div class="reservation-box-title">
                                                  @if( $reservation->booking_status == 'Pending')
                                                  	<h2 class="blue-text">{{ $reservation->booking_status }}</h2>
                                                  	@endif
                                                  	<h2 class="green-text">{{ $reservation->booking_status }}</h2>
                                                      <div class="reservation-box-dropdown">
                                                      	<div class="reservation-box-dots">
                                                          	<span></span>
                                                              <span></span>
                                                              <span></span>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="reservation-description">
                                                  	<div class="reservation-description-left">
                                                      	<div class="booking-date">
                                                          	<h4>Booking Date</h4>
                                                              <h5>{{$reservation -> booking_date}}</h5>
                                                          </div>
                                                          <div class="booking-url">
                                                          	<a href="">Reservation Details</a>
                                                              <a href="">Hotel Policies</a>
                                                              <a href="">Book Again</a>
                                                          </div>
                                                          <div class="booking-linked">
                                                          	<p>Travel Linked #</p>
                                                              <h6>{{$reservation->booking_id}}</h6>
                                                          </div>
                                                      </div>
                                                      <div class="reservation-description-right">
                                                      	<h2>{{$reservation->name}}</h2>
                                                          <p>{{$reservation->address}}</p>
                                                          <div class="reservation-checkin">
                                                          	<div class="reservation-checkin-left">
                                                              	<p>1 Room</p>
                                                                  <div class="checkin-text">
                                                                  	<p><span>Check In:</span> {{$reservation -> booking_traveldate}}</p>
                                                                      <p><span>Check Out:</span> {{$reservation ->booking_traveldateEnd  }}</p>
                                                              	</div>
                                                                  <p>Traveler Name: {{ $reservation->booking_by  }}</p>
                                                                  <div class="checkin-total">
                                                                  	<p><span>Total Paid:</span> $1,100</p>
                                                              	</div>
                                                              </div>
                                                              <div class="reservation-img">
                                                              	<img src="{{$reservation->image}}" alt="">
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              @endforeach
    		<div class="clear"></div>
   		</div>
	</div>	



    <script>
var element = document.getElementById("{{$activeID}}");
element.classList.add("active");
</script>
@endsection
