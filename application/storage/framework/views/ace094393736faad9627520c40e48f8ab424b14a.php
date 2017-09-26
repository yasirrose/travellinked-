<!DOCTYPE html><html lang="en"><head>  <meta charset="utf-8">  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <meta name="viewport" content="width=device-width, initial-scale=1">  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->  <title>login</title>  <style>  .logo-main > a {    font-family: 'Playfair Display', serif;    font-size: 18px;    color: rgba(255, 255, 255, 0.9);    display: inline-block;    vertical-align: middle;    text-decoration: none;    line-height: 32px;    padding-right: 10px;    margin-right: 10px;    position: relative;}.logo-main a em {    font-size: 24px;    font-style: normal;    vertical-align: baseline;}.logo-main span {    font-family: 'AvenirNextLTPro-Regular';    font-size: 14px;    color: rgba(255, 255, 255, 0.8);    vertical-align: middle;    float: left;    line-height: 35px;}.logo-main span a {    color: rgba(255, 255, 255, 0.8);    text-decoration: none;}  </style>   <!-- =============== VENDOR STYLES ===============-->   <!-- FONT AWESOME-->   <link rel="stylesheet" href="<?php echo e(URL('assets/angle/fontawesome/css/font-awesome.min.css')); ?>">   <!-- SIMPLE LINE ICONS-->   <link rel="stylesheet" href="<?php echo e(URL('assets/angle/simple-line-icons/css/simple-line-icons.css')); ?>">   <!-- =============== BOOTSTRAP STYLES ===============-->   <link rel="stylesheet" href="<?php echo e(URL('assets/angle/css/bootstrap.css')); ?>" id="bscss">   <!-- =============== APP STYLES ===============-->   <link rel="stylesheet" href="<?php echo e(URL('assets/angle/css/app.css')); ?>" id="maincss"></head><body>   <div class="wrapper">      <div class="block-center mt-xl wd-xl">         <!-- START panel-->         <div class="panel panel-dark panel-flat">            <div class="panel-heading text-center">              <div class="logo-main">                 <a href="http://travellinked.com/travellinked"><em>T</em>RAVEL <em>L</em>INKED</a>               </div>            </div>            <div class="panel-body">               <p class="text-center pv">SIGN IN TO CONTINUE.</p>               <form data-parsley-validate="" novalidate="" class="mb-lg" role="form" method="POST" action="<?php echo e(url('admin/signin')); ?>">                  <?php echo e(csrf_field()); ?>                  <div class="form-group has-feedback">                     <input id="exampleInputEmail1" type="email" name="email" placeholder="Enter email" autocomplete="off" required class="form-control">                     <span class="fa fa-envelope form-control-feedback text-muted"></span>                  </div>                  <div class="form-group has-feedback">                     <input id="exampleInputPassword1" type="password" name="password" placeholder="Password" required class="form-control">                     <span class="fa fa-lock form-control-feedback text-muted"></span>                  </div>                  <div class="clearfix">                     <div class="checkbox c-checkbox pull-left mt0">                        <label>                           <input type="checkbox" value="" name="remember">                           <span class="fa fa-check"></span>Remember Me</label>                     </div>                     <div class="pull-right"><a href="recover.html" class="text-muted">Forgot your password?</a>                     </div>                  </div>                  <button type="submit" class="btn btn-block btn-primary mt-lg">Login</button>               </form>            </div>         </div>         <!-- END panel-->         <div class="p-lg text-center">            <span>&copy;</span>            <span>2017</span>            <span>-</span>            <span>TravelLinked</span>            <br>            <span>Best Travel Agency</span>         </div>      </div>   </div>   <!-- =============== VENDOR SCRIPTS ===============-->   <!-- MODERNIZR-->   <script src="<?php echo e(URL('assets/angle/modernizr/modernizr.custom.js')); ?>"></script>   <!-- JQUERY-->   <script src="<?php echo e(URL('assets/angle/jquery/dist/jquery.js')); ?>"></script>   <!-- BOOTSTRAP-->   <script src="<?php echo e(URL('assets/angle/bootstrap/dist/js/bootstrap.js')); ?>"></script>   <!-- STORAGE API-->   <script src="<?php echo e(URL('assets/angle/jQuery-Storage-API/jquery.storageapi.js')); ?>"></script>   <!-- PARSLEY-->   <script src="<?php echo e(URL('assets/angle/parsleyjs/dist/parsley.min.js')); ?>"></script>   <!-- =============== APP SCRIPTS ===============-->   <script src="<?php echo e(URL('assets/angle/js/app.js')); ?>"></script></body></html>