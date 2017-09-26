<style>
.booking-detail-wrap .panel-heading > h4 {
	margin: 0;
}
</style>

<?php $__env->startSection('content'); ?>
<!--main content-->

<div class="wrapper">

    <div class="content-wrapper">
        <div class="content-heading"> <em class="fa fa-check-square-o"></em>   <span class="admin-breadcrumb">  <a href="#">  Bookings </a>  / </span><span>   #<?php echo e($bookingDetail->request_id); ?></span>
            <div class="pull-right">
                <section id="directional">
                    <button class="btn btn-primary" > <em class="fa fa-chevron-left"></em> </button>
                    <button class="btn btn-primary"> <em class="fa fa-chevron-right"></em> </button>
                    <button class="btn btn-default btn-print">Print</button>
                </section>
            </div>
        </div>
        <section>
        <?php echo $__env->make('flash.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="row booking-detail-wrap">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <!-- Main panel-->

                    <div class="panel-heading">
                        <div class="pull-right">
                            <a href="" data-toggle="modal" data-target="#exampleModalLong">View Policy</a>
                        </div>
                        <h4 class="fullfilled">Booking Detail </h4>
                        <input id="notedID" type="hidden" value="<?php echo e($bookingDetail->request_id); ?>">

                        <p class="status-detail"><?php
								if ($bookingDetail->is_canceled == 1) {
                            ?> <span style="color: red">	<?php echo "Canceled"; ?></span>
							<?php	} elseif ($bookingDetail->is_pending == 1) {
                            ?>	<span style="color: deepskyblue"><?php echo "Pending"; ?></span>
								<?php } else {
								?> <span style="color: green"><?php	echo "Confirmed"; }?></span>

							</p>
                        </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Boking Date</th>
                                <th>Wholeseler Name</th>
                                <th>Order #</th>
                                <th>Wholeseler</th>
                            </tr>
                            <tr>
                                <td><?php
										$date = strtotime($bookingDetail->booking_date);
										echo date('l, M jS, Y', $date);
                                     ?>
								</td>
                                <td><?php echo $bookingDetail->booking_serviceprovider; ?></td>
                                <td><?php echo $bookingDetail->request_id; ?></td>
                                <td><?php echo $bookingDetail->booking_operator_no; ?></td>
                            </tr>
                        </table>
                        <hr>
                        <h4>Accommodation Information</h3>
                        <p><?php echo $hotel->name ?></p>
						<p><a class="user-num" href="tel:<?php echo $hotel->phone;?>"> <?php echo $hotel->phone;?></a></p>
                        <p><?php echo $hotel->address . ' ,' . $hotel->city . ' ,' . $hotel->state;?></p>
                        <hr>
                        <h4>Reservation Details</h3>
                        <table class="table table-striped">
                            <tr>
                                <th>No. of Rooms</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>No. of Nights</th>
                            </tr>
                            <tr>
                                <td><?php echo $bookingDetail->no_rooms; ?></td>
                                <td><?php echo date("Y-m-d", strtotime($bookingDetail->booking_traveldate)); ?></td>
                                <td><?php echo date("Y-m-d", strtotime($bookingDetail->booking_traveldateEnd));  ?></td>
                                <td><?php echo $bookingDetail->no_nights; ?></td>
                            </tr>
                        </table>
                        <hr>
                        <h4>Room Details</h4>
                        <table class="table table-striped">
                            <tr>
                                <th>Room Type</th>
                                <th>Occupancy</th>
                                <th>Traveler</th>
                                <th>Confirmation #</th>
                            </tr>
                            <?php                                
								$arrAdlut = explode(",", $bookingDetail->adults);                                
								$arrChild = explode(",", $bookingDetail->children);                                
								$rType = explode(",", $bookingDetail->room_types);                                                                
								for($i = 0; $i < intval($bookingDetail->no_rooms); $i++){ 
							?>
                            <tr>
                                <td><?php echo $rType[$i] ?></td>
                                <td><?php echo $arrAdlut[$i] ?> Adults, <?php echo $arrChild[$i] ?> Children</td>
                                <td><?php echo $user->fname . " " . $user->lname; ?></td>
                                <td>
									<?php                                            
										if ($bookingDetail->is_canceled == 1) {
											echo "Canceled";
										} elseif ($bookingDetail->is_pending == 1) {
											echo "Pending";
										} else {
											echo "Confirmed";
										}
									?>
                                </td>
                            </tr>
                            <?php }

                             ?>
                        </table>
                        <hr>
                        <h4>Billing</h4>
                        <table class="table table-striped">
                            <tr>
                                <th>Travel Dates</th>
                                <th>Payment Method</th>
                                <th>Origin of Lead</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <td><?php echo e(Carbon\Carbon::parse($bookingDetail->booking_traveldate)->format('F jS  Y')); ?>

                                    - <?php echo e(Carbon\Carbon::parse($bookingDetail->booking_traveldateEnd)->format('F jS  Y')); ?></td>
                                <td>Credit Card</td>
                                <td>Website</td>
                                <td>$<?php echo $bookingDetail->amount; ?></td>
                            </tr>
                        </table>
                        <hr>
                        <div class="col-md-6 pull-right">
                            <h4>Charges</h4>
                            <table class="table table-striped">
                                <tr>
                                    <td>Subtotal</td>
                                    <td align="right">$<?php echo $bookingDetail->amount; ?></td>
                                </tr>
                                <tr>
                                    <td>
										<?php $ArrTax = explode(",", $bookingDetail->tax);                                                
											$tTax = 0;                                                
											foreach ($ArrTax as $Tax) {
											$tTax += $Tax;
													}                                                
										?>
                                    </td>
                                    <td align="right">$<?php echo $tTax; ?></td>
                                </tr>
                                <tr>
                                    <td>Hotel Fees (due at hotel)</td>
                                    <td align="right">$<?php echo $bookingDetail->hote_fee ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Estimated Grand Total</strong></td>
                                    <td align="right">$<?php echo $bookingDetail->amount + $bookingDetail->hote_fee; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Paid by customer</strong></td>
                                    <td align="right"><strong>$<?php echo $bookingDetail->amount; ?></strong></td>
                                </tr>
                            </table>
							<br />
							<div class="text-right">
								<p>PAYMENT OF
								$<?php echo $bookingDetail->amount; ?> WAS ACCEPTED</p>
								<?php if($bookingDetail->is_deleted == 1 && $bookingDetail->is_refunded == 1){?>
								<button class="btn btn-danger">Decline</button>
								<?php }elseif($bookingDetail->is_refunded == 1 && $bookingDetail->is_deleted == 0){ ?>
								<a href="<?php echo e(url('admin/decline/'.$bookingDetail->user_id)); ?>">
								<button class="btn btn-primary">Refund</button>
								</a>
								<?php }elseif($bookingDetail->is_pending == 0 && $bookingDetail->is_deleted == 0 && $bookingDetail->is_refunded == 1){ ?>
								<button class="btn btn-default">Paid </button>
								<?php }elseif($bookingDetail->is_canceled == 0 && $bookingDetail->is_pending == 0) { ?>
								<a href="<?php echo e(url('admin/cancel/'.$bookingDetail->request_id)); ?>">
								<button class="btn btn-danger">Cancel</button>
								</a>
								<?php }elseif($bookingDetail->is_refunded == 0) { ?>
								<a href="<?php echo e(url('admin/decline/'.$bookingDetail->request_id)); ?>">
								<button class="btn btn-primary">Refund</button>
								</a>
								<?php } ?>
							</div>	
                        </div>
                        <div> </div>
                    </div>
                </div>
            </div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Fulfillment Status</h4>
							<?php if($bookingDetail->is_canceled == 1){ ?>
							<small class="fullfilled" style="color: red">Canceled</small>
							<?php }elseif($bookingDetail->is_pending == 1){ ?>
							<small class="fullfilled" style="color: deepskyblue">Pending</small>
							<?php }else{ ?>
							<small class="fullfilled" style="color: green">Confirmed</small>
							<?php } ?>

					</div>
                    <div class="panel-heading">
                    <h4>Customer <small class="pull-right"> <?php echo e($total_orders); ?> Orders</small></h4>
                    </div>
					<div class="panel-body">
                        <p><?php echo $user->fname . " " . $user->lname; ?></p>
						<p class="customer-category">Wholesaler</p>
						<p class="discount-content">Customer recieves <?php echo e($user->discount); ?> % of Discount</p>
						
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Contact <small class="pull-right"><a class="Change-orders" href="<?php echo e(url('admin/user/edit/'.$bookingDetail->user_id)); ?>">Change</a></small></h4>
					</div>
					<div class="panel-body">
						<p><?php echo $user->fname;  echo ' '. $user->lname;  ?></p>

							<address>
							<?php if(!empty($information)): ?>
                                    <h5><?php echo $information->billing_address1; ?></h5>
                                    <h5><?php echo $information->billing_city; ?> </h5>
                                    <h5><?php echo $information->billing_state; ?> , <?php  echo $information->billing_zipcode ?></h5>
                            <?php else: ?>
                                    <h5><?php echo $user->billing_address1?></h5>
                                    <h5><?php echo $user->city; ?></h5>
                                    <h5><?php  echo $user->state; ?> <?if($user->state){echo ","; } else{
                                        echo " ";
                                        }?>  <?php echo $user->zip_code; ?></h5>
                                <h5><?php echo $user->country; ?></h5>
                        <h5><a class="user-num" href="tel:(305) 938-3000"><?php echo e($user->phone); ?></a></h5>
                        <h5><a class="user-email" href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></h5>

                        <?php endif; ?>

                        </address>
							
					  </div>
                </div>
				<div class="panel panel-default panel-notes">
					<div class="chgform panel-heading">
						<h4>Notes <small class="pull-right"><a  href="#" onclick="idHandler()">Change</a></small></h4>
						<p id="bookingNotes"><?php echo e($bookingDetail->notes); ?></p>
					</div>
				</div>				
				
				



			</div>
            </div>
            </section>
        </div>
    </div>



<!--main content -->
<?php $__env->stopSection(); ?>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Hotel Policy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <ul>
                    <?php

                    $cancel = str_replace("<ul>","",$policy);

                    $cancel = str_replace("</ul>","",$cancel);
                    $cancel = str_replace("Bonotel","TravelLinked",$cancel);


                    echo $cancel;

                    ?>

                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('script'); ?>
    <script>
               function idHandler() {
                        $('.chgform').replaceWith('<div class="panel-body panel-notes" id="hideit"><input type="text" class="form-control" id="notesVal" name="notes" value="'+$('#bookingNotes').html()+'"><br><button  onclick="changenotesData()" class="btn btn-primary" id="notesData">change notes</button></div>');

               }

        function changenotesData() {

            var filters = [];
            var nameStr = '';
            /*====== main site url and current url =========*/
            var pathArray = location.href.split('/');
            var protocol = pathArray[0];
            var host = pathArray[2];
            var site_url = protocol + '//' + host + "/travellinked";
            var id = $('#notedID').val();
            var val = $('#notesVal').val();

            $.ajax({
                type: "post",
                url: site_url + "/admin/bookings/changeNotes",
                data: {
                    "notes": val,
                    "ID": id,
                    "_token": "<?php echo e(csrf_token()); ?>"
                },
                success: function (data) {
                     data = JSON.parse(data);
                    if(data.status){

                        $('#hideit').replaceWith('<div class="chgform panel-heading"><div id="changed" class=""><h4>Notes<small class="pull-right"><a  href="#" onclick="idHandler()">Change</a></small></h4> <p  id="bookingNotes">'+val+'</p></div></div>');
                        alert(data.alert);
                    }
                    else{
                        console.log(data);

                    }

                   }
            })

        }
    </script>
    <?php $__env->stopSection(); ?>



<?php echo $__env->make('adminlayouts.main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>