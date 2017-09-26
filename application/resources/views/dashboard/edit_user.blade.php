<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->

@extends('adminlayouts.main2')

@section('content')


    <!--main content-->
    <div class="content-wrapper">

        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{URL::to('/admin/updateCustomer/'.$user->id)}}" method="POST" class="form-horizontal">
                    {{csrf_field()}}
                    <h2>Customer Overview</h2>
                    <div class="panel-body">
                        <h3>User Information</h3>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Account Type</label>
                        <div class="col-sm-10">
                            <select  name="userType" id="userType" class="form-control m-b">
                                <option>Select Account Type</option>
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

                    <div class="form-group">
                        <label class="col-lg-2 control-label">First Name</label>
                        <div class="col-lg-10">
                            <input name="fname" id="fname" value="{{$user->first_name}}" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Last Name</label>
                        <div class="col-lg-10">
                            <input name="lname" id="lname" value="{{$user->last_name}}" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Email Address</label>
                        <div class="col-lg-10">
                            <input name="email" id="email" value="{{$user->email}}" class="form-control" type="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Phone Number</label>
                        <div class="col-lg-10">
                            <input name="phoneNumber" id="phoneNumber" value="{{$user->phoneNumber}}"  class="form-control" type="text" style="width:200px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Discount</label>
                        <div class="col-lg-10">
                            <input name="discount" id="discount" value="{{$user->discount}}" class="form-control" type="text" style="width:200px;">
                        </div>
                    </div>

                    <div class="panel-body">

                        <h3>Customer Location</h3>

                    </div>
                    <div class="form-group">

                        <label class="col-lg-2 control-label">Address</label>
                        <div class="col-lg-10">
                            <input name="address" id="address" value="{{$user->location}}"  class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">

                        <label class="col-lg-2 control-label">Address Con't</label>
                        <div class="col-lg-10">
                            <input class="form-control" name="address2" id="address2"  type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Country</label>
                        <div class="col-lg-10">
                            <select name="country" id="country"  class="form-control m-b" style="width:300px;">
                                <option value="">Select</option>
                                <option value="US">US</option>
                            </select>
                        </div>
                    </div>
                    <span class="ion ion-arrow-down-b"></span>


                    <div class="form-group">
                        <label  class="col-lg-2 control-label">City</label>
                        <div class="col-lg-10">
                            <input name="city" id="city" value="{{$user->city}}" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">

                        <label class="col-lg-2 control-label">State</label>
                        <div class="col-lg-10">

                            <select name="state" id="state" class="form-control m-b" style="width:300px;">

                                <option value="">Select</option>

                                <option value="AL">Alabama</option>

                                <option value="AK">Alaska</option>

                                <option value="AZ">Arizona</option>

                                <option value="AR">Arkansas</option>

                                <option value="CA">California</option>

                                <option value="CO">Colorado</option>

                                <option value="CT">Connecticut</option>

                                <option value="DE">Delaware</option>

                                <option value="DC">District Of Columbia</option>

                                <option value="FL">Florida</option>

                                <option value="GA">Georgia</option>

                                <option value="HI">Hawaii</option>

                                <option value="ID">Idaho</option>

                                <option value="IL">Illinois</option>

                                <option value="IN">Indiana</option>

                                <option value="IA">Iowa</option>

                                <option value="KS">Kansas</option>

                                <option value="KY">Kentucky</option>

                                <option value="LA">Louisiana</option>

                                <option value="ME">Maine</option>

                                <option value="MD">Maryland</option>

                                <option value="MA">Massachusetts</option>

                                <option value="MI">Michigan</option>

                                <option value="MN">Minnesota</option>

                                <option value="MS">Mississippi</option>

                                <option value="MO">Missouri</option>

                                <option value="MT">Montana</option>

                                <option value="NE">Nebraska</option>

                                <option value="NV">Nevada</option>

                                <option value="NH">New Hampshire</option>

                                <option value="NJ">New Jersey</option>

                                <option value="NM">New Mexico</option>

                                <option value="NY">New York</option>

                                <option value="NC">North Carolina</option>

                                <option value="ND">North Dakota</option>

                                <option value="OH">Ohio</option>

                                <option value="OK">Oklahoma</option>

                                <option value="OR">Oregon</option>

                                <option value="PA">Pennsylvania</option>

                                <option value="RI">Rhode Island</option>

                                <option value="SC">South Carolina</option>

                                <option value="SD">South Dakota</option>

                                <option value="TN">Tennessee</option>

                                <option value="TX">Texas</option>

                                <option value="UT">Utah</option>

                                <option value="VT">Vermont</option>

                                <option value="VA">Virginia</option>

                                <option value="WA">Washington</option>

                                <option value="WV">West Virginia</option>

                                <option value="WI">Wisconsin</option>

                                <option value="WY">Wyoming</option>
                            </select>
                        </div>

                        <span class="ion ion-arrow-down-b"></span>

                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Zip Code</label>
                        <div class="col-lg-10">
                            <input name="zip" id="zip" value="{{$user->zip_code}}" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="panel-body">

                        <h3>Notes</h3>
                    </div>

                    <div class="form-group">

                        <label class="col-lg-2 control-label">Extra notes for customer</label>

                        <div class="col-lg-10">
                            <input name="notes" id="notes" value="{{$user->notes}}" class="form-control" type="text">

                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary" style="float:right;">Save Customer</button>
                </form>
            </div>
        </div>
    </div>
    <!--main content-->
@endsection
