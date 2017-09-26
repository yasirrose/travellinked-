<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{url('assets/angle/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{url('/assets/angle/fontawesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('/assets/angle/css/app.css')}}?v={{ uniqid()}}">
    <link rel="stylesheet" href="{{url('/assets/angle/css/bootstrap.css')}}">
</head>
<body>
 <div class="wrapper">
        <div class="abs-center wd-xl">
            <!-- START panel-->
            <div class="p">
                <img src="{{url('assets/images/img-1.jpg')}}" alt="Avatar" width="60" height="60" class="img-thumbnail img-circle center-block">
            </div>
            <div class="panel widget b0">
                <div class="panel-body">
                    <p class="text-center">Please login to unlock your screen.</p>
                    <form role="form" action="{{url('admin/lock_password')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group has-feedback">
                            <input id="exampleInputPassword1" name="password" type="password" placeholder="Password" class="form-control">
                            <span class="fa fa-lock form-control-feedback text-muted"></span>
                        </div>
                        <div class="clearfix">
                            <div class="pull-left mt-sm">

                            </div>
                            <div class="pull-right"><button type="submit" class="btn btn-sm btn-primary">Unlock</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

<script src="{{url('/assets/angle/parsleyjs/dist/parsley.min.js')}}"></script>
<script src="{{url('/assets/angle/jquery/dist/jquery.js')}}"></script>

<script src="{{url('/assets/angle/bootstrap/dist/js/bootstrap.js')}}"></script>
<script src="{{url('/assets/angle/modernizr/modernizr.custom.js')}}"></script>

<script src="{{url('/assets/angle/jQuery-Storage-API/jquery.storageapi.js')}}"></script>
<script src="{{url('/assets/angle/js/app.js?v=12')}}"></script>
</body>
</html>