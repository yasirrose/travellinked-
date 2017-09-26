<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->

@extends('adminlayouts.main2')

@section('content')



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
    var element = document.getElementById("{{$activeID}}");
    element.classList.add("active");
</script>

<!--main content-->



@endsection
