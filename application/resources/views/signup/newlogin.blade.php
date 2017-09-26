@extends('layouts.singinLayout')
@section('content')
    <div class="page-forgot-pass page-login" id="thisshow">
        <div class="page-forgot-pass-inner">
            <div class="page-forgot-pass-logo">
                <a href="{{url('/')}}">
                    <img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png">
                </a>
            </div>
            <div class="popup-inner">
                <form method="post" action="{{url('user_login')}}" id="user_login_form">
                    {!! csrf_field()!!}
                    <div class="popup-body">
                        <h2>Welcome back!</h2>
                        <input type="hidden" name="type" id="type" value="{{$type }}">
                        @if($type == 'room')
                            <input type="hidden" name="link" id="link" value="{{$link}}">
                        @endif
                        <div id="success_log" style="color:green;"></div>
                        <div class="fb-login"> <a class="fb-btn" href="{{url('userlogin/facebook')}}"><span><i class="fa fa-facebook"></i></span> Log in with Facebook</a> </div>
                        @if(isset($abc))
                           @if(isset($abc->email) == 'The email field is required' && isset($abc->password) == 'The password field is required')
                                <span class="alert alert-danger">The email and password field are required</span>
                            @elseif(isset($abc->password) == 'The password field is required')
                                <span class="alert alert-danger">The password field is required</span>
                            @else
                            <span class="alert alert-danger">The email field is required</span>
                            @endif
                        @endif
                        <div class="or-divider"><span>Or</span></div>
                        <div id="msg" style="color:#a94442;"></div>
                        <div class="login-fields">
                            <div class="login-fields-holder">
                                <input class="login-field" placeholder="Email Address" name="email" type="text">
                                <div id="login_eamil_msg"></div>
                            </div>
                            <div class="login-fields-holder">
                                <input class="login-field" placeholder="Password" name="password" type="password">
                                <div id="login_pass_msg"></div>
                            </div>
                        </div>
                        <div class="login-remember">
                            <div class="remember-check">
                                <div class="rating-check">
                                    <input type="checkbox">
                                    <i class="icon ion-checkmark-round"></i>
                                </div>
                                <label>Remember me</label>
                            </div>
                            <a href="javascript:void(0)"  class="login-to-forgot" id="fgt">Forgot Password?</a> </div>
                        <div class="login-submit">
                            <button type="submit" id="user_login">Log In</button>
                        </div>
                    </div>
                </form>
                <div class="popup-foot">
                    <p>Need an account? <a href="{{url("signup")}}" class="login-to-signup">Sign up now!</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="page-forgot-pass forgot-popup" id="reset-this" style="display:none;">
        <div class="page-forgot-pass-inner">
            <div class="page-forgot-pass-logo">
                <a href="#">
                    <img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png">
                </a>
            </div>
            <div class="popup-inner">
                <div class="popup-body">
                    <h3>Forgot your password? Don’t Panic<span>Enter the email address associated with your account, and we’ll email you a link to reset your password.</span></h3>
                    <span id="forgot-message"></span>
                    <span id="message" style="font-size: 10px;text-align: center;color: #72767b; display:block;padding-top: 20px"></span>
                    <form method="post" id="forgot">
                        {!! csrf_field()!!}
                    <div class="login-fields">
                        <div class="login-fields-holder">
                            <input class="login-field" placeholder="Email Address" type="text" name="email">
                        </div>
                    </div>
                    <div class="login-submit">
                        <button class="forgot-to-confirmation" type="submit" >Send Reset Link</button>
                    </div>
                    </form>
                </div>
                <div class="popup-foot">
                    <p>Ready to log in? <a href="{{url("userlogin")}}" class="forgot-to-login">Go back</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
