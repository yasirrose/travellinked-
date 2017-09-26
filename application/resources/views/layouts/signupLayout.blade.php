<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Linked</title>
    <link rel="shortcut icon" type="image/png" href="{{url('/assets/images/favicon.png')}}"/>
    <link href="{{url('/assets/css/ionicons.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}">
    <link href="{{url('/assets/css/style.css')}}?v={{ uniqid()}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/jquery-ui.css')}}">
    <link href="{{url('/assets/css/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
    <link href="{{url('/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/css/daterangepicker.css')}}?v={{ uniqid()}}">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
    <?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (stripos( $user_agent, 'Chrome') !== false)
    {}
    elseif(stripos( $user_agent, 'Safari') !== false)
    {
        $url = url('/assets/css/safari.css');
        echo '<link href="'.$url.'?v='.uniqid().'" rel="stylesheet">';
    }
    ?>
</head>

<body>

@yield('content')

<script src="{{url('/assets/js/jquery.min.js')}}?v={{ uniqid() }}"></script>
<script src="{{url('/assets/js/jquery.mCustomScrollbar.concat.min.js')}}?v={{ uniqid() }}"></script>
<script>
    (function($){
        $(window).on("load",function(){
            $(".become-member-right").mCustomScrollbar({
                axis:'y',
                mouseWheel:true
            });
        });
    })(jQuery);

</script>
</body>
</html>