@extends('adminlayouts.main2')
@section('content')
    <!--main content-->
<div class="content-wrapper">
    <div class="content-heading">
        <em class="fa fa-check-square-o"></em>
            <span class="admin-breadcrumb"><a href="#">Bookings </a> </span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
                <!-- START panel-->
        <div id="panelDemo14" class="panel panel-default">
            @if (session('error'))
                <div class="alert alert-danger">
                    <strong> {{ session('error') }}</strong>
                </div>
            @endif
            <div class="panel-body panel-tabs">
                <div class="tb-panel" role="tabpanel">
                    <!-- Nav tabs-->
                    <ul role="tablist" class="nav nav-tabs">
                        <li role="presentation" class="active" id="allbookings"><a
                                    onclick="getValue(this)" href="#home" aria-controls="home"
                                    role="tab" data-toggle="tab" id="all">All Bookings</a>
                        </li>
                        <li role="presentation" id="pendingbookings"><a
                                    href="#profile" aria-controls="profile" role="tab"
                                    data-toggle="tab" onclick="getValue(this)" id="pending">Pending</a>
                        </li>
                        <li role="presentation" id="canceled"><a
                                    href="#messages" aria-controls="messages" role="tab" data-toggle="tab" onclick="getValue(this)" id="cancel">Canceled</a>
                        </li>
                        <li role="presentation" id="approved"><a
                                    href="#settings" aria-controls="settings" role="tab" data-toggle="tab" onclick="getValue(this)" id="confirm">Confirmed</a>
                        </li>
                    </ul>
                    <!-- Tab panes-->
                </div>
            </div>
                <div class="panel-body">
                    <table id="dtable" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th><i class="fa fa-check"></i></th>
                            <th>Order#</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Payment Status</th>
                            <th>Fulfillment Status</th>
                            <th>Total</th>
                            <th id="showBox">Action</th>

                        </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>

                    </table>
                </div>
        </div>
    </div>
    <!-- END panel-->
</div>
    <!--main content-->
@endsection
@section('script')
<script type="text/javascript">
    url = '';
    filter_record_var = 'all';
    function getValue(xyz){
        filter_record_var  = xyz.id;
        console.log(filter_record_var);
        $('#dtable').DataTable().ajax.url('{{url('admin/bookings_details')}}?value='+filter_record_var).load();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        var table =  $("#dtable").dataTable({
            "bProcessing" : true,
            "sAjaxSource" : "{{url('admin/bookings_details')}}?value="+filter_record_var,
            "bPaginate":true, // Pagination True
            "sPaginationType" : "full_numbers",
            "bServerSide" : true,
            "iDisplayLength": 10,
            "aaSorting": [[0,'asc']],
            "sServerMethod" : "POST",
            "aoColumns": [
                {
                    "bSortable": true,
                    "bSearchable": false,
                    "mDataProp": "check",
                    "sDefaultContent": "-",
                    "sWidth": "5%"
                },
                {
                    "bSortable": true,
                    "bSearchable": true,
                    "mDataProp": "booking_id",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                },
                {
                    "bSortable": true,
                    "bSearchable": true,
                    "mDataProp": "booking_date",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                },
                {
                    "bSortable": true,
                    "bSearchable": true,
                    "mDataProp": "booking_email",
                    "sDefaultContent": "-",
                    "sWidth": "10%"

                },

                {
                    "bSortable": false,
                    "bSearchable": false,
                    "mDataProp": "status",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                },
                {
                    "bSortable": true,
                    "bSearchable": true,
                    "mDataProp": "full_fillment",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                },
                {
                    "bSortable": true,
                    "bSearchable": true,
                    "mDataProp": "amountWithTax",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "mDataProp": "action",
                    "sDefaultContent": "-",
                    "sWidth": "10%"
                }
            ]
        } );
    } );

function getdelete(id) {
        $.ajax({
            url: "{{URL('/admin/delete_booking')}}",
            type: "POST",
            data: {
                "id": id,
                "_token": "{{csrf_token()}}"
            },
            success: function () {
//                location.reload();
            }
        });
    }
</script>
{{--<script>--}}
                {{--var element = document.getElementById("{{$activeID}}");--}}
                {{--element.classList.add("active");--}}
            {{----}}
{{--</script>--}}
@endsection
