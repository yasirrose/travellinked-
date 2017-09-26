<!DOCTYPE html>
<html>
    <head>
        <title>Internal server error.</title>

       <link href="{{url('/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
			.back{
				font-size:20px;
				}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Internal Server Error
               
                </div>
                 <a class="back" href="{{url('/')}}"><strong>Home</strong></a>
            </div>
        </div>
    </body>
</html>
