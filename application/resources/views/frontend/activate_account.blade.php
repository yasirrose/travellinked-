<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
    <link href="{{url('/assets/css/ionicons.min.css')}}" rel="stylesheet">
	<link href="{{url('/assets/css/style.css')}}?v={{ uniqid()}}" rel="stylesheet">
    <link href="{{url('/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="popup-centered reset-popup signup-reset open">
    <div class="popup-inner">
        <div class="popup-logo">
            <a href="{{url('/')}}"><em>T</em>RAVEL <em>L</em>INKED</a>            
        </div>
        <div class="popup-body">
            <h3>Set Your Password<span>Choose a password. Make sure it’s strong!</span></h3>
            <span id="message"></span>
           	<form method="post" id="activate">
			{!! csrf_field() !!}
            <div class="login-fields">
            	<input type="hidden" name="uid" value="{{$id}}">
                <div class="login-fields-holder">
                    <input class="login-field" placeholder="New Password" type="password" name="password" id="password">
                </div>
                <div class="login-fields-holder">
                    <input class="login-field" placeholder="Confirm Password" type="password" name="con_password">
                </div>
            </div>
             <div class="login-submit">
                <button type="submit">Save & Continue</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.2.min.js"></script>
<script src="{{url('/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/assets/js/mesonryjs.js')}}"></script>
<script src="{{url('/assets/js/jquery-ui.js')}}"></script>
<script src="{{url('/assets/js/register.js')}}?v={{ uniqid() }}" type="text/javascript"></script>
</body>
</html>
