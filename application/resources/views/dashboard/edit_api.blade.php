@extends('adminlayouts.main2')

@section('content')



<!--main content-->
<div class="content-wrapper">
    <div class="content-heading">
         <i class="fa fa-user"></i> 
         <span class="admin-breadcrumb">
             <a href="#">Bonotel </a> 
             |</span> <span>Edit Bonotel Detail</span>
              <div class="pull-right">

                	<button class="btn btn-cancel">Cancel</button>

                    <button class="btn btn-save">Save Customer</button>

                </div>
             </div>
             <div style="margin-left:50px;">
              <h2>API Detail</h2>
            <h4>API</h4>
              </div>    
   <div class="panel-body">	 

          @include("flash.flash")   
           
            <form action="{{url('admin/updateApi/'.$api->id)}}" method="post"> 
           
                      {!! csrf_field() !!}   
                       <div class="col-md-12"> 
                   <div class="col-md-6">   
                    <div class="form-group">
                            <select name="api_name" class="form-control m-b" style=" width:550px;">
                                 <option value="">Select API</option>
                                 <option value="bonolel" class="form-control" <?php if($api->api_name == "bonolel"){echo "selected";} ?>>BonoTel</option>
                                </select>
                                </div>
                       <div class="row">
                           <div class="col-md-6">
                          
                               <div class="form-group">
                             <label for="">User Name</label>
                                 <input class="form-control"  type="text" name="api_user" value="{{$api->api_user}}">
                             </div>    
                             <div class="form-group">
                                  <label for="">Password</label>
                                 <input class="form-control"  type="text" name="api_password" value="{{$api->api_password}}">
                             </div>   
                             <div class="form-group">
                                  <label for="">Provider</label>
                                 <input class="form-control"  type="text" name="api_provider" value="{{$api->api_provider}}">
                             </div>
                             <button type="submit" class="btn btn-primary" >update Detail</button>
     
                          </div>
                     
                      </div>
                      
                      </div>
                       </div>
                        
                  </form>   

                </div>

            </div>

       

<!--main content-->

			

@endsection

