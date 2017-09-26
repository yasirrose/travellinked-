<?php @session_start(); $page = Route::getCurrentRoute()->getPath(); ?>

<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{$title}} | Travel Linked</title>

<link rel="stylesheet" href="{{url('/assets/angle/fontawesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{url('/assets/angle/simple-line-icons/css/simple-line-icons.css')}}">
<link rel="stylesheet" href="{{url('/assets/angle/animate.css/animate.min.css')}}">
<link rel="stylesheet" href="{{url('/assets/angle/whirl/dist/whirl.css')}}">
<link rel="stylesheet" href="{{url('/assets/angle/weather-icons/css/weather-icons.min.css')}}">
<link rel="stylesheet" href="{{url('/assets/angle/css/bootstrap.css')}}">


</head>
<body>
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
                                <img src="img/user/02.jpg" alt="Avatar" width="60" height="60" class="img-thumbnail img-circle">
                                <div class="circle circle-success circle-lg"></div>
                             </div>
                          </div>
                          <!-- Name and Job-->
                          <div class="user-block-info">
                             <span class="user-block-name">Hello, Mike</span>
                             <span class="user-block-role">Designer</span>
                          </div>
                       </div>
                    </div>
                 </li>
                 <!-- END user info-->
                 <!-- Iterates over all sidebar items-->
                 <li class="nav-heading ">
                    <span data-localize="sidebar.heading.HEADER">Main Navigation</span>
                 </li>
                 <li class=" ">
                    <a href="#dashboard" title="Dashboard" data-toggle="collapse">
                       <div class="pull-right label label-info">3</div>
                       <em class="icon-speedometer"></em>
                       <span data-localize="sidebar.nav.DASHBOARD">Dashboard</span>
                    </a>
                    <ul id="dashboard" class="nav sidebar-subnav collapse">
                    <li class="active">
                          <a href="{{url('admin')}}" title="Dashboard v1"><span>Dashboard</span></a>
                    </li>
                  </ul>
                 </li>

                 <li class=" ">
                     <a href="#layout" title="Layouts" data-toggle="collapse">
                        <em class="icon-layers"></em>
                        <span>Bookings</span>
                     </a>
                     <ul id="layout" class="nav sidebar-subnav collapse">

                        <li class=" ">
                           <a href="{{url('admin/bookings')}}"><span>All Bookings</span></a>
                        </li>
                     </ul>
                  </li>
                  <li class=" ">
                     <a href="widgets.html" title="Widgets">
                        <em class="icon-grid"></em>
                        <span data-localize="sidebar.nav.WIDGETS">Reports</span>
                     </a>
                  </li>
                 <li class=" ">
                    <a href="#layout" title="Layouts" data-toggle="collapse">
                       <em class="icon-layers"></em>
                       <span>Rate Management</span>
                    </a>
                    <ul id="layout" class="nav sidebar-subnav collapse">
                       <li class=" ">
                          <a href="{{url('admin/b2c_markup')}}">B2C Markup</a>
                          </a>
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
                 </li>
                 <li class=" ">

                    <a href="{{url('admin/users')}}"> <span data-localize="sidebar.nav.WIDGETS">Customers</span></a>

                 </li>
               <li class=" ">
                    <a href="#elements" title="Elements" data-toggle="collapse">
                       <em class="icon-chemistry"></em>
                       <span data-localize="sidebar.nav.element.ELEMENTS">Deals</span>
                    </a>
                    <ul id="elements" class="nav sidebar-subnav collapse">
                       <li class="sidebar-subnav-header">Rate Management</li>
                       <li class=" ">  <a href="{{url('admin/deals')}}">All deals</a>
                       </li>
                       <li class=" ">
                          <a href="{{url('admin/bonoteldeals')}}"><span data-localize="sidebar.nav.element.NOTIFICATION">Update bonotels deals</span>
                          </a>
                       </li>
                       <li class=" ">
                          <a href="{{url('admin/create-deal')}}"><span>Create deal</span></a>
                     </li>
                       <li class=" ">
                          <a href="{{url('admin/destinations')}}"><span>All destinations</span></a>

                       </li>
                    </ul>
                 </li>
                  <li class="nav-heading ">
                    <span data-localize="sidebar.heading.MORE">More</span>
                 </li>
                 <li class=" ">
                    <a href="#pages" title="Pages" data-toggle="collapse">
                       <em class="icon-doc"></em>
                       <span data-localize="sidebar.nav.pages.PAGES">CMS</span>
                    </a>
                    <ul id="pages" class="nav sidebar-subnav collapse">

                       <li class=" ">

                             	<a href="{{url('admin/import')}}"><span data-localize="sidebar.nav.pages.LOGIN">Import Hotel Codes</span></a>

                       </li>
                       <li class=" ">
                            	<a href="{{url('admin/importFacility')}}"><span data-localize="sidebar.nav.pages.REGISTER">Import Hotel Facilities</span>
                              </a>
                       </li>
                       <li class=" ">
                        <a href="{{url('admin/showApi')}}"> <span data-localize="sidebar.nav.pages.RECOVER">API Detail</span></a>
                       </li>
                       <li class=" ">

                             <a href="{{url('admin/import-hotels-with-codes')}}"><span data-localize="sidebar.nav.pages.LOCK">Import Hotels With Groupcodes</a></span>

                       </li>
                       <li class=" ">
                            <a href="#"><span data-localize="sidebar.nav.pages.STARTER">Members</span></a>

                       </li>
                       <li class=" ">

                            <a href=""><span data-localize="sidebar.nav.pages.LOCK">B2B Users</a></span>

                       </li>

                    </ul>

                 </li>
                 <li class=" ">
                    <a href="#extras" title="Extras" data-toggle="collapse">
                       <em class="icon-cup"></em>
                       <span data-localize="sidebar.nav.extra.EXTRA">Applications</span>
                    </a>
                    <ul id="extras" class="nav sidebar-subnav collapse">

                       <li class=" ">
                         <a href="#"><span>New Users</span></a>
                      </li>
                      <li class=" ">
                        <a href="#"><span>Members</span></a>
                     </li>
                       <li class=" ">
                         <a href="#"><span>B2B Users</span></a>
                       </li>
                      </ul>
                 </li>

                 <li class=" ">

                       <em class="icon-graduation"></em>
                       <a href="#"><span data-localize="sidebar.nav.DOCUMENTATION">Notifications</span></a>

                 </li>
                 <li class=" ">

                       <em class="icon-graduation"></em>
                       <a href="#"><span data-localize="sidebar.nav.DOCUMENTATION">Mail</span></a>

                 </li>
                 <li class=" ">

                       <em class="icon-graduation"></em>
                       <a href="#"><span data-localize="sidebar.nav.DOCUMENTATION">Logout</span></a>

                 </li>
              </ul>
              <!-- END sidebar nav-->
           </nav>
        </div>
      </body>

      </html>
