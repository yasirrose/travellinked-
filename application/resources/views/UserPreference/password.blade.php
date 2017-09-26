@extends('layouts.main')
@section('content')
<div class="body-section sky-bg">
  	<div class="travelers-container">
 @include('UserPreference.leftSideBar')
      <div class="travelers-container-right">
        @if ($errors->has())
        <div class="alert alert-danger">
           @foreach ($errors->all() as $error)
               {{ $error }}<br>
           @endforeach
       </div>
       @endif

      <form method="POST" action="{{URL::to('user/update_password')}}">
      {{csrf_field()}}
            	<div class="travelers-container-title">Password  @if(Session::has('message'))
        <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif</div>
                <div class="password-form-wrapper">
                	<div class="password-wrapper-inner">

                        <div class="password-row">
                            <label>Current Password</label>
                            <div class="password-field">
                                <input name="currentPassword" value="" type="password">
                            </div>
                        </div>
                        <div class="password-row">
                            <label>New Password</label>
                            <div class="password-field">
                            	<input name="password" value="" type="password">
                            </div>
                            <p>New password, at least 6 characters.</p>
                        </div>
                        <div class="password-row">
                            <label>Confirm Password</label>
                            <div class="password-field">
                            	<input name="confirmPassword" value="" type="password">
                            </div>
                        </div>
                    </div>
                    <div class="password-btm-btn">
						<input class="save-chnge-btn" type="submit" value="Save Changes">
                    </div>
                </div>
                </form>
            </div>
            <div class="clear"></div>
        </div>


          <script>
      var element = document.getElementById("{{$activeID}}");
      element.classList.add("active");
      </script>
      @endsection
