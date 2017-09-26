@extends('layouts.main')
@section('content')
<div class="popup-centered forgot-popup">

    <div class="popup-inner">

        <span class="close-btn">esc</span>

        <div class="popup-logo">

            <a href="javascript:void(0)"><em>T</em>RAVEL <em>L</em>INKED</a>

        </div>

        <div class="popup-body">

            <h3>Forgot your password? Don’t Panic<span>Enter the email address associated with your account, and we’ll email you a link to reset your password.</span></h3>

            <span id="forgot-message"></span>

            <form method="post" id="forgot">

                {!! csrf_field()!!}

                <div class="login-fields">

                    <div class="login-fields-holder">

                        <input class="login-field" placeholder="Email Address" type="text" name="email">

                    </div>

                </div>

                <div class="login-submit">

                    <button class="forgot-to-confirmation" type="submit">Send Reset Link</button>

                </div>

            </form>

        </div>

        <div class="popup-foot">

            <p>Ready to log in? <a href="javascript:void(0)" class="forgot-to-login">Go back</a></p>

        </div>

    </div>

</div>
@endsection