<! DOCTYPE html>

<head>

<title></title>



</head>



<body>





    <?php if(session()->has('success')): ?>

       

        <div style="background-color:#0fbd71; color:#fff; font-size:16px;" class="alert alert-success alert-success fade in" role="alert">

         <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                      <span aria-hidden="true">×</span></button>

                      <strong>Congrats!</strong>

         <?php echo e(session()->get('success')); ?></div>

    <?php endif; ?>





   <?php if(session()->has('error')): ?>

        <div style="background-color:#a94442; color:#fff; font-size:16px;" class="alert alert-warning alert-danger fade in" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close">

          <span aria-hidden="true">×</span></button>

          <strong>Sorry!</strong>&nbsp;

           <?php echo e(session()->get('error')); ?>


           </div>



 	<?php endif; ?>

    <?php if(session()->has('access')): ?>

        <div style="background-color:#a94442; color:#fff; font-size:16px;" class="alert alert-warning alert-danger fade in" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close">

          <span aria-hidden="true">×</span></button>

          <strong>Alert!</strong>&nbsp;

           <?php echo e(session()->get('access')); ?>


           </div>



 	<?php endif; ?>



  <?php if(session()->has('messages')): ?>

         <div class="alert alert-warning alert-danger fade in" role="alert">

           <button type="button" class="close" data-dismiss="alert" aria-label="Close">

           <span aria-hidden="true">×</span></button>

           <strong>Sorry!</strong>  You have failed.

           <ul>

           <?php foreach(session()->get('messages')->all() as $message): ?>

               <li><?php echo e($message); ?></li>

           <?php endforeach; ?>

           </ul>

         </div>

  <?php endif; ?>



  

</body>

</html>