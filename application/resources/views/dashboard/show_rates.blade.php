@extends('adminlayouts.main')
@section('content')

<!--main content-->
      <div class="admin-wrapper">
        	<div class="admin-wrap-head">
            	<div class="admin-w-left">
                	<i class="fa fa-user"></i>
                	<span class="admin-breadcrumb"><a href="#">B2C</a> /</span>
                    <span>B2C INVOICE</span>
                </div>
                <div class="admin-w-right">
                	<button class="btn btn-cancel">Cancel</button>
                    <button class="btn btn-save">Save Customer</button>
                </div>
            </div>
        	<div class="admin-wrap-inner">
            	<div class="customers-overview invoice-main">
               @include('flash.flash') 
                	<h1>B2C INVOICE</h1>
                 <table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
               
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Discount</th>
                <th>Action</th>
                
            </tr>
        </thead>
        
        <tbody>
      <?php foreach($api_detail as $api){ ?>      
            
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="{{url('admin/api/edit/'}}" class="btn btn-success">Edit</a>
                <a href="{{url('admin/api/delete/')}}" class="btn btn-danger" 
                onclick="return confirm('Do you want to delete?')">Delete</a></td>
               
            </tr>
     <?php } ?>      
            </tbody>
            </table>   
                </div>
            </div>
        </div>
<!--main content-->
</div>
			
@endsection
