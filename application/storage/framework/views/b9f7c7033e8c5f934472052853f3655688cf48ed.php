<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->



<?php $__env->startSection('content'); ?>



<!--main content-->
    <div class="content-wrapper">
        <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <h1>Hello Dashboard</h1>
                </div>
                <div class="col-md-4">

                </div>

            </div>

        </div>
        </div>

    </div>


<script>
    var element = document.getElementById("<?php echo e($activeID); ?>");
    element.classList.add("active");
</script>

<!--main content-->



<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlayouts.main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>