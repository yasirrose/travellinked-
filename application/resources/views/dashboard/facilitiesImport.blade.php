@extends('adminlayouts.main2')
@section('content')
    <!--main content-->
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-heading">
                <em class="fa fa-laptop"></em>
                <span class="admin-breadcrumb">
                    <a href="#">Import Hotel Facilities </a> </span>

            </div>
            <div class="panel-body">
                <div class="panel panel-default">
            <div class="row fileupload-buttonbar">
                @include("flash.flash")
                <form action="{{url('admin/importFacilityFile')}}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="col-md-12">
                        <div class="col-md-4"></div>
                       <div class="col-md-4" style="text-align: center">
                        <h3>Facilities <span>(file should be csv)</span>
                        </h3>
                        <span class="btn btn-success fileinput-button"><i class="fa fa-fw fa-plus"></i>
                            <span>Add files...</span>
                            <input  type="file" name="facility">
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
    </div><!--main content-->
    <script>
        var element = document.getElementById("{{$activeID}}");
        element.classList.add("active");
    </script>

@endsection