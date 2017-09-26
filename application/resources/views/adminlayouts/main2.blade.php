
<?php



 if(defined(session()->get('isLock'))){
     $value = session()->get('isLock');

     if($value==true){
         header('Location:'.url('admin/showLockScreen'));
     }
     else{
         header('Location:'.url('admin'));
     }
 }



?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="Bootstrap Admin App + jQuery">
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
   <title>TravelLinked Admin Panel</title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="{{url('assets/angle/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css')}}">
   <link rel="stylesheet" href="{{url('/assets/angle/fontawesome/css/font-awesome.min.css')}}">
   <link rel="stylesheet" href="{{url('/assets/angle/simple-line-icons/css/simple-line-icons.css')}}">
   <link rel="stylesheet" href="{{url('/assets/angle/animate.css/animate.min.css')}}">
   <link rel="stylesheet" href="{{url('/assets/angle/whirl/dist/whirl.css')}}">
   <link rel="stylesheet" href="{{url('/assets/angle/weather-icons/css/weather-icons.min.css')}}">
   <link rel="stylesheet" href="{{url('/assets/angle/css/bootstrap.css')}}">
   <link rel="stylesheet" href="{{url('/assets/angle/datatables/media/css/dataTables.bootstrap.css')}}">
   <link rel="stylesheet" href="{{url('assets/angle/sweetalert/dist/sweetalert.css')}}">
   <link rel="stylesheet" href="{{url('assets/angle/simple-line-icons/css/simple-line-icons.css')}}">
  
   <style>
      .logo-main > a {
         font-family: 'Playfair Display', serif;
         font-size: 18px;
         color: rgba(255, 255, 255, 0.9);
         display: inline-block;
         vertical-align: middle;
         text-decoration: none;
         line-height: 30px;
         position: relative;
      }
      .logo-main a em {
         font-size: 24px;
         font-style: normal;
         vertical-align: baseline;
      }
      .logo-main span {
         font-family: 'AvenirNextLTPro-Regular';
         font-size: 14px;
         color: rgba(255, 255, 255, 0.8);
         vertical-align: middle;
         float: left;
         line-height: 35px;
      }
      .logo-main span a {
         color: rgba(255, 255, 255, 0.8);
         text-decoration: none;
      }
   </style>
   <link rel="stylesheet" href="{{url('/assets/angle/css/app.css')}}?v={{ uniqid()}}">
   <!--<link rel="stylesheet" href="{{url('/assets/angle/css/app.css')}}?v={{ uniqid() }}">-->
   
   
   
   <link rel="stylesheet" href="{{url('/assets/angle/blueimp-file-upload/css/jquery.fileupload.css')}}">

</head>

