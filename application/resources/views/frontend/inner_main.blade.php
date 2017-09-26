<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Linked</title>
    <link rel="shortcut icon" type="image/png" href="{{url('/assets/images/favicon.png')}}"/>
    <link href="{{url('/assets/css/ionicons.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}">
    <link href="{{url('/assets/css/style.css')}}?v={{ uniqid() }}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/jquery-ui.css')}}">
    <link href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
    <link href="{{url('/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/daterangepicker.css')}}?v={{ uniqid() }}">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
    <?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (stripos( $user_agent, 'Chrome') !== false)
    { }
    elseif (stripos( $user_agent, 'Safari') !== false)
    { ?>
    <link href="{{url('/assets/css/safari.css')}}?v={{ uniqid()}}" rel="stylesheet">
    <?php  } ?>
</head>
<body>
<div class="search-loader">
    @include('layouts.loader')
</div>
<input type="text" class="datepicker_in" style="display:none;">
<input type="text" class="check_in" style="display:none;">
<input type="text" class="datepicker_in_sticky" style="display:none;">
<div class="header-main">
    <div class="header-btm header-search">
        <div class="container">
            <div class="hb-left">
                <div class="logo-main"> <a href="{{url('/')}}"><em>T</em>RAVEL <em>L</em>INKED</a> </div>
            </div>
            <div class="hb-center">
                <!-- include popups partial view -->
            @include('frontend.with_values_sticky')
            <!-- include popups partial view -->
            </div>
            <div class="hb-right-search">
                <div class="my-account">
                    
                    <span>
						<svg fill="rgba(39, 45, 52, 0.6)" height="14" viewBox="0 0 24 24" width="14" xmlns="http://www.w3.org/2000/svg">
							<path d="M 12,5 C 9.8797229,5 8,6.7250013 8,9 l 0,2 c 6.9e-6,0.09871 0.029229,0.195212 0.083984,0.277344 L 9,12.652344 9,14.216797 4.2421875,17.070312 C 4.0915207,17.160993 3.9995599,17.32415 4,17.5 l 0,1 c 0,0.65633 1,0.668246 1,0 L 5,17.783203 9.7578125,14.929688 C 9.9084793,14.839007 10.00044,14.67585 10,14.5 l 0,-2 c -7e-6,-0.09871 -0.029229,-0.195212 -0.083984,-0.277344 L 9,10.847656 9,9 c 0,-1.7250013 1.420261,-3 3,-3 1.579739,0 3,1.2749987 3,3 l 0,1.847656 -0.916016,1.375 C 14.029229,12.304788 14.000007,12.401289 14,12.5 l 0,2 c -4.4e-4,0.17585 0.09152,0.339007 0.242188,0.429688 L 19,17.783203 19,18.5 c 0,0.680136 1,0.64045 1,0 l 0,-1 c 4.4e-4,-0.17585 -0.09152,-0.339007 -0.242188,-0.429688 L 15,14.216797 l 0,-1.564453 0.916016,-1.375 C 15.970771,11.195212 15.999993,11.098711 16,11 L 16,9 C 16,6.7250013 14.120277,5 12,5 Z M 12,0 C 5.3785053,0 0,5.3785053 0,12 0,18.621495 5.3785053,24 12,24 18.621495,24 24,18.621495 24,12 24,5.3785053 18.621495,0 12,0 Z m 0,1 C 18.081055,1 23,5.9189454 23,12 23,18.081055 18.081055,23 12,23 5.9189454,23 1,18.081055 1,12 1,5.9189454 5.9189454,1 12,1 Z"/>
						</svg>
					</span>

                    <a href="javascript:void(0)">My Account <i class="icon ion-arrow-down-b"></i></a>
                </div>
                <!-- user-list-->
                <?php if(empty(session()->get('userLogin')) || session()->get('userLogin') == 0){ ?>
                <div class="users-dropown signin-dropdown">
                    <div class="signup-title">
                        <h3>Sign In</h3>
                        <p>Get access to our Secret Insider Prices</p>
                    </div>
                    <div class="users-dropown-list">
                        <ul>
                            <li class="signout-link">
                                <a href="{{'userlogin'}}" class="login-link">Log In</a>
                            </li>
                        </ul>
                        <p class="signout-link">Need an Account? <a href="{{url('signup')}}" class="signup-link">Sign Up</a></p>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="users-dropown">
                    <div class="users-d-desp">
                        <h3>Hello {{session()->get('userName')}}</h3>
                        <p>{{session()->get('userEmail')}}</p>
                    </div>
                    <div class="users-dropown-list">
                        <ul>
                            <?php if(intval(session()->get('userStatus')) == 0){ ?>
                            <li>
                                <a href="{{url('resend-confirmation')}}">Activate Account</a>
                            </li>
                            <?php } ?>
                            <li>
                                <a href="{{URL::to('user\profile')}}">Your Profile</a>
                            </li>
                            <li>
                                <a href="{{URL::to('user\travelers')}}">Travelers</a>
                            </li>
                            <li>
                                <a href="{{URL::to('user\profile')}}">Your Account</a>
                            </li>
                            <li>
                                <a href="{{URL::to('user\reservations')}}">Your Reservations</a>
                            </li>
                            <li>
                                <a href="{{URL::to('user\trip')}}">Trip Settings</a>
                            </li>
                            <li>
                                <a href="{{URL::to('user\History')}}">History</a>
                            </li>
                            <li>
                                <a href="#">Help</a>
                            </li>

                            <li class="signout-link">
                                <a href="{{URL::to('/user_logout')}}">Sign Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <!-- user-list-->
            </div>

            <div class="clear"></div>
        </div>
    </div>

    <a href="javascript:void(0);" id="scroll" title="Scroll to Top" style="display: none;">Top<span></span></a>
</div>
@yield('content')
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
                    <li> <a href="#"><i class="icon ion-social-facebook"></i></a> </li>
                    <li> <a href="#"><i class="icon ion-social-twitter"></i></a> </li>
                    <li> <a href="#"><i class="icon ion-social-instagram-outline"></i></a> </li>
                    <li> <a href="#"><i class="icon ion-social-pinterest"></i></a> </li>
                    <li> <a href="#"><i class="icon ion-social-linkedin"></i></a> </li>
                    <li> <a href="#"><i class="icon ion-social-googleplus"></i></a> </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="footer-btm">
            <p>Copyright © 2015 Travel Linked. All rights reserved</p>
            <div class="clear"></div>
        </div>
    </div>
</div>
<!-- include popups partial view -->
@include('frontend.popups')
<!-- include popups partial view -->
<!-- JavaScripts -->
<script src="{{url('/assets/js/jquery.min.js')}}?v={{ uniqid() }}"></script>
<script src="{{url('/assets/js/moment.min.js')}}"></script>
<script src="{{url('/assets/js/modernizr.min.js')}}"></script>
<script src="{{url('/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{url('/assets/js/script.js')}}?v={{ uniqid() }}" type="text/javascript"></script>
<script src="{{url('/assets/js/register.js')}}?v={{ uniqid() }}" type="text/javascript"></script>
<script src="{{url('/assets/js/mesonryjs.js')}}"></script>
<script src="{{url('/assets/js/jquery-ui.js')}}"></script>
<script src="{{url('/assets/js/responsiveslides.min.js')}}"></script>
<script src="{{url('/assets/js/jquery.mCustomScrollbar.concat.min.js')}}?v={{ uniqid() }}"></script>
<script src="{{url('/assets/js/jquery.daterangepicker.min.js')}}?v={{ uniqid() }}"></script>
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
            $("body").addClass("popup-open");
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
            $("body").removeClass("popup-open");
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
    });


    $(document).ready( function() {
        $('.grid').masonry({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                columnWidth: '.col-one-third, .col-two-third',
            }
        });
    });
