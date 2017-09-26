@extends('adminlayouts.main2')

@section('content')

    <div class="wrapper wrap-tl">
    <div class="content-wrapper">
         <div class="content-heading"> <i class="fa fa-user"></i> <span class="admin-breadcrumb"><a href="#">Customers</a> / </span> <span>
				 @if(isset($user))
					 {{$user->first_name}}&nbsp;{{$user->last_name}}
				 @else
					 @if(isset($obj))
						 {{$obj['userName']}}
					 @endif
					 @endif
			 </span>
            <div class="pull-right">
                 <button class="btn btn-primary" >Cancel </button>
                    <button class="btn btn-primary"> Save </button>
              </div>
        </div>
        <section>
        @include('flash.flash')

            <div class="col-lg-8">
				<div class="panel panel-default panel-tl">
					<div class="panel-heading">
						<h4> @if(isset($user))
								{{$user->first_name}}&nbsp;{{$user->last_name}}
							@else
								@if(isset($obj))
									{{$obj['userName']}}
								@endif
							@endif <small class="pull-right"><a href="" data-toggle="modal" data-target="#exampleModalLong">View all Orders</a></small></h4>
						<p>@if(isset($user))
							{{$user->country}}
							@else
								@if(isset($obj))
									{{$obj['location']}}
								@endif
							@endif
							</p>
						<p>Customer for Since </p>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Customer Note</label>
							<input type="text" class="form-control" name="notes">
						</div>
						<hr>
						@if(isset($obj))
						<div class="row text-center">
							<div class="col-sm-4">
								<h5>Last Order</h5>
								<h4>{{Carbon\Carbon::parse($obj['last_order_time'])->format('F jS,  Y')}} </h4>
							</div>
							<div class="col-sm-4"><h5>Lifetime Spent</h5>
								<h4>${{$obj['tota_sum']}}</h4>
								<h5>{{$obj['allorders']}} orders</h5>
							</div>
							<div class="col-sm-4">
								<h5>Average Order</h5>
								<h4>${{number_format($obj['average_order'],3)}}</h4>
							</div>
						</div>
							@endif
					</div>
				</div>
				@if(isset($obj))
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Recent Orders <small class="pull-right"><a href="">View all orders</a></small></h4>
					</div>
					<div class="panel-body">
						@foreach($array as $data)
							<div class="recent-orders-row">
								<div class="recent-orders-left"><p><a href="{{url('admin/booking/detail/'.$data['request_id'])}}">#{{$data['request_id']}}</a></p>
								<h4>${{$data['total_ammount']}}</h4></div>
								<div class="recent-orders-right">{{Carbon\Carbon::parse($data['information'])->format('F jS  Y')}}</div>
							</div>
						@endforeach
					</div>
				</div>
					@else
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Recent Orders</h4>
						</div>
						<div class="panel-body">
							<div class="recent-orders-row">
								<h4>No Order by this user yet!</h4>
						</div>
					</div>
					</div>
					@endif
            </div>
            <div class="col-md-4 sidebar-tl">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Account<small class="pull-right">
								@if(isset($obj))
							<a class="Change-orders" href="{{url('admin/user/edit/'.$obj['id'])}}">Edit</a></small></h4>
						@else
							@if(isset($user))
							<a class="Change-orders" href="{{url('admin/user/edit/'.$user->id)}}">Edit</a></small></h4>
							@endif
							@endif


					</div>
					<div class="panel-body">
						@if(isset($obj))
						<p>{{$obj['userType']}}</p>
						<p>Customer receive {{$obj['discount']}} % discount</p>
						@else
							@if(isset($user))
								<p>{{$user->userType}}</p>
								<p>Customer receive {{$user->discount}} % discount</p>
							@endif
						@endif
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						@if(isset($obj))
						<h4>Contact <small class="pull-right"><a class="Change-orders" href="{{url('admin/user/edit/'.$obj['id'])}}">Change</a></small></h4>
							@endif
						@if(isset($user))
								<h4>Contact <small class="pull-right"><a class="Change-orders" href="{{url('admin/user/edit/'.$user->id)}}">Change</a></small></h4>
							@endif
					</div>
					<div class="panel-body">
						@if(isset($obj))
						<H5>{{$obj['userName']}}</H5>
						<H5>{{$obj['hotel_address']}}</H5>
						<H5>{{$obj['location']}}</H5>
						<H5>{{$obj['country']}}</H5>
						<H5>{{$obj['phoneNumber']}}</H5>
						<H5>{{$obj['email']}}</H5>
							@else
							@if(isset($user))
								<H5>{{$user->first_name}}</H5>
								<H5>{{$user->country}}</H5>
								<H5>{{$user->city}}</H5>
								<H5>{{$user->phoneNumber}}</H5>
								<H5>{{$user->email}}</H5>
							@endif
						@endif
					</div>
				</div>
            </div>
        </section>
    </div>
    </div>


@endsection