<body>
<div class="wrapper">
   <!-- top navbar-->
   <header class="topnavbar-wrapper">
      <!-- START Top Navbar-->
      <nav role="navigation" class="navbar topnavbar">
         <!-- START navbar header-->

         <div class="navbar-header">
			<div class="brand-logo">
				<div class="logo-main">
				   <a href="http://travellinked.com/travellinked"><em>T</em>RAVEL <em>L</em>INKED</a>
				</div>
			</div>
			<div class="brand-logo-collapsed">
				<div class="logo-main">
				   <a href="http://travellinked.com/travellinked"><em>T</em></a>
				</div>
			</div>
         </div>
         <!-- END navbar header-->
         <!-- START Nav wrapper-->
         <div class="nav-wrapper">
            <!-- START Left navbar-->
            <ul class="nav navbar-nav">
               <li>
                  <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                  <a href="#" data-trigger-resize="" data-toggle-state="aside-collapsed" class="hidden-xs">
                     <em class="fa fa-navicon"></em>
                  </a>
                  <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                  <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                     <em class="fa fa-navicon"></em>
                  </a>
               </li>
               <!-- START User avatar toggle-->
               <li>
                  <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                  <a id="user-block-toggle" href="#user-block" data-toggle="collapse">
                     <em class="icon-user"></em>
                  </a>
               </li>
               <li>
                  <a href="{{url('admin/lockscreen')}}" title="Lock screen">
                     <em class="icon-lock"></em>
                  </a>
               </li>
               <!-- END User avatar toggle-->

            </ul>
            <!-- END Left navbar-->
            <!-- START Right Navbar-->
            <ul class="nav navbar-nav navbar-right">
               <!-- Search icon-->
               <li>
                  <a href="#" data-search-open="">
                     <em class="icon-magnifier"></em>
                  </a>
               </li>
               {{--<li>--}}
                  {{--<a href="#" id="alar" data-toggle="dropdown" aria-expanded="false">--}}
                     {{--<em class="icon-bell"></em>--}}
                     {{--<div class="label label-danger" id="alarm"></div>--}}
                  {{--</a>--}}
               {{--</li>--}}
               <!-- Fullscreen (only desktops)-->
               <li class="dropdown dropdown-list ">
                  <a href="#" data-toggle="dropdown" aria-expanded="false">
                     <em class="icon-bell"></em>
                     <div class="label label-danger" id="counter"></div>
                  </a>
                  <!-- START Dropdown menu-->
                  <ul id="linkx" class="dropdown-menu animated flipInX linkx">

                  </ul>
                  <!-- END Dropdown menu-->
               </li>
               <li class="visible-lg">
                  <a href="#" data-toggle-fullscreen="">
                     <em class="fa fa-expand"></em>
                  </a>
               </li>

            </ul>
            <!-- END Right Navbar-->
         </div>
         <!-- END Nav wrapper-->
         <!-- START Search form-->

         <form role="search" action="search.html" class="navbar-form">
            <div class="form-group has-feedback">
               <input id="search" name="search" data-list=".wrapper" autocomplete="off" type="text" placeholder="Type and hit enter ..." class="form-control">
               <div data-search-dismiss="" class="fa fa-times form-control-feedback"></div>
            </div>
            <button type="submit" class="hidden btn btn-default">Submit</button>
         </form>
         <!-- END Search form-->
      </nav>
      <!-- END Top Navbar-->
   </header>
   <!-- sidebar-->
   <aside class="aside">
      <!-- START Sidebar (left)-->
      <div class="aside-inner">
         <nav data-sidebar-anyclick-close="" class="sidebar">
            <!-- START sidebar nav-->
            <ul class="nav">
               <!-- START user info-->
               <li class="has-user-block">
                  <div id="user-block" class="collapse">
                     <div class="item user-block">
                        <!-- User picture-->
                        <div class="user-block-picture">
                           <div class="user-block-status">
                              <div class="admin-logo"><span>T</span></div>
                           </div>
                        </div>
                        <!-- Name and Job-->
                        <div class="user-block-info">
                           <span class="user-block-name">Hello, {{(session()->get('adminName')==''?' Admin':session()->get('adminName'))}}</span>
                           <span class="user-block-role">Administrator</span>
                        </div>
                     </div>
                  </div>
               </li>
               <!-- END user info-->
               <!-- Iterates over all sidebar items-->
               <!--<li class="nav-heading ">
                  <span data-localize="sidebar.heading.HEADER">Main Navigation</span>
               </li>-->

               <li class=" " id="dashboard">
                  <a href="{{url('admin')}}" title="dashboard">
                     <em class="icon-home"></em>
                     <span data-localize="sidebar.nav.dash">Dashboard</span>
                  </a>
               </li>



               <li class=" " id="bookings">
                  <a href="{{url('admin/bookings')}}" title="Bookings">
                     <em class="fa fa-check-square-o"></em>
                     <span data-localize="sidebar.nav.booking">Bookings</span>
                  </a>



               <li class=" " id="rate">
                  <a href="{{URL('admin/b2c_markup')}}" title="Rate Management">
                     <em class="fa fa-credit-card"></em>
                     <span data-localize="sidebar.nav.rate.management">Rate Management</span>
                  </a>

               </li>
               <li class=" " >
                  <a href="#maps" title="Customers" data-toggle="collapse">
                     <em class="fa fa-user"></em>
                     <span data-localize="sidebar.nav.map.customer">Customers</span>
                  </a>
                  <ul id="maps" class="nav sidebar-subnav collapse">
                     <li class="sidebar-subnav-header" >Customers</li>
                     <li class=" " id="allcustomers">
                     <a href="{{url('admin/allusers')}}" title="All Customers">
                     <span data-localize="sidebar.nav.map.customer">All Customers</span>
                     </a>
                     </li>
                     <li class=" " id="customers" >
                     <a href="{{url('admin/create/customer')}}" title="Create Customer">
                     <span data-localize="sidebar.nav.map.customer">Create Customer</span>
                     </a>
                     </li>
                  </ul>
               </li>

               <li class=" " >
                  <a href="#forms" title="Deals" data-toggle="collapse">
                     <em class="fa fa-fire"></em>
                     <span data-localize="sidebar.nav.form.deals">Deals</span>
                  </a>
                  <ul id="forms" class="nav sidebar-subnav collapse">
                     <li class="sidebar-subnav-header">Deals</li>
                     <li class=" " id="alldeals">
                        <a href="{{url('admin/deals')}}" title="Standard">
                           <span data-localize="sidebar.nav.form.Alldeals">All deals</span>
                        </a>
                     </li>

                     <li class=" " id="createdeal">
                        <a href="{{url('admin/create-deal')}}" title="Create deal">
                           <span data-localize="sidebar.nav.form.create-deal">Create deal</span>
                        </a>
                     </li>

                  </ul>
               </li>
               <li class=" " id="destinations">
                  <a href="{{url('admin/destinationsPage')}}" title="Destinations">
                     <em class="fa  fa-map-marker" aria-hidden="true"></em>
                     <span data-localize="sidebar.nav.destination">Destinations</span>
                  </a>
               </li>





               <li>
                  <a href="#charts" title="CMS" data-toggle="collapse">
                     <em class="fa fa-laptop"></em>
                     <span data-localize="sidebar.nav.chart.CMS">CMS</span>
                  </a>
                  <ul id="charts" class="nav sidebar-subnav collapse">
                     <li class="sidebar-subnav-header">CMS</li>
                     <li class=" " id="import">
                        <a href="{{url('admin/import')}}" title="Codes">
                           <span data-localize="sidebar.nav.chart.Codes">Import Hotel Codes</span>
                        </a>
                     </li>
                     <li class=" " id="facilities">
                        <a href="{{url('admin/importFacility')}}" title="Facilities">
                           <span data-localize="sidebar.nav.chart.Facilities">Import Hotel Facilities</span>
                        </a>
                     </li>
                     <li class=" " id="api">
                        <a href="{{url('admin/showApi')}}" title="API">
                           <span>API Detail</span>
                        </a>
                     </li>
                     <li class=" " id="groupcodes">
                        <a href="{{url('admin/import-hotels-with-codes')}}" title="Groupcodes">
                           <span>Import Hotels With Groupcodes</span>
                        </a>
                     </li>
                     <li class=" " id="groupcodes">
                        <a href="{{url('admin/importDeals')}}" title="Groupcodes">
                           <span>Import Deals</span>
                        </a>
                     </li>
                   </ul>
               </li>

           <li class=" ">
                  <a href="{{url('admin/logout')}}" title="Logout">
                     <em class="fa fa-long-arrow-left"></em>
                     <span data-localize="sidebar.nav.Logout">Logout</span>
                  </a>
               </li>
            </ul>
            <!-- END sidebar nav-->
         </nav>
      </div>
      <!-- END Sidebar (left)-->
   </aside>

   <!-- Main section-->
   <section>
      @yield('content')
   </section>

   <!-- Page footer-->
   <footer>
      <span>&copy; 2017 - Travel Linked</span>
   </footer>
