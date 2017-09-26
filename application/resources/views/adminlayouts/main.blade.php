<?php @session_start(); $page = Route::getCurrentRoute()->getPath(); ?>

<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{$title}} | Travel Linked</title>

    <link href="{{url('/assets/dashboard/css/ionicons.min.css')}}" rel="stylesheet">

	<link href="{{url('/assets/dashboard/css/style.css')}}?v={{ uniqid() }}" rel="stylesheet">

    <link href="{{url('/assets/dashboard/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{url('/assets/css/jquery-ui.css')}}">

    <link href="{{url('/assets/css/jquery.dataTables.css')}}" rel="stylesheet">

    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">

     <link rel="stylesheet" href="{{url('/assets/css/daterangepicker.css')}}?v={{ uniqid()}}">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">

   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!---- Bootstarap data tables --->

    <!--<link href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->

</head>

<body>

<div class="admin-container">

<!--left side bar-->

    <div class="admin-leftbar">

        <div class="admin-leftbar-content">

            <div class="admin-leftbar-head">

                <a href="{{url('admin')}}" class="al-logo-link"><em>T</em>RAVEL <em>L</em>INKED</a>

                <a href="{{url('/')}}" class="al-weblink">

                    <i class="icon ion-android-open"></i>

                </a>

            </div>

            <div class="admin-leftbar-body">

                <div class="al-search-box">

                    <input type="text" placeholder="Search">

                    <span class="seach-icon">

                        <i class="icon ion-android-search"></i>

                    </span>

                </div>

                @include('dashboard.nav-search-box')

                <div class="al-nav">

                    <ul>

                        <li>

                            <a href="{{url('admin')}}"><i class="icon ion-android-home"></i><span>Dashboard</span></a>

                        </li>

                        <li class="has-ul">

                            <a href="#"><i class="icon ion-android-checkbox-outline"></i></i><span>Bookings</span></a>

                            <div class="sub-menu">

                                <div class="submenu-overlay"></div>

                                <div class="sub-menu-content">

                                    <h2>Bookings</h2>

                                    <ul>

                                        <li>

                                            <a href="{{url('admin/bookings')}}">All Bookings</a>

                                        </li>

                                    </ul>

                                </div>        

                            </div>

                        </li>

                       <!-- <li>

                            <a href="{{url('admin/all/bookings')}}"><i class="icon ion-android-checkbox-outline"></i><span>Bookings</span><label class="label-count">2</label></a>

                        </li>-->

                        <li>

                            <a href="#"><i class="icon ion-stats-bars"></i><span>Reports</span></a>

                        </li>

                        <li class="has-ul">

                            <a href="#"><i class="fa fa-credit-card"></i><span>Rate Management</span></a>

                            <div class="sub-menu">

                                <div class="submenu-overlay"></div>

                                <div class="sub-menu-content">

                                    <h2>Rate Management</h2>

                                    <ul>

                                   		 <li>

                                            <a href="{{url('admin/b2c_markup')}}">B2C Markup</a>

                                        </li>

                                        <li>

                                            <a href="#">New Users</a>

                                        </li>

                                        <li>

                                            <a href="#">Members</a>

                                        </li>

                                        <li>

                                            <a href="#">B2B Users</a>

                                        </li>

                                    </ul>

                                </div>        

                            </div>

                        </li>

                        <li>

                            <a href="{{url('admin/users')}}"><i class="fa fa-user"></i><span>Customers</span><label class="label-count">8</label></a>

                        </li>

                        <li class="has-ul">

                            <a href="#"><i class="fa fa-fire"></i><span>Deals</span></a>

                            <div class="sub-menu">

                                <div class="submenu-overlay"></div>

                                <div class="sub-menu-content">

                                    <h2>Deals</h2>

                                    <ul>

                                    	<li>

                                            <a href="{{url('admin/deals')}}">All deals</a>

                                        </li>

                                   		 <li>

                                            <a href="{{url('admin/bonoteldeals')}}">Update bonotels deals</a>

                                        </li>

                                        <li>

                                            <a href="{{url('admin/create-deal')}}">Create deal</a>

                                        </li>

                                        <li>

                                            <a href="{{url('admin/destinations')}}">All destinations</a>

                                        </li>

                                    </ul>

                                </div>        

                            </div>

                        </li>

                        <li>

                            <a href="#"><i class="fa fa-star"></i><span>Promos</span></a>

                        </li>

                        <li>

                            <a href="#"><i class="fa fa-link"></i><span>Deeplinks</span></a>

                        </li>

                        <li class="has-ul">

                            <a href="#"><i class="fa fa-laptop"></i><span>CMS</span></a>

                            <div class="sub-menu">

                                <div class="submenu-overlay"></div>

                                <div class="sub-menu-content">

                                    <h2>CMS</h2>

                                    <ul>

                                    	<li>

                                       		<a href="{{url('admin/import')}}">Import Hotel Codes</a>

                                        </li>

                                        <li>

                                       		<a href="{{url('admin/importFacility')}}">Import Hotel Facilities</a>

                                        </li>

                                    	<li>

                                       		<a href="{{url('admin/showApi')}}">API Detail</a>

                                        </li>

                                        <li>

                                       		<a href="{{url('admin/import-hotels-with-codes')}}">Import Hotels With Groupcodes</a>

                                        </li>

                                        <li>

                                            <a href="#">New Users</a>

                                        </li>

                                        <li>

                                            <a href="#">Members</a>

                                        </li>

                                        <li>

                                            <a href="#">B2B Users</a>

                                        </li>

                                    </ul>

                                </div>        

                            </div>

                        </li>

                        <li class="has-ul">

                            <a href="#"><i class="fa fa-code"></i><span>Applications</span></a>

                            <div class="sub-menu">

                                <div class="submenu-overlay"></div>

                                <div class="sub-menu-content">

                                    <h2>Applications</h2>

                                    <ul>

                                        <li>

                                            <a href="#">New Users</a>

                                        </li>

                                        <li>

                                            <a href="#">Members</a>

                                        </li>

                                        <li>

                                            <a href="#">B2B Users</a>

                                        </li>

                   

                                    </ul>

                                </div>        

                            </div>

                        </li>

                        <li>

                            <a href="#"><i class="fa fa-bell"></i><span>Notifications</span></a>

                        </li>

                        <li>

                            <a href="#"><i class="fa fa-inbox"></i><span>Mail</span><label class="label-count">10</label></a>

                        </li>

                        <li>

                            <a href="{{url('admin/logout')}}"><i class="fa fa-user"></i><span>Logout</span></a>

                        </li>

                        

                    </ul>

                </div>

            </div>

            <div class="admin-leftbar-foot">

                <div class="user-list">

                    <div class="short-name">JM</div>

                    <span>{{session()->get('adminName')}}</span>

                </span>

            </div>

        </div>        

    </div>

    </div>

