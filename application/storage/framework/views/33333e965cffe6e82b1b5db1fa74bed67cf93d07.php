<?php $__env->startSection('content'); ?>



    <!--main content-->

    <div class="wrapper">
        <div class="content-wrapper">

            <div class="content-heading">
                <i class="fa fa-user"></i>
                <span class="admin-breadcrumb"><a href="#">Dashboard </a> /</span>

                <span>Import Hotel Deals</span>

            </div>


            <div class="row fileupload-buttonbar">

                <?php echo $__env->make("flash.flash", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <form action="<?php echo e(url('admin/importDealsFile')); ?>" method="post" enctype="multipart/form-data">

                    <?php echo csrf_field(); ?>


                    <div class="col-lg-7">

                        <h4>Deals <span>(file should be csv)</span></h4>
                        <span class="btn btn-success fileinput-button"><i class="fa fa-fw fa-plus"></i>
                        <span>Add files...</span>
                       <input  type="file" name="deals">
                            </span>

                        <br>
                        <br>
                        <button class="btn btn-primary" type="submit">Import</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!--main content-->



<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlayouts.main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>