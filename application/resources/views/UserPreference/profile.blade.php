@extends('layouts.main')

@section('content')

<div class="body-section sky-bg">
		<div class="travelers-container">
            @include('UserPreference.leftSideBar')
            <div class="travelers-container-right">
            <form action="{{URL::to('user/updateProfile')}}" method="POST" >
            {{csrf_field()}}
            	<div class="travelers-container-title">Your Profile</div>
                <div class="your-profile-content">
                	<h2>Personal Information</h2>
                    <div class="your-profile-row">
                    	<label>Title</label>
                        <div class="your-profile-field">
                            <div class="icon-control">
                                <select name='title' class="control-field width_80">
                                    <option>Select</option>
                                    <option id='Mr.' value="0" @if($user->gender == 0 )selected @endif >Mr</option>
                                    <option id='Miss.' value="1" @if($user->gender == 1 )selected @endif >Miss</option>
                                    
                                </select>
                                <span class="ion ion-arrow-down-b"></span>
                            </div>
                        </div>
                    </div>
                    <div class="your-profile-row">
                    	<label>First Name</label>
                        <div class="your-profile-field">
                            <input name="firstname" type="text" placeholder="First Name" value="{{$user->first_name}}">
                        </div>
                    </div>
                    <div class="your-profile-row">
                    	<label>Last Name</label>
                        <div class="your-profile-field">
                            <input name="lastname" type="text" placeholder="Last Name" value="{{$user->last_name}}">
                        </div>
                    </div>
                    <div class="your-profile-row">
                    	<label>Location</label>
                        <div class="your-profile-field">
							<div class="profile-location-sect">
								<input name="location" type="text" value="{{$user->country}}">
							</div>
							<div class="profile-location-sect">
								<input name="street-1" type="text" placeholder="Street Address 1 (Optional)" value="{{$user->straddress1}}">
							</div>
							<div class="profile-location-sect">
								<input name="street-2" type="text" placeholder="Street Address 2 (Optional)" value="{{$user->straddress2}}">
							</div>
							<div class="profile-location-sect">
								<div class="icon-control width_106 float-left margin-right-20">
									<input name="city" type="text" placeholder="City" value="{{$user->city}}">
								</div>
								<div class="icon-control width_70 float-left">
									<select name="State" class="control-field">
										<option>State</option>
									</select>
									<span class="ion ion-arrow-down-b"></span>
								</div>
								<div class="icon-control width_84 float-right">
									<input name="zip" type="text" placeholder="Zip Code" value="{{$user->zip_code}}">
								</div>
							</div>
                        </div>
                    </div>
                    <div class="your-profile-row no-border">
                    	<label>Phone Number</label>
                        <div class="your-profile-field">
                            <input name="phoneNumber" type="text" placeholder="(000) 000-0000" value="{{$user->phoneNumber}}">
                        </div>
                    </div>
                </div>
                <div class="your-profile-content">
                	<h2>Account</h2>
                    <div class="your-profile-row">
                    	<label>Email Address</label>
                        <div class="your-profile-field">
                            <input name="email" type="text" placeholder="john@example.com" value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="your-profile-row">
                    	<label>Who Are You?</label>
                        <div class="your-profile-field">
                            <div class="icon-control">
                                <select name="type" class="control-field">
                                    <option id='Business' value="Business">Business</option>
                                    <option id='Hotel' value="Hotel">Hotel</option>
                                    <option id='PropertyManager' value="Property Manager">Property Manager</option>
                                    <option id='TourOperator'value="Tour Operator">Tour Operator</option>
                                    <option id='TravelAgent' value="Travel Agent">Travel Agent</option>
                                    <option id='Traveler' value="Traveler">Traveler</option>
                                    <option id='Website' value="Website">Website</option>
                                </select>
                                <span class="ion ion-arrow-down-b"></span>
                            </div>
                        </div>
                    </div>
                    <div class="your-profile-row no-border">
                    	<label>Birthday</label>
                        <div class="your-profile-field">
                            <div class="icon-control width_106 float-left margin-right-20">
                                <select  name="month" class="control-field"><option><?php echo $month; ?></option>
                                    <option id='month1' value="1">Jan</option>
                                    <option id='month2' value="2">Feb</option>
                                    <option id='month3' value="3">Mar</option>
                                    <option id='month4' value="4">Apr</option>
                                    <option id='month5' value="5">May</option>
                                    <option id='month6' value="6">Jun</option>
                                    <option id='month7' value="7">Jul</option>
                                    <option id='month8' value="8">Aug</option>
                                    <option id='month9' value="9">Sep</option>
                                    <option id='month10' value="10">Oct</option>
                                    <option id='month11' value="11">Nov</option>
                                    <option id='month12' value="12">Dec</option>
                                </select>
                                <span class="ion ion-arrow-down-b"></span>
                            </div>
                            <div class="icon-control width_70 float-left">
                                <select name="day" class="control-field"><option><?php echo $day; ?>  </option>

                                  <?php for($x=1;$x<=31;$x++){ ?>
                                    <option value="{{$x}}">{{$x}}</option>
                                    <?php }
                                    ?>
                                    
                                </select>
                                <span class="ion ion-arrow-down-b"></span>
                            </div>
                            <div class="icon-control width_84 float-right">
                                <select name="year" class="control-field">
                                    <option><?php  echo $year; ?> </option>
                                    <?php
                                        for($i=1960; $i<=2017; $i++){
                                     ?>
                                  <option value="{{$i}}">{{$i}}</option>

                                 <?php  }?>
                                </select>
                                <span class="ion ion-arrow-down-b"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="your-profile-content no-border">
                	<div class="your-profile-row no-border">
                    	<label>Deactivate My Account</label>
                        <div class="your-profile-field">
                            <input class="save-chnge-btn" type="submit" value="Save Changes">
                        </div>
                    </div>
				</div>
            </form>
            </div>
    		<div class="clear"></div>
   		</div>
	</div>	


    <script>
                var element = document.getElementById("{{$activeID}}");
                element.classList.add("active");
                var type = '{{$user->userType}}';
                type = type.replace(' ', '');
                document.getElementById(type).selected = true;

                var title = '{{$user->title}}';
                document.getElementById(title).selected = true;

                var day = '{{date("d", strtotime($user->birthday))}}';
                var month = '{{date("n", strtotime($user->birthday))}}';
                var year = '{{date("Y", strtotime($user->birthday))}}';

                document.getElementById('day'+day).selected = true;
                document.getElementById('year'+year).selected = true;
                document.getElementById('month'+month).selected = true;

</script>
@endsection