<!--left side bar-->



@yield('content')

<script src="{{url('/assets/js/jquery.min.js')}}?v={{ uniqid() }}"></script>

<script src="{{url('/assets/js/moment.min.js')}}"></script>

<script src="{{url('/assets/js/jquery.validate.min.js')}}"></script>

<script src="{{url('/assets/js/mesonryjs.js')}}"></script>

<script src="{{url('/assets/js/jquery-ui.js')}}"></script>

<script src="{{url('/assets/js/modernizr.min.js')}}"></script>

<script src="{{url('assets/js/jquery.dataTables.js')}}?v={{ uniqid() }}"></script>

<script src="{{url('assets/dashboard/js/admin_script.js')}}?v={{ uniqid() }}"></script>

<script src="{{url('/assets/js/jquery.mCustomScrollbar.concat.min.js')}}?v={{ uniqid() }}"></script>

<script src="{{url('/assets/js/jquery.daterangepicker.min.js')}}?v={{ uniqid() }}"></script>

<script src="{{url('assets/dashboard/js/nav-search.js')}}?v={{ uniqid() }}"></script>

<?php if($page == "admin/bookings"){ ?>

<script src="{{url('assets/dashboard/js/booking-filters.js')}}?v={{ uniqid() }}"></script>

<?php } ?>

<?php if($page == "admin/createbooking"){ ?>

<script src="{{url('assets/dashboard/js/bookings.js')}}?v={{ uniqid() }}"></script>

<?php } ?>

<?php if($page == "admin/deals" || $page == "admin/destinations" || $page == "admin/create-deal" || $page == "admin/bonoteldeals"){ ?>

<script src="{{url('assets/dashboard/js/manage-deals.js')}}?v={{ uniqid() }}"></script>

<?php } ?>

<script>

function myFunction() {

    document.getElementById("myDropdown").classList.toggle("show");

}

</script>

<script>

$(document).ready(function(){

    $(".approve-decline > span").click(function(){

		$(".tabs-content").find(".approve-decline > span").removeClass("active");

		$(".tabs-content").find(".approve-decline > ul").slideUp();

		

        $(this).next("ul").slideToggle();

		$(this).toggleClass("active");

    });

	$('body').click(function(event){

		current = event.target;

		$(".tabs-content").find(".approve-decline > span").removeClass("active");

		$(".tabs-content").find(".approve-decline > ul").hide();

		$(current).next("ul").slideToggle();

        

    });

	

	dataTableElems = $('body').find('.table');

	$(dataTableElems).each(function(){

		var idElem = $(this).attr('id');

		if(typeof idElem !== "undefined")

		{

			$('#'+idElem).DataTable({

			"paging":   true,

			"pageLength": 10,

			"ordering": false,

			"info":     false

			});

		}

	});

});

</script>

</body>

</html>

