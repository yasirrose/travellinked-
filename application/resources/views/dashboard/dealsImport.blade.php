@extends('adminlayouts.main2')

@section('content')



    <!--main content-->

    <div class="wrapper">
        <div class="content-wrapper">

            <div class="content-heading">
                <i class="fa fa-user"></i>
                <span class="admin-breadcrumb"><a href="#">Dashboard </a> /</span>

                <span>Import Hotel Deals</span>

            </div>


            <div class="row fileupload-buttonbar">

                @include("flash.flash")

                <form action="{{url('admin/importDealsFile')}}" method="post" enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="col-lg-7">

                        <h4>Deals <span>(file should be csv)</span></h4>
                        <span class="btn btn-success fileinput-button"><i class="fa fa-fw fa-plus"></i>
                        <span>Add files...</span>
                       <input  type="file" name="deals">
                            </span>

                        <br>
                        <br>
                        <button class="btn btn-primary" type="submit">Import</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!--main content-->



@endsection

