<?php $__env->startSection('content'); ?>

    <div class="wrapper wrap-tl">
    <div class="content-wrapper">
         <div class="content-heading"> <i class="fa fa-user"></i> <span class="admin-breadcrumb"><a href="#">Customers</a> / </span> <span>
				 <?php if(isset($user)): ?>
					 <?php echo e($user->first_name); ?>&nbsp;<?php echo e($user->last_name); ?>

				 <?php else: ?>
					 <?php if(isset($obj)): ?>
						 <?php echo e($obj['userName']); ?>

					 <?php endif; ?>
					 <?php endif; ?>
			 </span>
            <div class="pull-right">
                 <button class="btn btn-primary" >Cancel </button>
                    <button class="btn btn-primary"> Save </button>
              </div>
        </div>
        <section>
        <?php echo $__env->make('flash.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="col-lg-8">
				<div class="panel panel-default panel-tl">
					<div class="panel-heading">
						<h4> <?php if(isset($user)): ?>
								<?php echo e($user->first_name); ?>&nbsp;<?php echo e($user->last_name); ?>

							<?php else: ?>
								<?php if(isset($obj)): ?>
									<?php echo e($obj['userName']); ?>

								<?php endif; ?>
							<?php endif; ?> <small class="pull-right"><a href="" data-toggle="modal" data-target="#exampleModalLong">View all Orders</a></small></h4>
						<p><?php if(isset($user)): ?>
							<?php echo e($user->country); ?>

							<?php else: ?>
								<?php if(isset($obj)): ?>
									<?php echo e($obj['location']); ?>

								<?php endif; ?>
							<?php endif; ?>
							</p>
						<p>Customer for Since </p>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Customer Note</label>
							<input type="text" class="form-control" name="notes">
						</div>
						<hr>
						<?php if(isset($obj)): ?>
						<div class="row text-center">
							<div class="col-sm-4">
								<h5>Last Order</h5>
								<h4><?php echo e(Carbon\Carbon::parse($obj['last_order_time'])->format('F jS,  Y')); ?> </h4>
							</div>
							<div class="col-sm-4"><h5>Lifetime Spent</h5>
								<h4>$<?php echo e($obj['tota_sum']); ?></h4>
								<h5><?php echo e($obj['allorders']); ?> orders</h5>
							</div>
							<div class="col-sm-4">
								<h5>Average Order</h5>
								<h4>$<?php echo e(number_format($obj['average_order'],3)); ?></h4>
							</div>
						</div>
							<?php endif; ?>
					</div>
				</div>
				<?php if(isset($obj)): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Recent Orders <small class="pull-right"><a href="">View all orders</a></small></h4>
					</div>
					<div class="panel-body">
						<?php foreach($array as $data): ?>
							<div class="recent-orders-row">
								<div class="recent-orders-left"><p><a href="<?php echo e(url('admin/booking/detail/'.$data['request_id'])); ?>">#<?php echo e($data['request_id']); ?></a></p>
								<h4>$<?php echo e($data['total_ammount']); ?></h4></div>
								<div class="recent-orders-right"><?php echo e(Carbon\Carbon::parse($data['information'])->format('F jS  Y')); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
					<?php else: ?>
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
					<?php endif; ?>
            </div>
            <div class="col-md-4 sidebar-tl">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Account<small class="pull-right">
								<?php if(isset($obj)): ?>
							<a class="Change-orders" href="<?php echo e(url('admin/user/edit/'.$obj['id'])); ?>">Edit</a></small></h4>
						<?php else: ?>
							<?php if(isset($user)): ?>
							<a class="Change-orders" href="<?php echo e(url('admin/user/edit/'.$user->id)); ?>">Edit</a></small></h4>
							<?php endif; ?>
							<?php endif; ?>


					</div>
					<div class="panel-body">
						<?php if(isset($obj)): ?>
						<p><?php echo e($obj['userType']); ?></p>
						<p>Customer receive <?php echo e($obj['discount']); ?> % discount</p>
						<?php else: ?>
							<?php if(isset($user)): ?>
								<p><?php echo e($user->userType); ?></p>
								<p>Customer receive <?php echo e($user->discount); ?> % discount</p>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php if(isset($obj)): ?>
						<h4>Contact <small class="pull-right"><a class="Change-orders" href="<?php echo e(url('admin/user/edit/'.$obj['id'])); ?>">Change</a></small></h4>
							<?php endif; ?>
						<?php if(isset($user)): ?>
								<h4>Contact <small class="pull-right"><a class="Change-orders" href="<?php echo e(url('admin/user/edit/'.$user->id)); ?>">Change</a></small></h4>
							<?php endif; ?>
					</div>
					<div class="panel-body">
						<?php if(isset($obj)): ?>
						<H5><?php echo e($obj['userName']); ?></H5>
						<H5><?php echo e($obj['hotel_address']); ?></H5>
						<H5><?php echo e($obj['location']); ?></H5>
						<H5><?php echo e($obj['country']); ?></H5>
						<H5><?php echo e($obj['phoneNumber']); ?></H5>
						<H5><?php echo e($obj['email']); ?></H5>
							<?php else: ?>
							<?php if(isset($user)): ?>
								<H5><?php echo e($user->first_name); ?></H5>
								<H5><?php echo e($user->country); ?></H5>
								<H5><?php echo e($user->city); ?></H5>
								<H5><?php echo e($user->phoneNumber); ?></H5>
								<H5><?php echo e($user->email); ?></H5>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
            </div>
        </section>
    </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlayouts.main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>