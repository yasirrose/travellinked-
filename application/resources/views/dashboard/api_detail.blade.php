@extends('adminlayouts.main2')@section('content')<!--main content-->      <div class="content-wrapper">         <div class="content-heading">             <em class="fa fa-laptop"></em>             <span class="admin-breadcrumb"><a href="#">Bonotel</a> /</span>                    <span>Add Bonotel Detail</span>                <div class="pull-right">                	<button class="btn btn-cancel">Cancel</button>                    <a href="{{url('admin/showApi')}}" class="btn btn-save">Show API Detail</a>                </div>            </div>            <div class="panel-body">                	<h2>API Detail</h2>                    @include("flash.flash")                        	<h3>API Information</h3>                    <form action="{{url('admin/addApi')}}" method="post">                     {!! csrf_field() !!}                           <div class="form-group">                        	<label for="">API</label>                            <select class="form-control m-b" name="api_name">                            	<option value="">Select API</option>                                <option value="bonotel">Bonotel</option>                            </select>                        </div>                        <div class="form-group">                        	  <label for="" class="control-label">user Name</label>                                <input class="form-control" type="text" name="api_user" >                            </div>                        <div class="form-group">                                <label for="" class="control-label">Password</label>                                <input class="form-control" type="text" name="api_password" >                            </div>                        <div class="form-group">                        	<label for="" class="control-label">Provider</label>                            <input class="form-control" type="text" name="api_provider" >                        </div>                        <button type="submit" class="btn btn-primary">Save Detail</button>                    </form>            </div>                                        </div><!--main content-->			@endsection