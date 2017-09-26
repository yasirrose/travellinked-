@extends('adminlayouts.main2')

@section('content')
 {{dd($array)}}
    <div class="wrapper">
    <div class="content-wrapper">
         <div class="content-heading"> <i class="fa fa-user"></i> <span class="admin-breadcrumb"><a href="#">Customer</a> / </span> <span>{{$obj['userName']}}</span>
            <div class="pull-right">
                 <button class="btn btn-primary" >Cancel </button>
                    <button class="btn btn-primary"> save </button>
              </div>
        </div>
        <section>
        @include('flash.flash')

            <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-right">
                        <a href="" data-toggle="modal" data-target="#exampleModalLong">View all Orders</a>
                    </div>
                 <h4>{{$obj['userName']}} </h4>
                    <p>{{$obj['location']}}</p>
                    <p>Customer for Since </p>
                </div>
             <div class="panel-body">
                 <h4>Customer Note</h4>
                <div class="form-group">
                 <input type="text" class="form-control" name="notes">
                </div>
                 <hr>
                 <div class="col-sm-12">
                     <div class="col-sm-4">
                         <h5>Last Order</h5>

                         <h4> {{$obj['last_order_time']}}</h4>
                    </div>

                     <div class="col-sm-4"><h5>Lifetime Spent</h5>
                     <h4>{{$obj['tota_sum']}}</h4>
                         <h5>{{$obj['allorders']}} orders</h5>
                     </div>

                     <div class="col-sm-4"><h5>Average Order</h5>

                         <h4>{{$obj['average_order']}}</h4>
                     </div>
                 </div>
             </div>
            </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pull-right">
                            <a href="">edit</a>
                        </div>
                     <h4>Account</h4>
                  </div>
                  <div class="panel-body">
                    <h5>{{$obj['userType']}}</h5>
                      <p>customer receive {{$obj['discount']}} discount</p>
                      <hr>
                      <div class="panel-heading">
                          <div class="pull-right">
                              <a href="">change</a>
                          </div>
                          <h4>Contact</h4>
                        <p>{{$obj['userName']}}</p>
                          <p>{{$obj['hotel_address']}}</p>
                          <p>{{$obj['location']}}</p>
                  </div>
                </div>
            </div>
            </div>
            <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-right">
                        <a href="">edit</a>
                    </div>
                    <h4>Recent Orders</h4>
                </div>
                <div class="panel-body">
                    <h5></h5>
                    <p></p>
                    <hr>
                    <div class="panel-heading">
                        <div class="pull-right">
                            <a href="">change</a>
                        </div>
                        <h4>Contact</h4>
                        <p></p>
                        <p></p>
                        <p></p>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </div>
    </div>


@endsection