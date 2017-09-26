@extends('adminlayouts.main')
@section('content')

<!--main content-->
	<div class="admin-wrapper">
		<div class="admin-wrap-head">
            <div class="admin-w-left">
                <i class="fa fa-user"></i>
                <span class="admin-breadcrumb"><a href="#">Register Users</a> /</span>
                <span>Users</span>
            </div>
            <div class="admin-w-right">
                <button class="btn btn-cancel">Cancel</button>
                <button class="btn btn-save">Save Users</button>
            </div>
		</div>
        <div class="admin-wrap-inner">
            @include('flash.flash')
            <div class="table-wrap">    
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $key => $user) { ?>  
                        <tr>
                            <td><?php echo $user->first_name.' '.$user->last_name; ?></td>
                            <td><?php echo $user->email; ?></td>
                            <?php if($user->status == 1){ ?>
                             <td><label>Active</label></td>
                            <?php }else{ ?>
                            <td><label>Disabled</label></td>
                            <?php } ?> 
                            <td>
                                <form action="{{url('admin/user/disable')}}" method="post">
                                    {!! csrf_field() !!}
                                    
                                    <input type="hidden" name="user_id" value="{{$user->id}}"/>
                                    <div class="squaredThree">
                                        <input type="checkbox" name="status" <?php if($user->status == 1){ echo "checked";} ?>/>
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Do you want to disable?')">Disable</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>       
                    </tbody>
                </table>   
            </div>             
        </div>
	</div>
<!--main content-->
			
@endsection
