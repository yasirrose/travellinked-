<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php /*<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">*/ ?>
<input type="hidden" value="<?php echo e(csrf_token()); ?>" id="csrf">
    <div class="content-wrapper">
      <div class="content-heading">
          <em class="fa fa-fire"></em>
                    <span class="admin-breadcrumb"><a href="#">All Deals </a> </span>

                </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- START panel-->
                <div id="panelDemo14" class="panel panel-default">
                    <div class="panel-body panel-tabs">
                        <div class="tb-panel" role="tabpanel">
                            <ul role="tablist" class="nav nav-tabs">
                                <li role="presentation" id="all_deals" class="active"><a href="#home" aria-controls="home" role="tab" id="all" onclick="getValue(this)" data-toggle="tab">All Deals</a>
                                </li>
                                <li role="presentation" ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" id="active" onclick="getValue(this)">Active</a>
                                </li>
                                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab" onclick="getValue(this)" id="in-active">Inactive</a>
                                </li>
                                <li role="presentation" id="admin-created"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" onclick="getValue(this)" id="admin_created" >Admin Created</a>
                                </li>
                            </ul>
						</div>
					</div>
					<div class="panel-body">		
                        <table id="datatable1" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th width="75"><i class="fa fa-check"></i></th>
                                 <th class="th-align-center"><span class="chevron-th">Priority<i class="icon ion-arrow-down-b"></i><!--<i class="icon ion-arrow-up-b"></i>--></span></th>
                                <th width="30%">Accommodation Name</th>
                                <th width="20%">Location</th>
                                <th width="20%">Date Created</th>
                                <th  width="20%"class="sort-numeric">Category</th>
                                <th  width="30%"class="sort-alpha">Status</th>
                                <th><div data-toggle="tooltip" class="checkbox c-checkbox"> <label><input type="checkbox" data-required="true" id="squared1" name="sameAsAbove"><span class="fa fa-check"></span></label></div></th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>

                        <input type="hidden" value="<?php echo e(url('load_deals')); ?>?page=1" id="pageNumber">
                        <input type="hidden" value="<?php echo e(url('load_deals')); ?>?page=2" id="pageNumber2">
                        <input type="hidden" value="" id="latestCardID">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php /*<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>*/ ?>
    <script>
        counter = 0;
        url = '';
        filter_record_var = 'all';
        function getValue(xyz){
            filter_record_var  = xyz.id;
            console.log(filter_record_var);
            $('#datatable1').DataTable().ajax.url('<?php echo e(url('admin/load_deals')); ?>?value='+filter_record_var).load();
        }
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          var table =  $("#datatable1").dataTable({
                "bProcessing" : true,
                "sAjaxSource" :'<?php echo e(url('admin/load_deals')); ?>?value='+filter_record_var,
                "bPaginate":true, // Pagination True
                "sPaginationType" : "full_numbers",
                "bServerSide" : true,
                "iDisplayLength": 10,
                "aaSorting": [[ 3, "desc" ]],
                "sServerMethod" : "POST",

                "aoColumns": [
                    {
                        "bSortable": false,
                        "bSearchable": false,
                        "mDataProp": "check",
                        "sDefaultContent": "-",
                        "sWidth": "5%"
                    },
                    {
                        "bSortable": false,
                        "bSearchable": true,
                        "mDataProp": "priority",
                        "sDefaultContent": "-",
                        "sWidth": "10%"
                    },
                    {
                        "bSortable": true,
                        "bSearchable": true,
                        "mDataProp": "HotelID",
                        "sDefaultContent": "-",
                        "sWidth": "10%"

                    },
                    {
                        "bSortable": true,
                        "bSearchable": true,
                        "mDataProp": "HotelID",
                        "sDefaultContent": "-",
                        "sWidth": "10%"
                    },
                    {
                        "bSortable": true,
                        "bSearchable": true,
                        "mDataProp": "created_at",
                        "sDefaultContent": "-",
                        "sWidth": "10%"
                    }
                    ,
                    {
                        "bSortable": false,
                        "bSearchable": true,
                        "mDataProp": "CustomerSpecialCode",
                        "sDefaultContent": "-",
                        "sWidth": "15%"

                    }
                    ,
                    {
                        "bSortable": false,
                        "bSearchable": false,
                        "mDataProp": "status",
                        "sDefaultContent": "-",
                        "sWidth": "10%"
                    }
                    ,
                    {
                        "bSortable": false,
                        "bSearchable": false,
                        "mDataProp": "checkbox",
                        "sDefaultContent": "-",
                        "sWidth": "10%"
                    }
                ]

            } );
        } );


    </script>
    <?php /*<script>*/ ?>
        <?php /*var element = document.getElementById("<?php echo e($activeID); ?>");*/ ?>
       <?php /*var a = element.classList.add("active");*/ ?>
       <?php /*alert(a);*/ ?>
    <?php /*</script>*/ ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlayouts.main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>