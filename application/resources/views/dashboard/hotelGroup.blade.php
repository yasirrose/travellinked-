@extends('adminlayouts.main2')@section('content')
    <!--main content-->    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-heading">
                <em class="fa fa-laptop"></em>
                <span class="admin-breadcrumb">
                    <a href="#">Import Hotel Codes </a> </span>

            </div>
            <div class="panel-body">
                <div class="panel panel-default">
            <div class="row fileupload-buttonbar">
                @include("flash.flash")
                <form action="{{url('admin/importFile')}}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="col-md-12">
                        <div class="col-md-4"></div>

                        <div class="col-md-4" style="text-align: center">

                            <h2>hotel group code</h2>
                            <span class="btn btn-success fileinput-button">
                            <i class="fa fa-fw fa-plus"></i>
                            <span>Add files...</span>
                            <input type="file" name="hotelGroup">
                        </span>
                            <br>
                            <br>
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
        var element = document.getElementById("{{$activeID}}");
        element.classList.add("active");
    </script>
@endsection