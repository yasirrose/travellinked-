@extends('adminlayouts.main')
@section('content')

<!--main content-->
      <div class="admin-wrapper">
        	<div class="admin-wrap-head">
            	<div class="admin-w-left">
                	<i class="fa fa-user"></i>
                	<span class="admin-breadcrumb"><a href="#">Guest User's Booking</a> /</span>
                    <span>Booking</span>
                </div>
                <div class="admin-w-right">
                <a href="{{url('admin/booking')}}" class="btn btn-success">Guest Booking</a>
                	<button class="btn btn-cancel">Cancel</button>
                    <button class="btn btn-save">Save Customer</button>
                </div>
            </div>
            
        	<div class="admin-wrap-inner"> 
         @include("flash.flash")        
          <table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
               
                <th>Email</th>
               <!-- <th>Service Provider</th>-->
               <!-- <th>Booking Module</th>-->
                <th>Status</th>
                <th>check In</th>
                <th>Check Out</th>
                <th>Refference#</th>
                <!--<th>Room Refference#</th>-->
                <th>Subtotal</th>
                <th>Cancel</th>
                <!--<th>Account Type</th>
                <th>Card type</th>-->
            </tr>
        </thead>
        
        <tbody>
      <?php $name = ""; foreach($regBooking as $reg){ ?>      
            <tr>
            <?php
			if($reg->name != $name) { ?>
            <tr>
            <td style="width:100%; height:20px; background-color:#8DCBC9; font-size:18px; color:green; text-align:center;" colspan="10">
            <?php echo $reg->name ?>
            </td>
            </tr>
           <?php } ?> 
                <td><?php echo $reg->email; ?></td>
                <!--<td><?php //echo $guest->booking_serviceprovider; ?></td>-->
               <!-- <td><?php //echo $guest->booking_module; ?></td>-->
                <td><?php if($reg->cancellationNo == null){ 
				echo "<span class='label label-success'>Booked</span>"; 
				}else{echo "<span class='label label-danger'>Canceled</span>";
				}; ?></td>
                <td><?php echo $reg->booking_traveldate; ?></td>
                <td><?php echo $reg->booking_traveldateEnd; ?></td>
                <td><?php echo $reg->booking_reference_no; ?></td>
               <!-- <td><?php //echo $reg->booking_room_reference_no; ?></td>-->
                <td><?php echo $reg->amount; ?></td>
                <?php if($reg->cancellationNo == null){ ?>
                <td><a href="{{url('admin/cancel/'.$reg->id)}}" class="btn btn-success">Cancel</a></td>
                <?php }else{ ?>
                <td><a href="javascript:void(0)" class="btn btn-danger" disabled>Canceled</a></td>
                <?php } ?>
                <!--<td><?php //echo $guest->merchantAccountId; ?></td>
                <td><?php //echo $guest->cardType; ?></td>-->
                
            </tr>
     <?php $name = $reg->name;
	 } ?>      
            </tbody>
            </table>    
                    
                    
                   
            </div>
        </div>
<!--main content-->
			
@endsection
