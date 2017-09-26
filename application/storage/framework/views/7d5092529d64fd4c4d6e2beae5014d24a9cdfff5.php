<?php $__env->startSection('content'); ?>
<!--main content-->
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<div class="content-wrapper">
    <div class="content-heading"> <em class="fa  fa-map-marker" aria-hidden="true"></em> <span class="admin-breadcrumb"><a href="#">Destinations </a>  </span>   </div> <?php echo $__env->make('flash.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="row">
        <div class="col-lg-12">
            <!-- START panel-->
            <div id="panelDemo14" class="panel panel-default">
                <div class="panel-body panel-tabs">
                    <div class="tb-panel" role="tabpanel">
                        <ul role="tablist" class="nav nav-tabs">
                            <li role="presentation" class="active"><a  href="#home" aria-controls="home" role="tab"  onclick="getValue(this)" data-toggle="tab" id="all">All Destinations</a>                                </li>
                            <li role="presentation"><a  href="#profile" aria-controls="profile" role="tab" data-toggle="tab"  onclick="getValue(this)" id="active">Active</a> </li>
                            <li
                                role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"  onclick="getValue(this)" id="in_active">Inactive</a> </li>
                        </ul>
					</div>
				</div>	
				<div class="panel-body">	
                        <table id="dest" class="table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="75"> <i class="fa fa-check"></i> </th>
                                    <th class="th-align-center"> <span class="chevron-th">Priority<i class="icon ion-arrow-down-b"></i>                                    <!--<i class="icon ion-arrow-up-b"></i>--></span>                                        </th>
                                    <th>Destination Code</th>
                                    <th>Destination Name</th>
                                    <th>Destination Image</th>
                                    <th>Status</th>
                                    <th>
                                        <div data-toggle="tooltip" class="checkbox c-checkbox"> <label>  
                                          <input type="checkbox">          
                          
                            <span class="fa fa-check"></span>  
                             </label>                                            </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                              </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    url = '';
    filter_record_var = 'all';
    function getValue(xyz){
        filter_record_var  = xyz.id;
        console.log(filter_record_var);
        $('#dest').DataTable().ajax.url('<?php echo e(url('admin/destinations')); ?>?value='+filter_record_var).load();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        var table =  $("#dest").dataTable({
            "bProcessing" : true,
            "sAjaxSource" : "<?php echo e(url('admin/destinations')); ?>?value="+filter_record_var,
            "bPaginate":true, // Pagination True
            "sPaginationType" : "full_numbers",
            "bServerSide" : true,
            "iDisplayLength": 10,
            "aaSorting": [[0,'asc']],
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
                    "mDataProp": "hotelgroupcode",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                },
                {
                    "bSortable": true,
                    "bSearchable": true,
                    "mDataProp": "hotelgroupname",
                    "sDefaultContent": "-",
                    "sWidth": "10%"

                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "mDataProp": "hotelgroupimage",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                }
                ,
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "mDataProp": "status",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                },
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

 function updateBox(counter) {
//     currForm = 'all'+counter;
//        $('input[name=destId]').attr('disabled', 'disabled');
//        $('.' + currForm).submit();
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     var checkbox = $("#all"+counter).val();
     var record_id = $("#record_id"+counter).val();
     $.ajax({
         type : "POST",
         url : "<?php echo e(url('admin/update-destination-status')); ?>",
         data:{"checkbox": checkbox, "record_id":record_id},
         success : function(data) {
             console.log(data);
             if (data == 'in-active' || data == 'active') {
                 location.reload();
             }
         }
     });
    }

    function submitform(counter){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var title_image = $('#file'+counter).prop('files')[0];
        var image = $('#update_image_form'+counter)[0].files;
        var form = new FormData($("#update_image_form"+counter)[0]);
        form.append('image', title_image);
        if( $('#file'+counter).val() != ""){

            $.ajax({
                url:"<?php echo e(url('admin/update-destination-image')); ?>", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: form, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,        // To send DOMDocument or non processed data file it is set to false
                success: function (data)   // A function to be called if request succeeds
                {
                    if(data== 'success'){
                        location.reload();
                    }
                    else if(data == "fail"){
                        alert('Image not updated due to unknown error');
                    }
                    else if(data == "Chosse PNG, JPEG or JPG images only"){
                        alert('Please Chosse PNG, JPEG or JPG images only ');
                    }else if(data == "under_size"){
                        alert('Please select images of width 450 or 550 and height 550 or 350');
                    }
                }
            });
        }else{
            alert('Please chose file');
        }


    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlayouts.main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>