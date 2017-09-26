<div class="header-main header-sticky">

    <div class="header-btm header-search">

        <div class="container">

            <div class="hb-left">

            	<div class="logo-main">

                	<a href="http://travellinked.com/travellinked"><em>T</em>RAVEL <em>L</em>INKED</a>

                </div>

            </div>

            <div class="hb-center">

            <?php if($page == "/"){ ?>

			<?php echo $__env->make('frontend.with_default_sticky', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			<?php 

			}else{

			?> 

			<?php echo $__env->make('frontend.with_values_sticky', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			<?php } ?>

            </div>

            <div class="hb-right-search">

            	<div class="my-account">

                	<span>
						<svg fill="rgba(39, 45, 52, 0.6)" height="14" viewBox="0 0 24 24" width="14" xmlns="http://www.w3.org/2000/svg">
							<path d="M 12,5 C 9.8797229,5 8,6.7250013 8,9 l 0,2 c 6.9e-6,0.09871 0.029229,0.195212 0.083984,0.277344 L 9,12.652344 9,14.216797 4.2421875,17.070312 C 4.0915207,17.160993 3.9995599,17.32415 4,17.5 l 0,1 c 0,0.65633 1,0.668246 1,0 L 5,17.783203 9.7578125,14.929688 C 9.9084793,14.839007 10.00044,14.67585 10,14.5 l 0,-2 c -7e-6,-0.09871 -0.029229,-0.195212 -0.083984,-0.277344 L 9,10.847656 9,9 c 0,-1.7250013 1.420261,-3 3,-3 1.579739,0 3,1.2749987 3,3 l 0,1.847656 -0.916016,1.375 C 14.029229,12.304788 14.000007,12.401289 14,12.5 l 0,2 c -4.4e-4,0.17585 0.09152,0.339007 0.242188,0.429688 L 19,17.783203 19,18.5 c 0,0.680136 1,0.64045 1,0 l 0,-1 c 4.4e-4,-0.17585 -0.09152,-0.339007 -0.242188,-0.429688 L 15,14.216797 l 0,-1.564453 0.916016,-1.375 C 15.970771,11.195212 15.999993,11.098711 16,11 L 16,9 C 16,6.7250013 14.120277,5 12,5 Z M 12,0 C 5.3785053,0 0,5.3785053 0,12 0,18.621495 5.3785053,24 12,24 18.621495,24 24,18.621495 24,12 24,5.3785053 18.621495,0 12,0 Z m 0,1 C 18.081055,1 23,5.9189454 23,12 23,18.081055 18.081055,23 12,23 5.9189454,23 1,18.081055 1,12 1,5.9189454 5.9189454,1 12,1 Z"/>
						</svg>
					</span>

                    <a href="javascript:void(0)">My Account <i class="icon ion-arrow-down-b"></i></a>

                </div>

                <!-- user-list-->

                <?php if(empty(session()->get('userLogin')) || session()->get('userLogin') == 0){ ?>		

               	<div class="users-dropown signin-dropdown">

                    <div class="signup-title">

                        <h3>Sign In</h3>

                        <p>Get access to our Secret Insider Prices</p>

                    </div>

                    <div class="users-dropown-list">

                        <ul>

                            <li class="signout-link">

                                <a href="<?php echo e('userlogin/simple'); ?>" class="login-link">Log In</a>

                            </li>

                        </ul>

                        <p class="signout-link">Need an Account? <a href="<?php echo e(url('signup')); ?>" class="signup-link">Sign Up</a></p>

                    </div>

                </div>

                <?php }else{ ?>

                <div class="users-dropown">

                    <div class="users-d-desp">

                        <h3>Hello <?php echo e(session()->get('userName')); ?></h3>

                        <p><?php echo e(session()->get('userEmail')); ?></p>

                    </div>

                    <div class="users-dropown-list">

                        <ul>

                        	<?php if(intval(session()->get('userStatus')) == 0){ ?>

                            <li>

                                <a href="<?php echo e(url('resend-confirmation')); ?>">Activate Account</a>

                            </li>

                            <?php } ?>

                            <li>

                                <a href="<?php echo e(URL::to('user\profile')); ?>">Your Profile</a>

                            </li>

                            <li>

                                <a href="<?php echo e(URL::to('user\travelers')); ?>">Travelers</a>

                            </li>

                            <li>

                                <a href="<?php echo e(URL::to('user\trip')); ?>">Trip Settings</a>

                            </li>

                            <li>

                                <a href="<?php echo e(URL::to('user\password')); ?>">Password</a>

                            </li>

                            <li>

                               <a href="<?php echo e(URL::to('user\reservations')); ?>">Your Reservations</a>

                            </li>

                            <li>

                                <a href="<?php echo e(URL::to('user\billInformation')); ?>">Billing Information</a>

                            </li>

                            <li>

                                <a href="<?php echo e(URL::to('user\History')); ?>">History</a>

                            </li>

                            <li class="signout-link">

                                <a href="user_logout">Sign Out</a>

                            </li>

                        </ul>

                    </div>

                </div>

               <?php } ?>

               <!-- user-list-->

            </div>

        	<div class="clear"></div>

        </div>

    </div>

</div>