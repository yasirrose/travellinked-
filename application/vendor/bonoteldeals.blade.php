@extends('adminlayouts.main2')@section('content')<!--main content--><div class="wrapper">    <div class="content-wrapper">          <div class="content-heading">            <i class="fa fa-user"></i>            <span class="admin-breadcrumb"><a href="#">Dashboard </a> /</span>            <span> Update deals from bonotel</span>           </div>        	      @include("flash.flash")            <div class="col-md-12 col-sm-offset-5">             <fieldset>                     <form action="{{url('admin/updatebonoteldeals')}}" method="post">                       {!! csrf_field() !!}                       <button  class="btn btn-primary btn-lg" type="submit">Update deals from bonotel</button>                   </form>        </fieldset>    </div></div>        </div><!--main content-->@endsection