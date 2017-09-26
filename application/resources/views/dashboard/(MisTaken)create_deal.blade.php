@extends('adminlayouts.main')

@section('content')

<!--main content-->

<div class="admin-wrapper">

    <div class="admin-wrap-head">

        <div class="admin-w-left"> <i class="fa fa-fire" aria-hidden="true"></i> <span class="admin-breadcrumb"><a href="#">Deals</a> /</span> <span>Deals list</span> </div>

        <div class="admin-w-right">

            <button class="btn btn-save">Create Deal</button>

        </div>

    </div>

    <div class="admin-wrap-inner">

    @include('flash.flash')

        <div class="main-booking deals-page">

            <ul class='tabs-model'>

                <li><a href='#tab1'>All Deals</a></li>

                <li><a href='#tab2'>Active</a></li>

                <li><a href='#tab3'>Inactive</a></li>

                <li><a href='#tab4'>Admin Created</a></li>

            </ul>

            <div id='tab1' class="tabs-content">

                <table class="table" cellpadding="0" cellspacing="0" id="allDeals">

                    <thead>

                    <tr>

                        <th width="75">

                        	<div class="select-all-check">

                                <div class="squaredThree">

                                    <input data-required="true" id="squared1" value="" name="sameAsAbove" type="checkbox">

                                    <i class="fa fa-check"></i>

                                </div>

                            </div>

                        </th>

                        <th class="th-align-center">

                        	<span class="chevron-th">Priority<i class="icon ion-arrow-down-b"></i><!--<i class="icon ion-arrow-up-b"></i>--></span>

                        </th>

                        <th>Accommodation Name</th>

                        <th>Location</th>

                        <th>Date Created</th>

                        <th>Category</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php 

					$counter = 1;

					if(count($alldeals) > 0){

					foreach($alldeals as $dealItem){

					?>

                    <tr>

                        <td>

                        <form method="post" action="{{url('admin/updatedealstatus')}}" class="all<?php echo $counter ?>">

                        	<div class="squaredThree">

                            	{!! csrf_field() !!}

                                <?php if($dealItem->deal_status == 1){ ?>

                                <input data-required="true" id="all<?php echo $counter ?>" name="dealId" type="checkbox" checked="checked">

                                <?php }else{ ?>

                                <input data-required="true" id="all<?php echo $counter ?>" name="dealId" type="checkbox">

								<?php } ?>

                                <input type="hidden" name="record_id" value="<?php echo $dealItem->id ?>" />

                                <i class="fa fa-check"></i>

                            </div>

                         </form>

                        </td>

                        <td align="center"><?php echo $counter ?></td>

                        <td class="link-color"><?php echo $dealItem->hotel_name ?></td>

                        <td><?php echo $dealItem->city.', '.$dealItem->state ?></td>

                        <td><?php echo date('m-d-Y',strtotime($dealItem->created_at)) ?></td>

                        <td><?php echo $dealItem->deal_name ?></td>

                        <td>

                        	

                        	<?php if($dealItem->deal_status == 1){echo '<span class="book-confirm">Active';}else{echo '<span class="book-confirm-inactive">Inactive';} ?>

                            </span>

                        </td>

					</tr>

                   	<?php $counter++; } } ?>

					<?php if($counter == 1){ ?>

                     <tr>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td align="center" colspan="7">No deals found</td>

                     </tr>

					<?php } ?>

                    </tbody>

                </table>

            </div>

            <div id='tab2' class="tabs-content">

            	<table class="table" cellpadding="0" cellspacing="0" id="activeDeals">

                    <thead>

                    <tr>

                        <th width="75">

                        	<div class="select-all-check">

                                <div class="squaredThree">

                                    <input data-required="true" id="squared1" value="" name="sameAsAbove" type="checkbox">

                                    <i class="fa fa-check"></i>

                                </div>

                            </div>

                        </th>

                        <th class="th-align-center">

                        	<span class="chevron-th">Priority<i class="icon ion-arrow-down-b"></i><!--<i class="icon ion-arrow-up-b"></i>--></span>

                        	

                        </th>

                        <th>Accommodation Name</th>

                        <th>Location</th>

                        <th>Date Created</th>

                        <th>Category</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php 

					if(count($activedeals) > 0){

					$counter = 1;

					foreach($activedeals as $dealItem){

					?>

                    <tr>

                        <td>

                        <form method="post" action="{{url('admin/updatedealstatus')}}" class="active<?php echo $counter ?>">

                        	<div class="squaredThree">

                            	{!! csrf_field() !!}

                                <input data-required="true" id="active<?php echo $counter ?>" name="dealId" type="checkbox" checked="checked">

                                <input type="hidden" name="record_id" value="<?php echo $dealItem->id ?>" />

                                <i class="fa fa-check"></i>

                            </div>

                        </form>

                        </td>

                        <td align="center"><?php echo $counter ?></td>

                        <td class="link-color"><?php echo $dealItem->hotel_name ?></td>

                        <td><?php echo $dealItem->city.', '.$dealItem->state ?></td>

                        <td><?php echo date('m-d-Y',strtotime($dealItem->created_at)) ?></td>

                        <td><?php echo $dealItem->deal_name ?></td>

                        <td><span class="book-confirm">Active</span></td>

					</tr>

                   	<?php $counter++; } } ?>

					<?php if($counter == 1){ ?>

                     <tr>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td align="center" colspan="7">No active deals found</td>

                     </tr>

					<?php } ?>

                    </tbody>

                </table>

            </div>

            <div id='tab3' class="tabs-content">

            	<table class="table" cellpadding="0" cellspacing="0" id="inactiveDeals">

                    <thead>

                    <tr>

                        <th width="75">

                        	<div class="select-all-check">

                                <div class="squaredThree">

                                    <input data-required="true" id="squared1" value="" name="sameAsAbove" type="checkbox">

                                    <i class="fa fa-check"></i>

                                </div>

                            </div>

                        </th>

                        <th class="th-align-center">

                        	<span class="chevron-th">Priority<i class="icon ion-arrow-down-b"></i><!--<i class="icon ion-arrow-up-b"></i>--></span>

                        	

                        </th>

                        <th>Accommodation Name</th>

                        <th>Location</th>

                        <th>Date Created</th>

                        <th>Category</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php 

					if(count($inactivedeals) > 0){

					$counter = 1;

					foreach($inactivedeals as $dealItem){

					?>

                    <tr>

                        <td>

                        <form method="post" action="{{url('admin/updatedealstatus')}}" class="inactive<?php echo $counter ?>">

                        	<div class="squaredThree">

                            	{!! csrf_field() !!}

                                <input data-required="true" id="inactive<?php echo $counter ?>" name="dealId" type="checkbox">

                                <input type="hidden" name="record_id" value="<?php echo $dealItem->id ?>" />

                                <i class="fa fa-check"></i>

                            </div>

                        </form>

                        </td>

                        <td align="center"><?php echo $counter ?></td>

                        <td class="link-color"><?php echo $dealItem->hotel_name ?></td>

                        <td><?php echo $dealItem->city.', '.$dealItem->state ?></td>

                        <td><?php echo date('m-d-Y',strtotime($dealItem->created_at)) ?></td>

                        <td><?php echo $dealItem->deal_name ?></td>

                        <td><span class="book-confirm">Inactive</span></td>

					</tr>

                   	<?php $counter++; } } ?>

					<?php if($counter == 1){ ?>

                     <tr>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td align="center" colspan="7">No inactive deals found</td>

                     </tr>

					<?php } ?>

                    </tbody>

                </table>

            </div>

            <div id='tab4' class="tabs-content">

                <table class="table" cellpadding="0" cellspacing="0" id="adminDeals">

                    <thead>

                    <tr>

                        <th width="75">

                        	<div class="select-all-check">

                                <div class="squaredThree">

                                    <input data-required="true" id="squared1" value="" name="sameAsAbove" type="checkbox">

                                    <i class="fa fa-check"></i>

                                </div>

                            </div>

                        </th>

                        <th class="th-align-center">

                        	<span class="chevron-th">Priority<i class="icon ion-arrow-down-b"></i><!--<i class="icon ion-arrow-up-b"></i>--></span>

                        </th>

                        <th>Accommodation Name</th>

                        <th>Location</th>

                        <th>Date Created</th>

                        <th>Category</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php 

					$counter = 1;

					if(count($admindeals) > 0){

					foreach($admindeals as $dealItem){

					?>

                    <tr>

                        <td>

                        <form method="post" action="{{url('admin/updatedealstatus')}}" class="admindeal<?php echo $counter ?>">

                        	<div class="squaredThree">

                            	{!! csrf_field() !!}

                                <?php if($dealItem->deal_status == 1){ ?>

                                <input data-required="true" id="admindeal<?php echo $counter ?>" name="dealId" type="checkbox" checked="checked">

                                <?php }else{ ?>

                                <input data-required="true" id="admindeal<?php echo $counter ?>" name="dealId" type="checkbox">

								<?php } ?>

                                <input type="hidden" name="record_id" value="<?php echo $dealItem->id ?>" />

                                <i class="fa fa-check"></i>

                            </div>

                         </form>

                        </td>

                        <td align="center"><?php echo $counter ?></td>

                        <td class="link-color"><?php echo $dealItem->hotel_name ?></td>

                        <td><?php echo $dealItem->city.', '.$dealItem->state ?></td>

                        <td><?php echo date('m-d-Y',strtotime($dealItem->created_at)) ?></td>

                        <td><?php echo $dealItem->deal_name ?></td>

                        <td>

                        	<span class="book-confirm">

                        	<?php if($dealItem->deal_status == 1){echo 'Active';}else{echo 'Inactive';} ?>

                            </span>

                        </td>

					</tr>

                   	<?php $counter++; } } ?>

					<?php if($counter == 1){ ?>

                     <tr>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td style="display:none;" colspan="1"></td>

                     <td align="center" colspan="7">No admin deals found</td>

                     </tr>

					<?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!--main content-->

@endsection 