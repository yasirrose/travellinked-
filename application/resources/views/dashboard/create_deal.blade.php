@extends('adminlayouts.main2')

@section('content')

<!--main content-->

<div class="content-wrapper">
  <div class="content-heading">
      <em class="fa fa-fire"></em>
       <span class="admin-breadcrumb"><a href="#">Create Deal</a> </span>


        <div class="pull-right">
           <button class="btn btn-primary">Cancel</button>
             <button class="btn btn-primary">Save Deals</button>
      </div>
     <div class="pull-right">
   </div>
</div>

<div class="panel panel-default">
               <!-- <div class="panel-heading">Form elements</div> -->
               <div class="panel-body">
                        <form method="post" action="{{url('admin/insert-deal')}}" class="form-horizontal" id="create-deal">

            {!! csrf_field() !!}

                     <fieldset>
                           	@include('flash.flash')
                            <legend>Deal Information</legend>
                       <div class="form-group">
                          <label class="col-sm-2 control-label">Hotel Name</label>
                          <div class="col-sm-10">
                             <input type="text" name="hotel_name" placeholder="Type Hotel Name" class="form-control">
                          </div>
                          <div class="search-list-holder">
                              <datalist class="search_result"></datalist>
                          </div>
                          <input type="hidden" name="hotel_code" />
                       </div>
                       <br>
                       <div class="form-group">
                          <label class="col-sm-2 control-label">Deal Name</label>
                          <div class="col-sm-10">
                             <input type="text" name="deal_name" placeholder="Type Deal Name" class="form-control">
                          </div>
                       </div>

                       <br>
                        <div class="form-group">
                           <label class="col-sm-2 control-label">Start Date</label>
                           <div class="col-sm-10">
                              <input type="text" id="startDate" name="start_date" placeholder="mm/dd/yy" class="form-control">
                           </div>
                        </div>
                        <br>
                        <div class="form-group">
                           <label class="col-sm-2 control-label">End Date</label>
                           <div class="col-sm-10">
                              <input type="text" id="endDate" name="end_date" placeholder="mm/dd/yy" class="form-control">
                           </div>
                        </div>
                        <br>
                        <div class="form-group">
                           <label class="col-sm-2 control-label">Deal Basedon</label>
                           <div class="col-sm-10">
                             <select name="deal_basedon" required="required" class="form-control m-b">
                                 	<option value="Travel Date">Travel Date</option>
                                  <option value="Booking Window">Booking Window</option>
                               </select>
                           </div>
                        </div>
                        <br>
                        <div class="form-group">
                           <label class="col-sm-2 control-label">Deal Status</label>
                           <div class="col-sm-10">
                             <select name="deal_status" required="required" class="form-control m-b">
                                 	<option value="1">Active</option>
                                  <option value="0">Inactive</option>
                               </select>
                           </div>
                        </div>
                        <br>
                        <div class="form-group">
                           <label class="col-sm-2 control-label">Deal Description</label>
                           <div class="col-sm-10">
                               <textarea rows="6" class="form-control note-editor" name="deal_desc" required="required"></textarea>
                           </div>
                        </div>
                        <br>
                        <div class="form-group">
                           <div class="col-sm-4 col-sm-offset-2">
                                           <button type="submit" class="btn btn-primary" id="bottom-save">Save Deal</button>
                           </div>
                        </div>
                     </fieldset>

                  </form>
               </div>
            </div>

</div>

@endsection

@section('script')
<script>
$("input[name='hotel_name']").keyup(function(){
		$('input[name=hotel_code]').val('');
		var value = $(this).val();
		var html = '';
		$.ajax({
			type : "GET",
			url : "{{url('/admin/getall_hotels')}}",
			data : {
				name : value
			},
			dataType : 'json',
			cache : false,
			success : function(data){
				var c = 0;
				var co = 0;
				$.each(data, function(i, value){
					$('.search_result').css("display", "block");
					var count = c++;
					html += "<span class='hotel-lable-"+count+"' style='display:none;'>Hotel</span>"+
					"<option class='selected_value' name='hotel' id='"+value.hotelCode+"' value = '"+value.name+"'>" +value.name +"</option>";
				});
				$('.search_result').html(html);
			}
		});
	});
	$(document).on("click", ".selected_value", function(){
		var value = $(this).val();
		var id = $(this).attr("id");
		$("input[name='hotel_name").val(value);
		$('input[name=hotel_code]').val(id);
		$('.search_result').hide();
	});
	$('body').click(function(){
		$('.search_result').hide();
	});
</script>

<script>
    var element = document.getElementById("{{$activeID}}");
    element.classList.add("active");
</script>

@endsection
