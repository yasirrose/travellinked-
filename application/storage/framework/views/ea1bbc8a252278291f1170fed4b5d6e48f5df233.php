<?php $__env->startSection('content'); ?>
    <!--main content-->
<div class="content-wrapper">
<div class="content-heading">
    <em class="fa fa-laptop"></em>

    <span class="admin-breadcrumb"><a href="#">API</a> </span>

    <div class="pull-right">
        <button class="btn btn-cancel">Cancel</button> <a href="<?php echo e(url('admin/api')); ?>" class="btn btn-primary">Add API</a>

    </div>
</div>
    <?php echo $__env->make('flash.flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
    <div class="panel-body">

        <div class="table-responsive">

            <table id="apiTbl" class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>User Name</th>

                    <th>Password</th>

                    <th>Provider</th>

                    <th>Action</th>
                    <th> <div class="select-all-check">
                            <div data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox">
                                <label>
                                    <input type="checkbox">
                                    <span class="fa fa-check"></span>
                                </label>
                            </div>
                        </div></th>
                </tr>
                </thead>
                <tbody>
               <?php $counter = 1;
                 foreach($api_detail as $api){
                    ?>

                <tr>
              
                    <td><?php echo $api->api_name; ?></td>

                    <td><?php echo $api->api_user; ?></td>

                    <td><?php echo $api->api_password; ?></td>

                    <td><?php echo $api->api_provider; ?></td>

                    <td><a href="<?php echo e(url('admin/api/edit/'.$api->id)); ?>" class="btn btn-success btn-xs">Edit</a>

                        <a href="<?php echo e(url('admin/api/delete/'.$api->id)); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Do you want to delete?')">Delete</a></td>
            
                   <td>
                       <form method="post" action="<?php echo e(url('admin/updateApistatus')); ?>" class="all<?php echo $counter ?>">

                       <div class="checkbox c-checkbox">
                           <label>

                               <input type="hidden"  name="Id" value="<?php echo $api->id ?>" />

                               <?php echo csrf_field(); ?>

                       <?php if ($api->is_active == 0){?>
                       <input type="checkbox"  id="all<?php echo $counter ?>" name="ApiId" data-required="true"><span class="fa fa-check"></span>
                       
                       <?php }  else{ ?>
                           <input type="checkbox" id="all<?php echo $counter ?>" name="ApiId" data-required="true" checked><span class="fa fa-check"></span>
                           <?php } ?>
                           </label>
                       </div>
                       </form>
                   </td>
                </tr>


                <?php $counter++; }  ?>

                </tbody>
            </table>
        </div>
    </div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

    <script>
              $('#apiTbl').dataTable({
                  'paging':   true,  // Table pagination
                  'ordering': true,  // Column ordering
                  'info':     true,  // Bottom left status text
                  'responsive': true, // https://datatables.net/extensions/responsive/examples/
                  // Text translation options
                  // Note the required keywords between underscores (e.g _MENU_)
                  oLanguage: {
                      sSearch:      'Search all columns:',
                      sLengthMenu:  '_MENU_ records per page',
                      info:         'Showing page _PAGE_ of _PAGES_',
                      zeroRecords:  'Nothing found - sorry',
                      infoEmpty:    'No records available',
                      infoFiltered: '(filtered from _MAX_ total records)'
                  },
                  // Datatable Buttons setup
                  dom: '<"html5buttons"B>lTfgitp',
                  buttons: [
                      {extend: 'copy',  className: 'btn-sm' },
                      {extend: 'csv',   className: 'btn-sm' },
                      {extend: 'excel', className: 'btn-sm', title: 'XLS-File'},
                      {extend: 'pdf',   className: 'btn-sm', title: $('title').text() },
                      {extend: 'print', className: 'btn-sm' }
                  ]
              });


    </script>
    <script>
        var element = document.getElementById("<?php echo e($activeID); ?>");
        element.classList.add("active");
    </script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlayouts.main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>