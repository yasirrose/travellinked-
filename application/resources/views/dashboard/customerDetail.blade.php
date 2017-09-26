@extends('adminlayouts.main')

@section('content')



<!--main content-->

	<div class="admin-wrapper">

		<div class="admin-wrap-head">
			
            <div class="admin-w-left"> <i class="fa fa-user"></i> <span class="admin-breadcrumb"><a href="#">Customers</a> /</span> <span>Company Name</span> </div>
            
            <div class="admin-w-right">

                <button class="btn btn-cancel">Cancel</button>

                <button class="btn btn-save">Save</button>

            </div>

		</div>

        <div class="admin-wrap-inner">

            @include('flash.flash')
            
            <div class="w-customer-wrapper">
            	<div class="w-customer-left">
                	<div class="w-customer-bg-brdr">
                    	<div class="w-customer-title">
                        	<h2>Company Name</h2>
                            <div class="w-customer-title-right">
                            	<a href="">View all orders</a>
                            </div>
                        </div>
                        <div class="w-company-box">
                        	<p>Miami Beach, FL</p>
                            <p>Customer for since October 20, 2016</p>
                        </div>
                        <div class="w-customer-note">
                        	<label>Customer Note</label>
                            <input type="text" value="" placeholder="Add a note" />
                        </div>
                        <div class="w-customer-table">
                        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<th>Last Order</th>
                                    <th>Lifetime Spent</th>
                                    <th>Average Order</th>
                                </tr>
                                <tr>
                                	<td>About 10 hours ago</td>
                                    <td>$6,607.07</td>
                                    <td>$3,303.54</td>
                                </tr>
                                <tr>
                                	<td class="w-customer-link-color">#106</td>
                                    <td class="w-customer-small-txt">2 Orders</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="w-customer-bg-brdr">
                    	<div class="w-customer-title w-btm-pading-20">
                        	<h2>Recent Orders</h2>
                            <div class="w-customer-title-right">
                            	<a href="">View all orders</a>
                            </div>
                        </div>
                        <div class="w-recent-order">
                        	<div class="w-recent-order-left">
                            	<span>#106</span>
                                <p>$4,767</p>
                            </div>
                            <div class="w-recent-order-right">
                            	<p>April 6, 2017</p>
                            </div>
                        </div>
                        <div class="w-recent-order w-brdr-none">
                        	<div class="w-recent-order-left">
                            	<span>#106</span>
                                <p>$4,767</p>
                            </div>
                            <div class="w-recent-order-right">
                            	<p>April 6, 2017</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-customer-right">
                	<div class="w-customer-bg-brdr">
                    	<div class="w-customer-title">
                        	<h2>Account</h2>
                            <div class="w-customer-title-right">
                            	<a href="">Edit</a>
                            </div>
                        </div>
                        <div class="w-customer-account-box">
                        	<p>Wholesaler</p>
                            <p><a href="">www.urlname.com</a></p>
                            <p>Customer recieves discount of 10% & $5 off</p>
                        </div>
                        <div class="w-customer-title">
                        	<h2>Contact</h2>
                            <div class="w-customer-title-right">
                            	<a href="">Change</a>
                            </div>
                        </div>
                        <div class="w-customer-account-box w-brdr-none">
                        	<p>User Name</p>
                            <p>2201 Collins Ave</p>
                            <p>Miami Beach, FL 33139</p>
                            <p>United States</p>
                            <p><a href="">(305) 938-3000</a></p>
                            <p><a href="">name@companydomain.com</a></p>
                        </div>
					</div>
                    <div class="w-customer-bg-brdr">
                    	<div class="w-customer-title">
                        	<h2>Tags</h2>
                            <div class="w-customer-title-right">
                            	<a href="">View all tags</a>
                            </div>
                        </div>
                        <div class="w-tag-box">
                        	<input type="text" value="" placeholder="VIP, sale shopper, etc." />
                            <div class="w-badge-wraper">
                            	<div class="w-badge-box">
                                	<span>Wholesale</span>
                                    <a href=""><i class="fa fa-times" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
					</div>
                </div>
            </div>
        </div>
	</div>

<!--main content-->

			

@endsection

