<?php $__env->startSection('content'); ?>
    <!--main content-->
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-heading">
            <em class="fa fa-laptop"></em>
            <span class="admin-breadcrumb">
                <a  href="#">Import Hotel Groups Codes </a>
                </span>
             </div>
        <div class="panel-body">
            <div class="panel panel-default">
        <div class="row fileupload-buttonbar">
            <?php echo $__env->make("flash.flash", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <form action="<?php echo e(url('admin/update-hotels-with-codes')); ?>" method="post"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="col-md-12">
                    <div class="col-md-4"></div>
                    <div class="col-md-4" style="text-align: center">
                    <h3>Upload file <span>(name: HotelGroupHotels)</span>
                    </h3>
                    <span class="btn btn-success fileinput-button">
                        <i class="fa fa-fw fa-plus"></i>
                        <span>Add files...</span>
                        <input type="file" name="hotelcodes">
                    </span> <br> <br>
                    <button class="btn btn-primary" type="submit">Import</button>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </form>
        </div>
                <br><br><br>
            </div>
        </div>
    </div>
</div>
<!--main content-->
    <script>
        var element = document.getElementById("<?php echo e($activeID); ?>");
        element.classList.add("active");
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlayouts.main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>