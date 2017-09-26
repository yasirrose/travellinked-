@extends('adminlayouts.main2')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
  <div class="content-heading">
    <i class="fa fa-user"></i>
       <span class="admin-breadcrumb"><a href="#">Customers</a> /</span>
        <span>All Customers</span>
     <div class="pull-right">
   </div>
</div>

        <div class="panel panel-default">

        <div class="panel-body panel-tabs">
          <div role="tabpanel">
             <!-- Nav tabs-->
             <ul role="tablist" class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#AllCustomers" aria-controls="AllCustomers" role="tab" data-toggle="tab" aria-expanded="true" id="all" onclick="getValue(this)">All Customers</a>
                </li>
                <li role="presentation" class=""><a href="#RepeatCustomers" aria-controls="RepeatCustomers" role="tab" data-toggle="tab" aria-expanded="false" id="repeat" onclick="getValue(this)">Repeat Customers</a>
                </li>
                <li role="presentation"class=""><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false" id="b2c" onclick="getValue(this)">B2C Customers</a>
                </li>
                <li role="presentation"  class=""><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false" id="b2b" onclick="getValue(this)">B2B Customers</a>

                  <li role="presentation"  class=""><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false" id="prospects" onclick="getValue(this)">Prospects</a>


                </li>
             </ul>
             <!-- Tab panes-->

          </div>
        </div>
 <div class="panel-body">
            <div class="table-responsive">
                <table id="AllCustomersList" class="table table-striped table-hover">
                    <thead>
                    <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th style="text-align:center;">Bookings</th>
                            <th style="text-align:center;">Last Booking</th>
                            <th>Total</th>
                            <th width="10%">Active/Deactive</th>
                    </tr>
                    </thead>
                    <tbody id='TableBody'>
                      </tbody>
                    </table>
                           </div>
                         </div>
                       </div>
                     </div>






@endsection

@section('script')
<script type="text/javascript">
    url = '';
    filter_record_var = 'all';
    function getValue(xyz){
        filter_record_var  = xyz.id;
        console.log(filter_record_var);

        $('#AllCustomersList').DataTable().ajax.url('{{url('admin/users')}}?value='+filter_record_var).load();
        if(filter_record_var != 'all'){
           alert('Work in progress');
        }

    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {

        var table =  $("#AllCustomersList").dataTable({
            "bProcessing" : true,
            "sAjaxSource" : "{{url('admin/users')}}?value="+filter_record_var,
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
                    "mDataProp": "id",
                    "sDefaultContent": "-",
                    "sWidth": "15%"
                },
                {
                    "bSortable": true,
                    "bSearchable": true,
                    "mDataProp": "country",
                    "sDefaultContent": "-",
                    "sWidth": "15%"
                },
                {
                    "bSortable": false,
                    "bSearchable": true,
                    "mDataProp": "booking",
                    "sDefaultContent": "-",
                    "sWidth": "3%"
                },
                {
                    "bSortable": false,
                    "bSearchable": true,
                    "mDataProp": "last_booking",
                    "sDefaultContent": "-",
                    "sWidth": "10%"

                },
                {
                    "bSortable": false,
                    "bSearchable": true,
                    "mDataProp": "total",
                    "sDefaultContent": "-",
                    "sWidth": "15%"
                }
                ,
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "mDataProp": "status",
                    "sDefaultContent": "-",
                    "sWidth": "15%"
                }
            ]

        } );
    } );


    var filters = [];
    var nameStr = '';
    /*====== main site url and current url =========*/
    var pathArray = location.href.split('/');
    var protocol = pathArray[0];
    var host = pathArray[2];
    var site_url = protocol + '//' + host + "/travellinked";
function getFilteredRecords(tabName){
      $.ajax({
        url: "{{URL('admin/users/getFilteredRecords')}}",
        type: "POST",
        data:{
          "Filter" : tabName,
          "_token": "{{csrf_token()}}"
        },
        success: function(data){
          data = JSON.parse(data);

            if(data.status){
              var element = document.getElementById('TableBody');
              element.innerHTML = data.html;
             
            }
            else{
              console.log(data);
            }
        },
        error: function(){

        }
      });

}

function deleteuser(id) {

    $.ajax({
        url: "{{URL('/admin/users/deleteuser')}}",
        type: "POST",
        data:{
            "id":id,
            "_token": "{{csrf_token()}}"
        },
        success:function () {
           location.reload();
        }

    });
}

function userAction(status,id){

    var status =status;

    $.ajax({
        url: site_url + "/admin/user/disable",
        type: "POST",
        data:{
            "status" : status,
            "id":id,
            "_token": "{{csrf_token()}}"
        },
        success:function (data) {
           location.reload();
        },
        error:function () {
            console.log(data)
        }
})
}
//function initTable(){
//        $('#AllCustomersList').dataTable({
//              'paging':   true,  // Table pagination
//              'ordering': true,  // Column ordering
//              'info':     true,  // Bottom left status text
//              'responsive': true, // https://datatables.net/extensions/responsive/examples/
//              // Text translation options
//              // Note the required keywords between underscores (e.g _MENU_)
//
//              // Datatable Buttons setup
//              dom: '<"html5buttons"B>lTfgitp',
//              buttons: [
//              {extend: 'copy',  className: 'btn-sm' },
//              {extend: 'csv',   className: 'btn-sm' },
//              {extend: 'excel', className: 'btn-sm', title: 'XLS-File'},
//              {extend: 'pdf',   className: 'btn-sm', title: $('title').text() },
//              {extend: 'print', className: 'btn-sm' }
//              ]
//      });
//}
//initTable();

</script>
{{--<script>--}}
    {{--var element = document.getElementById("{{$activeID}}");--}}
    {{--element.classList.add("active");--}}
{{--</script>--}}
@endsection
