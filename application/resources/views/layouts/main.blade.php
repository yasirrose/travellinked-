<?php @session_start(); $page = Route::getCurrentRoute()->getPath() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TRAVEL LINKED</title>
    <link rel="shortcut icon" type="image/png" href="{{url('/assets/images/favicon.png')}}"/>
    <link href="{{url('/assets/css/ionicons.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}">
    <link href="{{url('/assets/css/style.css')}}?v={{ uniqid()}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/jquery-ui.css')}}">
    <link href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
    <link href="{{url('/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/daterangepicker.css')}}?v={{ uniqid()}}">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
    <?php
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (stripos( $user_agent, 'Chrome') !== false) {}
        elseif(stripos( $user_agent, 'Safari') !== false) {
			$url = url('/assets/css/safari.css');
			echo '<link href="'.$url.'?v='.uniqid().'" rel="stylesheet">';
		}
		?>
</head>
<body class="front-page">
<?php $pageArr = explode('/',$page); ?>
<?php if((in_array('rooms',$pageArr)) || (in_array('deals',$pageArr))){ ?>
<div class="search-loader">
@include('layouts.loader')
</div>
<?php } ?>
<div class="header-main">
   <?php
    if($page == "/" && (empty(session()->get('userLogin')) || session()->get('userLogin') == 0) ){ ?>
    <div class="header-top">
        <div class="container">
            <div class="ht-left"> <span>Join over millions of travelers and get access to the ....</span> </div>
            <div class="ht-right">
                <ul>
                    <li><a href="javascript:void(0)" class="header-top-link icon-globe">Access to the most exclusive hotel deals worldwide</a></li>
                    <li><a href="javascript:void(0)" class="header-top-link icon-key">Free membership</a></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <?php } ?>
    <div class="header-btm">
        <div class="container">
            <div class="hb-left">
                <div class="logo-main"> <a href="{{url('/')}}"><em>T</em>RAVEL <em>L</em>INKED</a> <span><a href="callto:000-000-0000">Have a question? Call us at (000) 000-0000</a></span></div>
            </div>
            <div class="hb-right">
                    <?php if(empty(session()->get('userLogin')) || session()->get('userLogin') == 0){ ?>
                        <ul>
                           <li> <a href="{{url('userlogin/simple')}}" class="login-link">Log In</a>
                            <li class="sign-in signup-link"> <a href="{{url('signup')}}">Sign Up</a> </li>
                        </ul>
                    <?php }else{ ?>
					<ul class="login-nav">
                    	<li><a href="{{URL::to('user\reservations')}}">My Reservations</a></li>
						<li><a href="#">Work With Us</a></li>
                        <li><a href="#">Help</a></li>
                        <li>
                            <div class="user-options">
                                <div class="user-img-icon">
                                    <span>My Account</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                         <!-- user-list-->
                        <div class="users-dropown">
                            <div class="users-d-desp">
                                <h3>Hello {{session()->get('userName')}}</h3>
                                <p>{{session()->get('userEmail')}}</p>
                            </div>
                            <div class="users-dropown-list">
                            	<ul>
                                	<?php if(intval(session()->get('userStatus')) == 0){ ?>
                                	    <li><a href="{{url('resend-confirmation')}}">Activate Account</a></li>
                                    <?php } ?>
                                	<li><a href="{{URL::to('user\profile')}}">Your Profile</a></li>
                                    <li><a href="{{URL::to('user\travelers')}}">Travelers</a></li>
                                    <li><a href="{{URL::to('user\trip')}}">Trip Settings</a></li>
                                    <li><a href="{{URL::to('user\password')}}">Password</a></li>
                                    <li><a href="{{URL::to('user\reservations')}}">Your Reservations</a></li>
                                    <li><a href="{{URL::to('user\billInformation')}}">Billing Information</a></li>
                                    <li><a href="{{URL::to('user\History')}}">History</a></li>
                                    <li class="signout-link"><a href="{{URL::to('/user_logout')}}">Sign Out</a></li>
                                </ul>
                            </div>
                        </div>
                       <!-- user-list-->
                    </div>
                 <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<!--header sticky simple html-->
<?php
if($page != "no/inventory" && !(in_array('payment',$pageArr))){ ?>
	@include('frontend.stickyheader')
<?php } ?>

<!--header sticky simple html-->
<!--Main content of Page-->
@yield('content')
<!--Main content of Page-->
<div class="clear"></div>
</div>
</div>

<!---------- Main Footer------>
<div class="footer-main">
    <div class="container">
        <div class="footer-top">
            <div class="footer-top-left">
                <ul>
                    <li> <a href="javascript:void(0)" class="popup-link">About Us</a> </li>
                    <li> <a href="#">Contact Us</a> </li>
                    <li> <a href="#">Got Advice?</a> </li>
                    <li> <a href="#">List Your Property</a> </li>
                    <li> <a href="#">Travel Agents</a> </li>
                    <li> <a href="#">Affiliates</a> </li>
                    <li> <a href="#">Corporate Accounts</a> </li>
                    <li> <a href="#">Terms of Use</a> </li>
                    <li> <a href="javascript:void(0)" class="">Privacy Policy</a> </li>
                </ul>
            </div>
            <div class="footer-top-right">
                <ul>
                    <li> <a href="#"><i class="fa fa-facebook"></i></a> </li>
                    <li> <a href="#"><i class="fa fa-twitter"></i></a> </li>
                    <li> <a href="#"><i class="fa fa-instagram"></i></a> </li>
                    <li> <a href="#"><i class="fa fa-pinterest"></i></a> </li>
                    <li> <a href="#"><i class="fa fa-google-plus"></i></a> </li>
                    <li> <a href="#"><i class="fa fa-linkedin"></i></a> </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <a href="javascript:void(0);" id="scroll" title="Scroll to Top" style=""><i class="icon ion-ios-arrow-thin-right"></i></a>
        <div class="footer-btm">
            <p>Copyright © 2015 Travel Linked. All rights reserved</p>
            <div class="clear"></div>
        </div>
    </div>
</div>
<input type="text" class="datepicker_in" style="display:none;">
<input type="text" class="datepicker_in_sticky" style="display:none;">
<input type="text" class="check_in" style="display:none;">
<!-- include popups partial view -->
@include('frontend.popups')
<!-- include popups partial view -->
<!-- JavaScripts -->
<script src="{{url('/assets/js/jquery.min.js')}}?v={{ uniqid() }}"></script>
<script src="{{url('/assets/js/moment.min.js')}}"></script>
<script src="{{url('/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/assets/js/roomsScript.js')}}?v={{ uniqid() }}" type="text/javascript"></script>
<script src="{{url('/assets/js/script.js')}}?v={{ uniqid() }}" type="text/javascript"></script>
<script src="{{url('/assets/js/register.js')}}?v={{ uniqid() }}" type="text/javascript"></script>
<script src="{{url('/assets/js/mesonryjs.js')}}"></script>
<script src="{{url('/assets/js/jquery-ui.js')}}"></script>
<script src="{{url('/assets/js/modernizr.min.js')}}"></script>
<script src="{{url('/assets/js/responsiveslides.min.js')}}"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="https://js.stripe.com/v3/"></script>

<?php if(in_array('payment',$pageArr)){ ?>
    <script src="https://js.braintreegateway.com/web/3.5.0/js/client.js"></script>
    <script src="https://js.braintreegateway.com/web/3.5.0/js/hosted-fields.js"></script>
    <script src="{{url('/assets/js/payment.js')}}?v={{ uniqid() }}" type="text/javascript"></script>
<?php } ?>

<script src="{{url('/assets/js/jquery.mCustomScrollbar.concat.min.js')}}?v={{ uniqid() }}"></script>
<script src="{{url('/assets/js/jquery.daterangepicker.min.js')}}?v={{ uniqid() }}"></script>
@yield('script')
<script>
$(document).ready(function(){
	$(".popup-link").click(function(){
		$(".popup-about").addClass("open");
		$("body").addClass("fixed");
	});
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
    $(".policy-link").click(function(){
		$(".popup-policies").addClass("open");
		$("body").addClass("fixed");
	});
	$(".thanku-page-about").click(function(){

		$(".popup-about").addClass("completed");

	});

	$(".thanku-page-policies").click(function(){

		$(".popup-policies").addClass("completed");

	});

	$(".close-popup, .getmeout-link span").click(function(){

		$(".popup-about, .popup-policies ").removeClass("open");

		$(".popup-about, .popup-policies").removeClass("completed");

		$("body").removeClass("fixed");

	});

	$(".login-to-forgot").click(function () {

		$(".login-popup").removeClass("open");

		$(".forgot-popup").addClass("open");

	});

	$(".forgot-to-login").click(function () {

		$(".forgot-popup").removeClass("open");

		$(".login-popup").addClass("open");

	});

	$(".close-email-popup,.close-btn").click(function () {

		$(".email-confirmation-popup").removeClass("open");

	});

	$(".promo-code-link").click(function () {

		$(this).closest('p').toggleClass("promo-active");

		$(".promo-field").slideToggle();

	});

	$(".promo-code-popup .close-popup, .popup-info-foot .right > a").click(function () {

		$(".promo-code-popup").removeClass("open");

		$("body").removeClass("popup-open");

	});

	$(".security-code-link").click(function () {

		$(".security-code-popup").addClass("open");

		$("body").addClass("popup-open");

	});

	$(".security-code-popup .close-popup, .popup-info-foot .right > a").click(function () {

		$(".security-code-popup").removeClass("open");

		$("body").removeClass("popup-open");

	});



	$(".property-policy-link").click(function () {

		$(".property-policy-popup").addClass("open");

		$("body").addClass("popup-open");

	});

	$(".property-policy-popup .close-popup, .popup-info-foot .right > a").click(function () {

		$(".property-policy-popup").removeClass("open");

		$("body").removeClass("popup-open");

	});



	$(".occupation-link").click(function () {

		$(".occupation-popup").addClass("open");

		$("body").addClass("popup-open");

	});

	$(".occupation-popup .close-popup, .popup-info-foot .right > a").click(function () {

		$(".occupation-popup").removeClass("open");

		$("body").removeClass("popup-open");

	});

	$(".room-type-link").click(function () {

		$(".room-type-popup").addClass("open");

		$("body").addClass("popup-open");

	});

	$(".room-type-popup .close-popup, .popup-info-foot .right > a").click(function () {

		$(".room-type-popup").removeClass("open");

		$("body").removeClass("popup-open");

	});
  //cancel policy popup
  $(".cancel-policy-link").click(function () {

    $(".cancel-policy-popup").addClass("open");

    $("body").addClass("popup-open");

  });

  $(".cancel-policy-popup .close-popup, .popup-info-foot .right > a").click(function () {

    $(".cancel-policy-popup").removeClass("open");

    $("body").removeClass("popup-open");

  });
  //cancel policy
	$(".web-terms-link").click(function () {

		$(".web-terms-popup").addClass("open");

		$("body").addClass("popup-open");

	});

	$(".web-terms-popup .close-popup, .popup-info-foot .right > a").click(function () {

		$(".web-terms-popup").removeClass("open");

		$("body").removeClass("popup-open");

	});

	$(".tl-terms-link").click(function () {

		$(".tl-terms-popup").addClass("open");

		$("body").addClass("popup-open");

	});

	$(".tl-terms-popup .close-popup, .popup-info-foot .right > a").click(function () {

		$(".tl-terms-popup").removeClass("open");

		$("body").removeClass("popup-open");

	});
});

</script>

<script>

	(function($){

		$(window).on("load",function(){

			$(".search-list-holder").mCustomScrollbar({

				axis:'y',

				mouseWheel:true

			});

			$(".popup-d-body").mCustomScrollbar({

				axis:'y',

				scrollbarPosition:"outside"

			});

		});

	})(jQuery);

</script>

<script>

	$(document).ready(function(){

    // You can also use "$(window).load(function() {"

    $("#slider4").responsiveSlides({

		auto: true,

		pager: false,

		nav: true,

		speed: 700,

		namespace: "callbacks",

		pause: false,

	 });

    $(".user-img-icon").click(function(){

		$(".users-dropown").slideToggle();

		$(this).toggleClass("active");

    });

	$(window).scroll(function() {

		var scroll = $(window).scrollTop();



		if (scroll >= 500) {

			$("body").addClass("header-fixed");

		} else {

			$("body").removeClass("header-fixed");

		}

	});

	$(window).scroll(function() {

		var scroll = $(window).scrollTop();



		if (scroll >= 520) {

			$(".hotel-landing-page .search-container-left").addClass("fixed-sidebar");

		} else {

			$(".hotel-landing-page .search-container-left").removeClass("fixed-sidebar");

		}

	});

	});

  </script>

  <script>

	(function($){

		$(window).on("load",function(){

			$(".search-list-holder-sticky").mCustomScrollbar({

				axis:'y',

				mouseWheel:true

			});

		});

	})(jQuery);

        $(".share-droplink").click(function(){

		$(".share-dropdown").slideToggle();

		$(this).toggleClass("active");

    });

	$(".my-account").click(function(){

		$(".users-dropown").slideToggle();

		$(this).toggleClass("active");

    });

</script>

<script type="text/javascript">

 	$(document).on('click',function(event){

		parent1 = "",parent2 = "",parent3 = ""

		if($(event.target).parents().eq(0).length !== 0)

		{

			parent1 = $(event.target).parents().eq(0)[0].className;

		}

		if($(event.target).parents().eq(1).length !== 0)

		{

			parent2 = $(event.target).parents().eq(1)[0].className;

		}

		if($(event.target).parents().eq(2).length !== 0)

		{

			parent3 = $(event.target).parents().eq(2)[0].className;

		}

		var currTarget = $(event.target)[0].className;

		if(parent1.search("header-top") !== -1 || parent2.search("header-top") !== -1 || parent3.search("header-top") !== -1

		|| currTarget.search("header-top-link") !== -1)

		{

			$("body").addClass("popup-open");

			$(".signup-popup").addClass("open");

		}

    });

	function moreOptionsClicked(event){
		var id = event.target.id;
		id = id.replace('moreOptions', '');
		$('#options'+id).toggle('slow');
		$(this).toggleClass('active');
	 }

	$(".destination-autofill .control-field, .staying-days .control-field, .rooms-and-guests .control-field").focus(function(){

		$(this).parent().addClass("active-f");

	})

	.blur(function(){

		$(this).parent().removeClass("active-f");

	});

</script>
<script>
    if (navigator.userAgent.indexOf('Mac OS X') != -1) {
        $("body").addClass("mac");
    } else {
        $("body").addClass("pc");
    }
</script>

</body>

</html>