</div>
<!-- =============== VENDOR SCRIPTS ===============-->

<script src="{{url('/assets/angle/modernizr/modernizr.custom.js')}}"></script>
<!-- MATCHMEDIA POLYFILL-->
<script src="{{url('/assets/angle/matchMedia/matchMedia.js')}}"></script>


<!-- JQUERY-->
<script src="{{url('/assets/angle/jquery/dist/jquery.js')}}"></script>
<!-- BOOTSTRAP-->
<script src="{{url('/assets/angle/bootstrap/dist/js/bootstrap.js')}}"></script>
<!-- STORAGE API-->
<script src="{{url('/assets/angle/jQuery-Storage-API/jquery.storageapi.js')}}"></script>
<!-- JQUERY EASING-->
<script src="{{url('/assets/angle/jquery.easing/js/jquery.easing.js')}}"></script>
<!-- ANIMO-->
<script src="{{url('/assets/angle/animo.js/animo.js')}}"></script>
<!-- SLIMSCROLL-->
<script src="{{url('/assets/angle/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- SCREENFULL-->
<script src="{{url('/assets/angle/screenfull/dist/screenfull.js')}}"></script>
<!-- LOCALIZE-->
<script src="{{url('/assets/angle/jquery-localize-i18n/dist/jquery.localize.js')}}"></script>
<!-- RTL demo-->
<script src="{{url('/assets/angle/js/demo/demo-rtl.js')}}"></script>
<!-- =============== PAGE VENDOR SCRIPTS ===============-->
<!-- SPARKLINE-->
<script src="{{url('/assets/angle/sparkline/index.js')}}"></script>
<!-- FLOT CHART-->
<script src="{{url('/assets/angle/Flot/jquery.flot.js')}}"></script>
<script src="{{url('/assets/angle/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{url('/assets/angle/Flot/jquery.flot.resize.js')}}"></script>
<script src="{{url('/assets/angle/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{url('/assets/angle/modernizr/modernizr.custom.js')}}"></script>
<script src="{{url('/assets/angle/Flot/jquery.flot.time.js')}}"></script>
<script src="{{url('/assets/angle/Flot/jquery.flot.categories.js')}}"></script>
<script src="{{url('/assets/angle/flot-spline/js/jquery.flot.spline.min.js')}}"></script>