</script>
<script>
    $('#tabs li a:not(:first)').addClass('inactive');
    $('.tab-container').hide();
    $('.tab-container:first').show();
    $('#tabs li a').click(function(){
        var t = $(this).attr('href');
        $('#tabs li a').addClass('inactive');
        $(this).removeClass('inactive');
        $('.tab-container').hide();
        $(t).fadeIn('slow');
        return false;
    })
    if($(this).hasClass('inactive')){ //this is the start of our condition
        $('#tabs li a').addClass('inactive');
        $(this).removeClass('inactive');
        $('.tab-container').hide();
        $(t).fadeIn('slow');
    }
</script>
<script>
    $(document).ready(function(){
        // You can also use "$(window).load(function() {"
        $(function () {
            // Slideshow 4
            $("#slider4").responsiveSlides({
                auto: false,
                pager: false,
                nav: true,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                    $('.events').append("<li>after event fired.</li>");
                }
            });
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
            $(".popup-d-body").mCustomScrollbar({
                axis:'y',
                scrollbarPosition:"outside"
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
    $(".destination-autofill .control-field, .staying-days .control-field, .rooms-and-guests .control-field").focus(function(){
        $(this).parent().addClass("active-f");
    }).blur(function(){
        $(this).parent().removeClass("active-f");
    })
</script>


</body>
</html>
