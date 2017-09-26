<?php @session_start(); $page = Route::getCurrentRoute()->getPath() ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>
    <link href="{{url('/assets/dashboard/css/ionicons.min.css')}}" rel="stylesheet">
	<link href="{{url('/assets/dashboard/css/style.css')}}?v={{ uniqid() }}" rel="stylesheet">
    <link href="{{url('/assets/dashboard/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
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
                <a href="#" class="al-weblink">
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
                <div class="al-nav">
                    <ul>
                        <li>
                            <a href="{{url('admin/dashboard')}}"><i class="icon ion-android-home"></i><span>Dashboard</span></a>
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
                                       <!-- <li>
                                            <a href="{{url('admin/booking')}}">booking</a>
                                        </li>-->
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
                        <li>
                            <a href="#"><i class="fa fa-fire"></i><span>Deals</span></a>
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
                                       <a href="{{url('admin/showApi')}}">API Detail</a>
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
                    <span>{{Auth::user()->name}}</span>
                </span>
            </div>
        </div>        
    </div>
    </div>
<!--left side bar-->

@yield('content')

<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.2.min.js"></script>
<!--- Bootstarap --->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="{{url('assets/dashboard/js/admin_script.js')}}?v={{ uniqid() }}"></script>

<script>
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}
</script>
<script>
$(document).ready(function(){
    $(".approve-decline > span").click(function(){
        $(this).next("ul").slideToggle();
		$(this).addClass("active");
    });
});
</script>

</body>
</html>