<script src="{{url('/assets/angle/parsleyjs/dist/parsley.min.js')}}"></script>

<!-- CLASSY LOADER-->
<script src="{{url('/assets/angle/jquery-classyloader/js/jquery.classyloader.min.js')}}"></script>
<!-- MOMENT JS-->
<script src="{{url('/assets/angle/moment/min/moment-with-locales.min.js')}}"></script>
<!-- DEMO-->
<script src="{{url('/assets/angle/js/demo/demo-flot.js')}}"></script>

<!-- =============== APP SCRIPTS ===============-->
<script src="{{url('/assets/angle/js/app.js?v=12')}}"></script>
<script src="{{url('/assets/angle/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('/assets/angle/datatables-colvis/js/dataTables.colVis.js')}}"></script>
<script src="{{url('/assets/angle/datatables/media/js/dataTables.bootstrap.js')}}"></script>
<script src="{{url('/assets/angle/datatables-buttons/js/dataTables.buttons.js')}}"></script>
<script src="{{url('/assets/angle/datatables-buttons/js/buttons.bootstrap.js')}}"></script>
<script src="{{url('/assets/angle/datatables-buttons/js/buttons.colVis.js')}}"></script>
<script src="{{url('/assets/angle/datatables-buttons/js/buttons.flash.js')}}"></script>
<script src="{{url('/assets/angle/datatables-buttons/js/buttons.html5.js')}}"></script>
<script src="{{url('/assets/angle/datatables-buttons/js/buttons.print.js')}}"></script>
<script src="{{url('/assets/angle/datatables-responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{url('/assets/angle/datatables-responsive/js/responsive.bootstrap.js')}}"></script>
<script src="{{url('assets/dashboard/js/manage-deals.js')}}?v={{ uniqid() }}"></script>
<script src="{{url('assets/angle/javascripts/vendor/jquery.hideseek.min.js')}}"></script>
<script src="{{url('assets/angle/javascripts/vendor/rainbow-custom.min.js')}}"></script>
<script src="{{url('assets/angle/javascripts/vendor/jquery.anchor.js')}}"></script>
<script src="{{url('assets/angle/javascripts/initializers.js')}}"></script>
<script src="{{url('assets/angle/sweetalert/dist/sweetalert.min.js')}}"> </script>
<script src="{{url('assets/angle/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js')}}"></script>
<script>
    if (navigator.userAgent.indexOf('Mac OS X') != -1) {
        $("body").addClass("mac");
    } else {
        $("body").addClass("pc");
    }
</script>
@yield('script')
</body>

</html>
