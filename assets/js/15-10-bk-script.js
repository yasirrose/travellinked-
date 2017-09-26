$(window).load(function() {



		$(".grid_data").css("display", "block");



		$(".list_data").css("display", "none");



});		





$(document).ready(function(e) {


	/*====== header script here =========*/



	var pathArray = location.href.split('/');



	var protocol = pathArray[0];



	var host = pathArray[2];



	var site_url = protocol + '//' + host + "/travellinked";



        $(".slide-toggle").click(function(){



            $(".box").slideToggle();



        });



	$("input.email-form").focus(function () {



		$(".email-icon").addClass("focus_color");



		$("input.email-form").focusout(function () {



			$(".email-icon").removeClass("focus_color");



		});



	   });



	

			$("input.password-form").focus(function () {



				$(".password-icon").addClass("focus_color");



				$("input.password-form").focusout(function () {



					$(".password-icon").removeClass("focus_color");



				});



			   });





			$("input.form_1").focus(function () {



				$(".icon_1").addClass("focus_color");



				$("input.form_1").focusout(function () {



					$(".icon_1").removeClass("focus_color");



				});



			   });



		



			$("input.form_2").focus(function () {



				$(".icon_2").addClass("focus_color");



				$("input.form_2").focusout(function () {



					$(".icon_2").removeClass("focus_color");



				});



			   });



		



			$("input.form_3").focus(function () {



				$(".icon_3").addClass("focus_color");



				$("input.form_3").focusout(function () {



					$(".icon_3").removeClass("focus_color");



				});



			   });



		



			$("input.form_4").focus(function () {



				$(".icon_4").addClass("focus_color");



				$("input.form_4").focusout(function () {



					$(".icon_4").removeClass("focus_color");



				});



			   });



		



			$("input.form_5").focus(function () {



				$(".icon_5").addClass("focus_color");



				$("input.form_5").focusout(function () {



					$(".icon_5").removeClass("focus_color");



				});



			   });



		



			$("select.form_6").focus(function () {



				$(".icon_6").addClass("focus_color");



				$("select.form_6").focusout(function () {



					$(".icon_6").removeClass("focus_color");



				});



			   });



		



			$("select.form_7").focus(function () {



				$(".icon_7").addClass("focus_color");



				$("select.form_7").focusout(function () {



					$(".icon_7").removeClass("focus_color");



				});



			   });



		



			$("select.form_8").focus(function () {



				$(".icon_8").addClass("focus_color");



				$("select.form_8").focusout(function () {



					$(".icon_8").removeClass("focus_color");



				});



			   });



		



			$("select.form_9").focus(function () {



				$(".icon_9").addClass("focus_color");



				$("select.form_9").focusout(function () {



					$(".icon_9").removeClass("focus_color");



				});



			   });



		



			$("select.form_10").focus(function () {



				$(".icon_10").addClass("focus_color");



				$("select.form_10").focusout(function () {



					$(".icon_10").removeClass("focus_color");



				});



			   });





			$("select.form_11").focus(function () {



				$(".icon_11").addClass("focus_color");



				$("select.form_11").focusout(function () {



					$(".icon_11").removeClass("focus_color");



				});



			   });




			$("select.form_12").focus(function () {



				$(".icon_12").addClass("focus_color");



				$("select.form_12").focusout(function () {



					$(".icon_12").removeClass("focus_color");



				});



			   });





			$("input.form_13").focus(function () {



				$(".icon_13").addClass("focus_color");



				$("input.form_13").focusout(function () {



					$(".icon_13").removeClass("focus_color");



				});



			   });



			$("input.form_14").focus(function () {



				$(".icon_14").addClass("focus_color");



				$("input.form_14").focusout(function () {



					$(".icon_14").removeClass("focus_color");



				});



			   });



				$('#add_rooms option[value=" "]').attr("selected", "selected");



				$('#row_1').hide();



				$('#row_2').hide();



				$('#row_3').hide();



				$("#childage1_1").hide();



				$("#childage2_1").hide();



				$("#childage1_2").hide();



				$("#childage2_2").hide();



				$("#childage1_3").hide();



				$("#childage2_3").hide();



				



				$('#adult_row_1').show();



				$('#room1_adults').show();




				$('#room1_child').show();




			$('.dropdown-toggle').mouseover(function() {



				$('.dropdown-menu').show();



			})





				$("#nights").change(function(){
				
						checkin=$('#datepicker_in').val();

						nights = $(this).val();    

						checkout=$('#datepicker_out').val();    
						
						var tomorrow = new Date(); 

						tomorrow.setDate(tomorrow.getDate()+nights);

				});


	function change_fromdate()



	{



		var x = document.getElementById("datepicker_in").value; 



		document.getElementById("datepicker_in").innerHTML = x;



		



	}



	



	function change_todate()



	{



		var x = document.getElementById("datepicker_out").value;



		document.getElementById("datepicker_out").innerHTML = x;



		



		var checkin=document.getElementById("datepicker_in").value;



		nights();



	



	}



function zeroPad(num, count)



{



        var numZeropad = num + '';



        while (numZeropad.length < count) {



                numZeropad = "0" + numZeropad;



        }



        return numZeropad;



}



 function DateDiff(date1, date2) 



 {



    var datediff = date2.getTime() - date1.getTime();



    var p=datediff / (24 * 60 * 60 * 1000);	



    return (datediff / (24 * 60 * 60 * 1000));    



}



function dateADD(currentDate)



{



        var valueofcurrentDate = currentDate.valueOf() + (24 * 60 * 60 * 1000);



        var newDate = new Date(valueofcurrentDate);



        return newDate;



}



function daysADD(currentDate)



{



	    var days=$('#nights').val();



        var valueofcurrentDate = currentDate.valueOf() + (30 *24 * 60 * 60 * 1000);



        var newDate = new Date(valueofcurrentDate);



        return newDate;



}





$( "#datepicker_in" ).datepicker({



    numberOfMonths: 2,



    dateFormat: 'dd/mm/yy',



    minDate: 0,



                firstDay: 0,



                inline: true,



});



 $( "#datepicker_out" ).datepicker({ 



    numberOfMonths: 2,



    dateFormat: 'dd/mm/yy',



    minDate: 0,



                firstDay: 0,



				maxDate: 30,



                inline: true



				



});        



    



	$("#datepicker_in").change(function(){ 



                        var selectedDate1= $("#datepicker_in").datepicker('getDate');   



                        var nextdayDate  = dateADD(selectedDate1);



                        var nextDateStr = zeroPad(nextdayDate.getDate(),2)+"/"+zeroPad((nextdayDate.getMonth()+1),2)+"/"+(nextdayDate.getFullYear());



                        $t = nextDateStr;



						var maxDate  = daysADD(selectedDate1);



						var maxDatevalue = zeroPad(maxDate.getDate(),2)+"/"+zeroPad((maxDate.getMonth()+1),2)+"/"+(maxDate.getFullYear());



					//	alert("NOO");



					//	alert(maxDatevalue);



						$m = maxDatevalue;



						$('#out_date').html('<input type="text" name="checkout" class="form-control date-pick" id="datepicker_out" value="'+$t+'" style="width:100%;" readonly onchange="change_date();" /> ');+ 



                        $(function() {



						$("#datepicker_out").datepicker({



								numberOfMonths: 2,



								firstDay: 0,



								dateFormat: 'dd/mm/yy',



								minDate: $t,



								maxDate: $m,



								inline: true,



						});







			 });



										



				var k=DateDiff(selectedDate1,nextdayDate);			



				$kk = k;



			



				document.getElementById("nights").value=$kk;			



						



                });



				



				function change_date()



				{



					var selectedDate1= $("#datepicker_in").datepicker('getDate');



					var selectedDate2= $("#datepicker_out").datepicker('getDate');



				



					var k=DateDiff(selectedDate1,selectedDate2);			



					$kk = k;



					



					document.getElementById("nights").value=$kk;	



				}



			
				function nights()



				{



					var selectedDate1= $("#datepicker_in").datepicker('getDate');



					var selectedDate2= $("#datepicker_out").datepicker('getDate');



				



					var k=DateDiff(selectedDate1,selectedDate2);			



					$kk = k;



					



					document.getElementById("nights").value=$kk;	



				}						  



  



  







	



	$('#add_rooms').change(function(){



       $("div").removeClass("hide");



	   var num = $('#add_rooms').val();



	   var abc = $('#hidden').val();



	



	   if(num==1)



	   {



				$('#row_1').show();



				$('#row_2').hide();



				$('#row_3').hide();



				var room1=$('#room1_adults').val();  



				var total=$('#room1_adults').val(); 



				$('#total_adults').val(room1);



	   }



	   else if(num==2)



	   {



				$('#row_1').show();



				$('#row_2').show();



				$('#row_3').hide();



				var room1=$('#room1_adults').val(); 



				var room2=$('#room2_adults').val(); 



				var total=parseInt(room1)+parseInt(room2);



				$('#total_adults').val(total);



	   }



	   else if(num==3)



	   {



				$('#row_1').show();



		        $('#row_2').show();



				$('#row_3').show();



				var room1=$('#room1_adults').val(); 



				var room2=$('#room2_adults').val(); 



				var room3=$('#room3_adults').val(); 



				var total=parseInt(room1)+parseInt(room2)+parseInt(room3);



				$('#total_adults').val(total);



	   }



	   



	



	 });



	



	function child_count()



	{



		var add_rooms=$('#add_rooms').val();



		if(add_rooms==1)



		{



			var child1=$("#room1_child").val();



			var total_ch=parseInt(child1);



			$('#total_child').val(total_ch);



		}



		else if(add_rooms==2)



		{



			var child1=$("#room1_child").val();



			var child2=$("#room2_child").val();



			var total_ch=parseInt(child1)+parseInt(child2);



			$('#total_child').val(total_ch);



		}



		else if(add_rooms==3)



		{



			var child1=$("#room1_child").val();



			var child2=$("#room2_child").val();



			var child3=$("#room3_child").val();



			var total_ch=parseInt(child1)+parseInt(child2)+parseInt(child3);



			$('#total_child').val(total_ch);



		}



	}



	



	$('#room1_adults').change(function(){



		var total = $('#total_adults').val();



		var rooms = $('#add_rooms').val();



		if(rooms=="1")



		{



			var room1_adults = $('#room1_adults').val();



			var total=parseInt(room1_adults);



		}



		else if(rooms=="2")



		{



			var room1_adults = $('#room1_adults').val();



			var room2_adults = $('#room2_adults').val();



			var total=parseInt(room1_adults)+parseInt(room2_adults);



		}



		else if(rooms=="3")



		{



			var room1_adults = $('#room1_adults').val();



			var room2_adults = $('#room2_adults').val();



			var room3_adults = $('#room3_adults').val();



			var total=parseInt(room1_adults)+parseInt(room2_adults)+parseInt(room3_adults);



		}



		$("#total_adults").val(total);



		



	});



	



	$('#room2_adults').change(function(){



		var total = $('#total_adults').val();



		var rooms = $('#add_rooms').val();



		if(rooms=="1")



		{



			var room1_adults = $('#room1_adults').val();



			var total=parseInt(room1_adults);



		}



		else if(rooms=="2")



		{



			var room1_adults = $('#room1_adults').val();



			var room2_adults = $('#room2_adults').val();



			var total=parseInt(room1_adults)+parseInt(room2_adults);



		}



		else if(rooms=="3")



		{



			var room1_adults = $('#room1_adults').val();



			var room2_adults = $('#room2_adults').val();



			var room3_adults = $('#room3_adults').val();



			var total=parseInt(room1_adults)+parseInt(room2_adults)+parseInt(room3_adults);



		}



		$("#total_adults").val(total);



		



	});



	



	$('#room3_adults').change(function(){



		var total = $('#total_adults').val();



		var rooms = $('#add_rooms').val();



		if(rooms=="1")



		{



			var room1_adults = $('#room1_adults').val();



			var total=parseInt(room1_adults);



		}



		else if(rooms=="2")



		{



			var room1_adults = $('#room1_adults').val();



			var room2_adults = $('#room2_adults').val();



			var total=parseInt(room1_adults)+parseInt(room2_adults);



		}



		else if(rooms=="3")



		{



			var room1_adults = $('#room1_adults').val();



			var room2_adults = $('#room2_adults').val();



			var room3_adults = $('#room3_adults').val();



			var total=parseInt(room1_adults)+parseInt(room2_adults)+parseInt(room3_adults);



		}



		$("#total_adults").val(total);



		



	});



	



$('#room1_child').change(function(){



		child_count();



		var child1=$("#room1_child").val();



		if(child1==0)



		{



			$("#childage1_1").hide();



			$("#childage2_1").hide();



		}



		else if(child1==1)



		{



			$("#childage1_1").show();



			$("#childage2_1").hide();



		}



		else if(child1==2)



		{



			$("#childage1_1").show();



			$("#childage2_1").show();



		}



		



		



		var rooms = $('#add_rooms').val();



		if(rooms=="1")



		{



			var room1_child = $('#room1_child').val();



			var total=parseInt(room1_child);



		}



		else if(rooms=="2")



		{



			var room1_child = $('#room1_child').val();



			var room2_child = $('#room2_child').val();



			var total=parseInt(room1_child)+parseInt(room2_child);



		}



		else if(rooms=="3")



		{



			var room1_child = $('#room1_child').val();



			var room2_child = $('#room2_child').val();



			var room3_child = $('#room3_child').val();



			var total=parseInt(room1_child)+parseInt(room2_child)+parseInt(room3_child);



		}



		$("#total_child").val(total);



		



	});



	



	$('#room2_child').change(function(){



		child_count();



		var child2=$("#room2_child").val();



		if(child2==0)



		{



			$("#childage1_2").hide();



			$("#childage2_2").hide();



		}



		else if(child2==1)



		{



			$("#childage1_2").show();



			$("#childage2_2").hide();



		}



		else if(child2==2)



		{



			$("#childage1_2").show();



			$("#childage2_2").show();



		}



		



	});



	



	$('#room3_child').change(function(){



		



	    child_count();



		var child3=$("#room3_child").val();



		if(child3==0)



		{



			$("#childage1_3").hide();



			$("#childage2_3").hide();



		}



		else if(child3==1)



		{



			$("#childage1_3").show();



			$("#childage2_3").hide();



		}



		else if(child3==2)



		{



			$("#childage1_3").show();



			$("#childage2_3").show();



		}



		



	});



	



		$('.top_deal_offerbox:first').addClass('current');



		$('.result_row:first').addClass('current');







			$("#list_view").click(function() {



				$(".list_data").css("display", "block");



				$(".grid_data").css("display", "none");



				$('.bar i').addClass('icon_ative');



				$('.bar_grid i').removeClass('icon_ative');



			});



			$("#grid_view").click(function() {



				$(".list_data").css("display", "none");



				$(".grid_data").css("display", "block");



				$('.bar i').removeClass('icon_ative');



				$('.bar_grid i').addClass('icon_ative');



			});



		



		$('ul.tabs li').click(function () {



			var tab_id = $(this).attr('data-tab');



			$('ul.tabs li').removeClass('current');



			$('.tab-content').removeClass('current');



			$(this).addClass('current');



			$('.' + tab_id).addClass('current');



		});



	

			size_li = $(".result_row").size();



			x=3;



			$('.result_row:lt('+x+')').show();



			$('#loadMore').click(function () {



				x= (x+5 <= size_li) ? x+5 : size_li;



				$('.result_row li:lt('+x+')').show();



				 $('#showLess').show();



				if(x == size_li){



					$('#loadMore').hide();



				}



			});



			$('#showLess').click(function () {



				x=(x-5<0) ? 3 : x-5;



				$('.result_row').not(':lt('+x+')').hide();



				$('#loadMore').show();



				 $('#showLess').show();



				if(x == 3){



					$('#showLess').hide();



				}



			});



	  

$(document).on("change","#total_child1", function(){

	

	var value = $(this).val();

	

	if(value == 1){

	$("#age1_1").css("display","block");

	$("#age1_2").css("display","none");

	

	}

	if(value == 2){	

	$("#age1_1").css("display","block");

	$("#age1_2").css("display","block");

	

	}

	if(value == 0){

		

	$("#age1_1").css("display","none");

	$("#age1_2").css("display","none");



		}

});



$(document).on("change","#total_child2", function(){

	

	var value = $(this).val();

	

	if(value == 1){

	$("#age2_1").css("display","block");	

	$("#age2_2").css("display","none");

	

	}

	if(value == 2){	

	$("#age2_1").css("display","block");

	$("#age2_2").css("display","block");

	

	}

	if(value == 0){

		

	$("#age2_1").css("display","none");

	$("#age2_2").css("display","none");



		}

});



$(document).on("change","#total_child3", function(){

	

	var value = $(this).val();

	

	if(value == 1){

	$("#age3_1").css("display","block");

	$("#age3_2").css("display","none");

	

	}

	if(value == 2){	

	$("#age3_1").css("display","block");

	$("#age3_2").css("display","block");

	

	}

	if(value == 0){

		

	$("#age3_1").css("display","none");

	$("#age3_2").css("display","none");



		}

});



$("#adult-1").change(function() {

var val1 = $("#adult-1").val();

var val2 = $("#adult-2").val();

var val3 = $("#adult-3").val();

var val4 = $("#adult-4").val();
var val5 = $("#adult-5").val();

var total = parseInt(val1)+parseInt(val2)+parseInt(val3)+parseInt(val4)+parseInt(val5);



$("#total-adults").val(" ");

$("#total-adults").val(total);

});



$("#adult-2").change(function() {

var val1 = $("#adult-1").val();

var val2 = $("#adult-2").val();

var val3 = $("#adult-3").val();
var val4 = $("#adult-4").val();
var val5 = $("#adult-5").val();

var total = parseInt(val1) + parseInt(val2)+parseInt(val3)+parseInt(val4)+parseInt(val5);



$("#total-adults").val(" ");

$("#total-adults").val(total);

});




$("#adult-3").change(function() {

var val1 = $("#adult-1").val();

var val2 = $("#adult-2").val();

var val3 = $("#adult-3").val();
var val4 = $("#adult-4").val();
var val5 = $("#adult-5").val();

var total = parseInt(val1) + parseInt(val2)+parseInt(val3)+parseInt(val4)+parseInt(val5);



$("#total-adults").val(" ");

$("#total-adults").val(total);

});

$("#adult-4").change(function() {

var val1 = $("#adult-1").val();

var val2 = $("#adult-2").val();

var val3 = $("#adult-3").val();
var val4 = $("#adult-4").val();
var val5 = $("#adult-5").val();

var total = parseInt(val1) + parseInt(val2)+parseInt(val3)+parseInt(val4)+parseInt(val5);



$("#total-adults").val(" ");

$("#total-adults").val(total);

});


$("#adult-5").change(function() {

var val1 = $("#adult-1").val();

var val2 = $("#adult-2").val();

var val3 = $("#adult-3").val();
var val4 = $("#adult-4").val();
var val5 = $("#adult-5").val();

var total = parseInt(val1) + parseInt(val2)+parseInt(val3)+parseInt(val4)+parseInt(val5);



$("#total-adults").val(" ");

$("#total-adults").val(total);

});




$("#total_child1").change(function() {



var val1 = $("#total_child1").val();

var val2 = $("#total_child2").val();

var val3 = $("#total_child3").val();



var total = parseInt(val1) + parseInt(val2)+parseInt(val3);



$("#total-childs").val(" ");

$("#total-childs").val(total);

});



$("#total_child2").change(function() {



var val1 = $("#total_child2").val();

var val2 = $("#total_child1").val();

var val3 = $("#total_child3").val();



var total = parseInt(val1) + parseInt(val2)+parseInt(val3);

$("#total-childs").val(" ");

$("#total-childs").val(total);

});



$("#total_child3").change(function() {



var val1 = $("#total_child3").val();

var val2 = $("#total_child2").val();

var val3 = $("#total_child1").val();



var total = parseInt(val1) + parseInt(val2)+parseInt(val3);

$("#total-childs").val(" ");

$("#total-childs").val(total);

});





$("#add_rooms").change(function() {

	

	var val = $(this).val();

	

	if(val == 1){

		$("#total_child1").val( 0 );

		$("#total_child2").val( 0 );

		$("#total_child3").val( 0 );

		$("#age1_1").css("display","none");

		$("#age1_2").css("display","none");

		$("#age2_1").css("display","none");

		$("#age2_2").css("display","none");

		$("#age3_1").css("display","none");

		$("#age3_2").css("display","none");

	}

	if(val == 2){

	

		$("#total_child3").val( 0 );

		$("#age3_1").css("display","none");

		$("#age3_2").css("display","none");

		

		

	}

	

	});







$("#add_rooms").change(function(){

	

var val = $(this).val();



	if(val == 2){

	

	$("#room_2").show();

	$("#room_3").css("display","none");

	}

	if(val == 3){

	$("#room_2").show();

	$("#room_3").show();

	}

	if(val == 1){

	$("#room_2").css("display","none");	

	$("#room_3").css("display","none");	

	}



});

	  





$("#search").click(function(e){

	

	e.preventDefault();

	var adlt =$("#total_adults").val();



	var rooms = $("#add_rooms").val();

	var child = $("#total_child").val();

	if(rooms == 1 && adlt == 4 && child ==1 ){

	$("#error").html('<span style="color:red; margin-top:10px;">For one room you can select total 4 adults and children</span>');

	

		

	}



	else{

		$("#error").html(" ");

		$("#hotel_search").submit();

		

		}



	

});







$("#add_rooms").change(function(){



	var val = $(this).val();

	var html = "";

	

	if(val == 1){

	

	var count = 4;

	

	for(var i =0; i<= count; i++){

		

		html += '<option value="'+i+'">'+i+' '+'Adult</option>';

		

		}

		$("#total_adults").html(html);

	}

	if(val == 2){

	var count = 4;

	for(var i =0; i<= count; i++){

		

		html += '<option value="'+i+'">'+i+' '+'Adult</option>';

		

		}

		$("#total_adults").html(html);



    }

	if(val == 3){

	var count = 4;

	for(var i =0; i<= count; i++){

		

		html += '<option value="'+i+'">'+i+' '+'Adult</option>';

		

		}

		$("#total_adults").html(html);



    }



});



  $(".search-form").validate({

    rules: {

      location_name: "required",

	  checkin: "required",

	  checkout: "required",

	  nights: "required"

      

    },

    messages: {

      location_name: "Please enter your destination",

	  checkin: "Required",

	  checkout: "Required",

	  nights: "Required"

      },

    submitHandler: function(form) {
	$(".search-loader").show();
     
	  form.submit(); 

    }

   });


$(window).bind("pageshow", function() {
	$(".search-loader").css("display","none");
	var page = window.location.pathname;
	if(page == "/travellinked/"){
  $(".search-form")[0].reset();
}
});

	  $("#rooms_count").change(function(){
		
	   var count = $(this).val();
 	if(count == 1){
	 
		
		$(".cloned").css("display","none");
		
		
	   } 
	 if(count == 2){
	 
		$(".cloned").attr("id","count"); 
		$(".cloned").css("display","none"); 
		$("#count").css("display","block"); 
	   }  
	   else{
		 
		
	   var html = "";
	   for(var i=2; i<= count- 1; i++){
	  $(".cloned:first-child").css("display","block"); 
	  var c = parseInt(i) + parseInt(1);
	   
        html += '<div class="search-engine-row cloned" id="count-'+i+'">'+
                        	'<div class="rm-num-row">'+
                            	'<div class="room-label">'+
                                	'<label>Room '+c+'</label>'+
                                '</div>'+
                                '<div class="w-158">'+
                                    '<label>Adults</label>'+
                                    '<div class="icon-control">'+
                                        '<select class="control-field" id="adult-'+c+'" name="adults_'+c+'">'+
                                           ' <option value="0">0 Adults</option>'+
										   ' <option value="1">1 Adults</option>'+
										   ' <option value="2">2 Adults</option>'+
										   ' <option value="3">3 Adults</option>'+
										   ' <option value="4">4 Adults</option>'+
										   ' <option value="5">5 Adults</option>'+
                                        '</select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                   ' </div>'+
                               ' </div>'+
                                '<div class="w-158">'+
                                   ' <label>Children</label>'+
                                    '<div class="icon-control">'+
                                        '<select class="control-field select-child-'+c+'" name="children_'+c+'" id="total_child'+c+'">'+
                                            '<option value="0">0</option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                        '</select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                           ' <div class="chldr-age-row Children-'+c+'" style="display:none;">'+
                            	'<label>Children’s Ages (0 - 17)</label>'+
                               ' <div class="age-select-boxes">'+
                                   ' <div class="icon-control">'+
                                       ' <select class="control-field age-1" disabled="disabled" name="children_'+c+'_age_1">'+
                                           '<option value="0">0</option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                       ' </select>'+
                                       ' <span class="ion ion-arrow-down-b"></span>'+
                                    '</div>'+
                                    '<div class="icon-control">'+
                                        '<select class="control-field age-2" disabled="disabled" name="children_'+c+'_age_2">'+
                                           '<option value="0">0</option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                        '</select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                    '</div>'+
                                    '<div class="icon-control">'+
                                        '<select class="control-field age-3" disabled="disabled" name="children_'+c+'_age_3">'+
                                           '<option value="0">0</option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                        '</select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                   ' </div>'+
                                    '<div class="icon-control">'+
                                        '<select class="control-field age-4" disabled="disabled" name="children_'+c+'_age_4">'+
                                           '<option value="0">0</option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                       ' </select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                   ' </div>'+
                                    '<div class="icon-control">'+
                                       ' <select class="control-field age-5" disabled="disabled" name="children_'+c+'_age_5">'+
                                          '<option value="0">0</option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                       ' </select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                    '</div>'+
                                    '<div class="icon-control">'+
                                       ' <select class="control-field age-6" disabled="disabled" name="children_'+c+'_age_6">'+
                                           '<option value="0">0</option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                        '</select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                   ' </div>'+
                                    '<div class="icon-control">'+
                                       ' <select class="control-field age-7" disabled="disabled" name="children_'+c+'_age_7">'+
                                           '<option value="0">0 </option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                        '</select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                   '</div>'+
                                    '<div class="icon-control">'+
                                       '<select class="control-field age-8" disabled="disabled" name="children_'+c+'_age_8">'+
									   		'<option value="0">0 </option>'+
											'<option value="1">1 Child</option>'+
											'<option value="2">2 Children</option>'+
											'<option value="3">3 Children</option>'+
											'<option value="4">4 Children</option>'+
											'<option value="5">5 Children</option>'+
											'<option value="6">6 Children</option>'+
											'<option value="7">7 Children</option>'+
											'<option value="8">8 Children</option>'+
											
                                        '</select>'+
                                        '<span class="ion ion-arrow-down-b"></span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="clear"></div>'+
                            '</div>'+
                           ' <div class="clear"></div>'+
                       ' </div>';
    }
	
	$(".append-html").html(html);
	
  }
 });


$(document).on("change",".select-child-1",function(){
	
	var val = $(this).val();
	
	if(val >= 1){
		
		$(".Children-1").css("display","block");
		$(".Children-1 div select").attr("disabled", "true");
		for(var i = 1; i<= val; i++){
			
		$(".Children-1 div .age-"+i).removeAttr("disabled");
			
			
	 }
	  }
		if(val == 0){
			$(".Children-1").css("display","none");
		$(".Children-1 div .control-field").attr("disabled", "true");
			
		}

});

$(document).on("change",".select-child-2",function(){
	
	var val = $(this).val();
	
	if(val >= 1){
		
		$(".Children-2").css("display","block");
		$(".Children-2 div .control-field").attr("disabled", "true");
		for(var i = 1; i<= val; i++){
			
		$(".Children-2 div .age-"+i).removeAttr("disabled");
			
			
	 }
	  }
		if(val == 0){
			$(".Children-2").css("display","none");
		$(".Children-2 div select").attr("disabled", "true");
			
		}

});


$(document).on("change",".select-child-3",function(){
	
	var val = $(this).val();
	
	if(val >= 1){
		
		$(".Children-3").css("display","block");
		$(".Children-3 div select").attr("disabled", "true");
		for(var i = 1; i<= val; i++){
			
		$(".Children-3 div .age-"+i).removeAttr("disabled");
			
			
	 }
	  }
		if(val == 0){
			$(".Children-3").css("display","none");
		$(".Children-3 div .control-field").attr("disabled", "true");
			
		}

});

$(document).on("change",".select-child-4",function(){
	
	var val = $(this).val();
	
	if(val >= 1){
		
		$(".Children-4").css("display","block");
		$(".Children-4 div select").attr("disabled", "true");
		for(var i = 1; i<= val; i++){
			
		$(".Children-4 div .age-"+i).removeAttr("disabled");
			
			
	 }
	  }
		if(val == 0){
			$(".Children-4").css("display","none");
		$(".Children-4 div .control-field").attr("disabled", "true");
			
		}

});

$(document).on("change",".select-child-5",function(){
	
	var val = $(this).val();
	
	if(val >= 1){
		
		$(".Children-5").css("display","block");
		$(".Children-5 div select").attr("disabled", "true");
		for(var i = 1; i<= val; i++){
			
		$(".Children-5 div .age-"+i).removeAttr("disabled");
			
			
	 }
	  }
		if(val == 0){
			$(".Children-5").css("display","none");
		$(".Children-5 div .control-field").attr("disabled", "true");
			
		}

});


$(".search_hotel").keyup(function(){

	var value = $(this).val();	

	var html = "";	

	$.ajax({
			type : "GET",

			url : site_url + "/search_hotels",

			data : {

				name : value

			},

			dataType : 'json',

			cache : false,
			success : function(data) {

				console.log(data);	
				var c = 0;
				$.each(data, function(i, value) {
	

						$('.search_result').css("display", "block");

					if(value.city){	

						html += "<span class='city-lable-"+i+"' style='display:none;'>City</span>"+
						"<option class='selected_value' id ='"+value.cityCode+"' value = '"+value.city+"'>" +value.city +"</option>";

					}if(value.name){
						
					var count = c++;
					html += "<span class='hotel-lable-"+count+"' style='display:none;'>Hotel</span>"+
					"<option class='selected_value' id='"+value.hotelCode+"' value = '"+value.name+"'>" +value.name +" (Hotel)</option>";	

					
					}
					
					});


					$('.search_result').html(html);

		

			}

		  });

 });
 
 
  $(document).on("click", ".selected_value", function() {
	var value = $(this).val();
	var id = $(this).attr("id");
		$(".search_hotel").val(value);

		$("#input_hotel").val(id);

		$('.search_result').hide();

	}); 
	
	
$(window).click(function () { 
  $('.search_result').hide();
  
});


$("#datepicker_out").change(function(){

					var selectedDate1= $("#datepicker_in").datepicker('getDate');

					var selectedDate2= $("#datepicker_out").datepicker('getDate');

					var k=DateDiff(selectedDate1,selectedDate2);			

					$kk = k;

					document.getElementById("nights").value=$kk;	

				});						  


	$("#nights").change(function(){

		var nights = $(this).val();
			
		var today = new Date();
			
		var Newdate = today.getDate() + '/' + (today.getMonth() + 1) + '/' +  today.getFullYear();

		$("#datepicker_in").val(Newdate);
		
		var numberOfDaysToAdd = parseInt(nights);
		today.setDate(today.getDate() + numberOfDaysToAdd); 
		
		var dd = today.getDate();
		var mm = today.getMonth() + 1;
		var y = today.getFullYear();
		
		var checkoutdate = dd + '/'+ mm + '/'+ y;
		
		document.getElementById("datepicker_out").value = checkoutdate;	
		});
		
	

	//$(document).on("click",".price",function(){
		$(".price").click(function(){
			var check = $(".check-price").text();
			
	if(check == ""){
	$(".overlay").show();
	$.ajax({
			type : "GET",

			url : site_url + "/sort_by",

			dataType : 'json',

			cache : false,
			success : function(data) {
		$(".overlay").hide();

			
			$(".sort_price").html(data);
			

			}

		  });
	}
 });
 
 
 $(".stars").click(function(){
			var check = $(".check-star").text();
			
	if(check == ""){
	$(".overlay").show();
	$.ajax({
			type : "GET",

			url : site_url + "/sortByStars",

			dataType : 'json',

			cache : false,
			success : function(data) {
		$(".overlay").hide();

			
			$(".sort_star").html(data);
			

			}

		  });
	}
 });	
		
	
	
	 $(".hotels").click(function(){
	 var check = $(".check-hotels").text();
			
	if(check == ""){
	$(".overlay").show();
	$.ajax({
			type : "GET",

			url : site_url + "/sortByHotels",

			dataType : 'json',

			cache : false,
			success : function(data) {
		$(".overlay").hide();
	
			$(".sort_hotels").html(data);
			

			}

		  });
	}
 });		
			


}); /*===== Close ready function =======*/