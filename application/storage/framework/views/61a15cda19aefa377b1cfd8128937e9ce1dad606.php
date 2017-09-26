<?php $__env->startSection('content'); ?>
<div class="body-section sky-bg">
	<div class="travelers-container">
       <?php echo $__env->make('UserPreference.leftSideBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="your-reservation-right">
              <div class="your-reservation-top">
                <h2>Your Reservations</h2>
                   <div class="top-right-filter">
                     <div class="top-right-filter-flied width_182 float-left margin-right-10">
                       <input id="searchKey" placeholder="Search your reservation by ID" value="" type="text">
                     </div>
                   <div class="icon-control width_100 float-left margin-right-10">
                       <select name="filterResult" id="filterResult" class="control-field">
                           <option value="0">All</option>
                           <option value="Canceled">Canceled</option>
                           <option value="Confirmed">Confirmed</option>
                           <option value="Pending">Pending</option>
                       </select>
                           <span class="ion ion-arrow-down-b"></span>
                   </div>
                   <div class="icon-control width_120 float-left margin-right-10">
                      <select  id="timeFilter" class="control-field">
                         <option value="30">Last 30 Days</option>
                         <option value="60">Last 60 Days</option>
                         <option value="90">Last 90 Days</option>

                      </select>
                       <span class="ion ion-arrow-down-b"></span>
                   </div>
                   </div>
              </div>
							<div id="filterRecords">
              <?php if(count($reservations)>0): ?>
							<?php $counter = 1;?>
                <?php foreach($reservations as $reservation): ?>
                   <div class="reservation-box">
                     <div class="reservation-box-title">
                       <?php if($reservation->booking_status == 'Pending'): ?>
                         <h2 class="blue-text">
                           Booking <?php echo e($reservation->booking_status); ?>

                         </h2>
                       <?php endif; ?>
                       <?php if($reservation->booking_status == 'Canceled'): ?>
                          <h2 class="red-text">Booking <?php echo e($reservation->booking_status); ?></h2>
                       <?php endif; ?>
                       <?php if($reservation->booking_status == 'Confirmed'): ?>
                          <h2 class="green-text">Booking <?php echo e($reservation->booking_status); ?></h2>
                       <?php endif; ?>
											 <div class="reservation-box-dropdown">
										   <div  id="moreOptions<?php echo e($counter); ?>" onclick="moreOptionsClicked(event)" class="moreOptionsClick reservation-box-dots">
												  <span id="moreOptions<?php echo e($counter); ?>"></span>
													<span id="moreOptions<?php echo e($counter); ?>"></span>
													<span id="moreOptions<?php echo e($counter); ?>"></span>
											</div>

											<ul id="options<?php echo e($counter); ?>">
												<li class="booking"><a href="<?php echo e(url('user/reservations/'.$reservation->booking_id.'/viewBooking')); ?>">View Booking</a></li>
													<li><a href="">Add Note</a></li>
													<li><a href="<?php echo e(url('user/reservations/'.$reservation->booking_id.'/cancel')); ?>" class="btn btn-danger">CancelBooking</a></li>
											</ul>
              <?php $counter = $counter + 1;?>
									</div>
                </div>
                   <div class="reservation-description">
                     <div class="reservation-description-left">
                       <div class="booking-date">
                         <h4>Booking Date</h4>
                         <h5><?php echo e(Carbon\Carbon::parse($reservation -> booking_date)->format('F jS,  Y')); ?></h5>
                       </div>
                         <div class="booking-url">
                           <a href="<?php echo e(url('user/reservations/'.$reservation->booking_id.'/viewBooking')); ?>">Reservation Details</a>
                           <a href="">Hotel Policies</a>
                           <a href="<?php echo e(url('/')); ?>">Book Again</a>
                         </div>
                         <div class="booking-linked">
                           <p>Travel Linked #</p>
                           <h6><?php echo e($reservation->booking_id); ?></h6>
                         </div>
                     </div>
                  <div class="reservation-description-right">
                     <h2><?php echo e($reservation->name); ?></h2>
                     <p><?php echo e($reservation->address); ?></p>
                    <div class="reservation-checkin">
                      <div class="reservation-checkin-left">
                      <p><?php echo e((count(explode(',' , $reservation->roomeCode))-1)); ?> Room</p>
                       <div class="checkin-text">
                         <p><span>Check In:</span> <?php echo e(Carbon\Carbon::parse($reservation -> booking_traveldate)->format('D, M jS  Y')); ?></p>
                         <p><span>Check Out:</span> <?php echo e(Carbon\Carbon::parse($reservation ->booking_traveldateEnd)->format('D, M jS  Y')); ?></p>
                       </div>
                        <p>Traveler Name: <?php echo e(session()->get('userName')); ?></p>
                       <div class="checkin-total">
                         <p><span>Total Paid:</span> $<?php echo e($reservation->total_amount); ?></p>
                       </div>
                    </div>
                   <div class="reservation-img">
                     <img src="<?php echo e($reservation->image); ?>" alt="">
                   </div>
                    </div>
                  </div>
                 </div>
              </div>
           <?php endforeach; ?>
		   <div style="margin-top:-20px"></div>
            <?php elseif(count($reservations)==0): ?>
            <div class="no-reservation-box">
			<h2>No Reservations</h2>
			<p>Need to make a booking, time to go back <a href="">home</a></p>
            </div>
           <?php endif; ?>
				 </div>
         <div class="clear"></div>
   		</div>
		<div class="clear"></div>
	</div>
	<script>
	var element = document.getElementById("<?php echo e($activeID); ?>");
	element.classList.add("active");
	</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
$(document).ready(function(){
	function muhabbat(){
		var status = $('#filterResult').val();
		var date = $('#timeFilter').val();
		var query = $('#searchKey').val();

		$.ajax({
			url: "<?php echo e(URL::to('user/getSearchRecords')); ?>",
			type:"post",
			data:{
				"status": status,
				"time": date,
				"searchQuery": query,
				"_token": "<?php echo e(csrf_token()); ?>"
			},
			dataType:"json",
			success:function(data){
				if(data.status==true){
						$('#filterRecords').html(data.html);
				}
			}
	 });
	}
	$('#filterResult').change(function(){
		muhabbat();
	});
  $('#timeFilter').change(function(){
	muhabbat();
	});
	$('#searchKey').keyup(function(){

	muhabbat();
	});


});

$('.moreOptionsClick').click(function() {
    $(this).toggleClass('active');
});

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>