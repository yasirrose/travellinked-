$(document).ready(function(){
	var currCalendar = '';
	var pathArray = location.href.split('/');
	var protocol = pathArray[0];
	var host = pathArray[2];
	var site_url = protocol + '//' + host + "/travellinked";
	/*=================== populate autocomplete hotels ===========*/
	$(".search_hotel").keyup(function(){
	
		$('input[name=hotel_code]').val('');
		var value = $(this).val();	
		var html = '';	
		$.ajax({
			type : "GET",
			url : site_url + "/search_hotels",
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
					if(value.hotelgroupname){
						html += "<span class='location-lable-"+i+"' style='display:none;'>Location</span>"+
						"<option class='selected_value' name='hotelgroupname' id='"+value.hotelgroupcode+"' value = '"+value.hotelgroupname+"'>" +value.hotelgroupname +"</option>";
					}
					if(value.city){	
						html += "<span class='city-lable-"+co+"' style='display:none;'>City</span>"+
						"<option class='selected_value' name='city' id ='"+value.cityCode+"' value = '"+value.city+"'>" +value.city +"</option>";
						co++;
					}
					if(value.name){
						var count = c++;
						html += "<span class='hotel-lable-"+count+"' style='display:none;'>Hotel</span>"+
						"<option class='selected_value' name='hotel' id='"+value.hotelCode+"' value = '"+value.name+"'>" +value.name +" (Hotel)</option>";	
					}
				});
				$('.search_result').html(html);
			}
		});
	});
	$(document).on("click", ".selected_value", function(){
		var value = $(this).val();
		var id = $(this).attr("id");
		$(".search_hotel").val(value);
		$('input[name=hotel_code]').val(id);
		$('.search_result').hide();
	});
	$('body').click(function(){
            $('.search_result').hide();
	});
        $('#create_booking_search').on('focus', function(){
            $('.datepicker-container').slideUp();
        });
	/*=================== end populate autocomplete hotels ===================*/
	function DateDiff(date1, date2) 
	{
		var datediff = (new Date(date2)) - (new Date(date1)).getTime();
		var p=datediff / (24 * 60 * 60 * 1000);	
		return (datediff / (24 * 60 * 60 * 1000));
	}
	/*=================== initialize datepickers =================*/
	$('.datepicker_in').dateRangePicker({
		separator : ' to ',
		format: 'MM/DD/YYYY',
		startDate: new Date(),
		maxDays:31,
		stickyMonths: true,
		inline:true,
		container:'.datepicker-container',
		alwaysOpen:true,
		beforeShowDay: function(t)
		{
			var startDate = $('#datepicker_in').val();
			if(startDate !== '')
			{
				var dat = new Date(t);
				if(DateDiff(startDate,dat) > 30)
				{
					if(currCalendar == 'datepicker_in')
					{
						var valid = true;
						var _class = 'valid';
						var _tooltip = '';
						return [valid,_class,_tooltip];	
					}
					else
					{
						var valid = false;
						var _class = 'invalid';
						var _tooltip = '';
						return [valid,_class,_tooltip];		
					}
				}
				else
				{
					if(DateDiff(startDate,dat) < 0 && currCalendar == 'datepicker_out')
					{
						var valid = false;
						var _class = 'invalid';
						var _tooltip = '';
						return [valid,_class,_tooltip];		
					}
					else
					{
						var valid = true;
						var _class = 'valid';
						var _tooltip = '';
						return [valid,_class,_tooltip];		
					}
				}
			}
			else
			{
				var valid = true;
				var _class = 'valid';
				var _tooltip = '';
				return [valid,_class,_tooltip];		
			}
		},
		hoveringTooltip: function(days)
		{
			if(days > 2)
			{
				return (days-1)+' Days';
			}
			else
			{
				return (days-1)+' Day';
			}
		},
		setValue:function(s,s1,s2){
			if(DateDiff(s1,s2) <= 0)
			{
				overWrite = ((new Date(s1)).getMonth() + 1) + '/' + ((new Date(s1)).getDate()+1) + '/' +  (new Date(s1)).getFullYear();
				$("#datepicker_in").val(s1);
				$("#datepicker_out").val(overWrite);
				document.getElementById("nights").value= DateDiff(s1,overWrite);
			}
			else
			{
				$("#datepicker_in").val(s1);
				$("#datepicker_out").val(s2);
				document.getElementById("nights").value= DateDiff(s1,s2);
			}
		}
	}).bind('datepicker-first-date-selected', function(event, obj)
	{
		var startDate = $('#datepicker_in').val();
		var endDate = $('#datepicker_out').val();
		if(startDate == '')
		{
			var month = obj.date1.getMonth()+1;
			var day = obj.date1.getDate();
			if(month < 10)
			{
				month = '0'+month;
			}
			if(day < 10)
			{
				day = '0'+day;
			}
			$(".datepicker_in").data('dateRangePicker').clear();
			var startDate = month+'/'+day+'/' + obj.date1.getFullYear();
			$("#datepicker_in").val(startDate);
			$("#datepicker_in").addClass('valid');
			$("#datepicker_in").removeClass('error');
			$('label[for=datepicker_in]').css('display','none');
			$("#datepicker_out").val('');
			$("#datepicker_out").removeClass('valid');
			$("#nights").val('');
			$("#nights").removeClass('valid');
			$(".datepicker_in").data('dateRangePicker').setStart(startDate);
			$("#datepicker_out").focus();
		}
		else if(startDate != '' && endDate != '')
		{
			var month = obj.date1.getMonth()+1;
			var day = obj.date1.getDate();
			if(month < 10)
			{
				month = '0'+month;
			}
			if(day < 10)
			{
				day = '0'+day;
			}
			var endDate = month+'/'+day+'/' + obj.date1.getFullYear();
			if(currCalendar == 'datepicker_in')
			{
				$(".datepicker_in").data('dateRangePicker').clear();
				$("#datepicker_in").val(endDate);
				$("#datepicker_in").addClass('valid');
				$("#datepicker_in").removeClass('error');
				$('label[for=datepicker_in]').css('display','none');
				$("#datepicker_out").val('');
				$("#datepicker_out").removeClass('valid');
				$("#nights").val('');
				$("#nights").removeClass('valid');
				$(".datepicker_in").data('dateRangePicker').setStart(endDate);
				$("#datepicker_out").focus();
			}
			else if(DateDiff(startDate,endDate) <= 0)
			{
				overWrite = new Date(startDate);
				overWrite.setDate(overWrite.getDate() + 1);
				overWrite = (overWrite.getMonth() + 1) + '/' + (overWrite.getDate()) + '/' +  overWrite.getFullYear();
				$(".datepicker_in").data('dateRangePicker').clear();
				$(".datepicker_in").data('dateRangePicker').setStart(startDate);
				$(".datepicker_in").data('dateRangePicker').setEnd(overWrite,true);
				$("#datepicker_in").addClass('valid');
				$("#datepicker_out").addClass('valid');
				$("#datepicker_in").removeClass('error');
				$('label[for=datepicker_in]').css('display','none');
				$("#datepicker_out").removeClass('error');
				$('label[for=datepicker_out]').css('display','none');
				$('#nights').addClass('valid');
				$('.datepicker-container').slideUp();
				currCalendar = '';
			}
			else
			{
				$(".datepicker_in").data('dateRangePicker').setStart(startDate);
				$(".datepicker_in").data('dateRangePicker').setEnd(endDate,true);
				$("#datepicker_in").addClass('valid');
				$("#datepicker_out").addClass('valid');
				$("#datepicker_in").removeClass('error');
				$('label[for=datepicker_in]').css('display','none');
				$("#datepicker_out").removeClass('error');
				$('label[for=datepicker_out]').css('display','none');
				$('#nights').addClass('valid');
				$('.datepicker-container').slideUp();
				currCalendar = '';
			}
		}
		
	}).bind('datepicker-change',function(event,obj)
	{
		var startDate = $('#datepicker_in').val();
		var month = obj.date2.getMonth()+1;
		var day = obj.date2.getDate();
		if(month < 10)
		{
			month = '0'+month;
		}
		if(day < 10)
		{
			day = '0'+day;
		}
		var endDate = month+'/'+day+'/' + obj.date2.getFullYear();
		if(startDate == '')
		{}
		else if(DateDiff(startDate,endDate) <= 0)
		{
			overWrite = new Date(startDate);
			overWrite = (overWrite.getMonth() + 1) + '/' + (overWrite.getDate()) + '/' +  overWrite.getFullYear();
			overWrite.setDate(overWrite.getDate() + 1);
			$(".datepicker_in").data('dateRangePicker').clear();
			$(".datepicker_in").data('dateRangePicker').setStart(startDate);
			$(".datepicker_in").data('dateRangePicker').setEnd(overWrite,true);
			$("#datepicker_in").addClass('valid');
			$("#datepicker_out").addClass('valid');
			$("#datepicker_in").removeClass('error');
			$('label[for=datepicker_in]').css('display','none');
			$("#datepicker_out").removeClass('error');
			$('label[for=datepicker_out]').css('display','none');
			$('#nights').addClass('valid');
			$('.datepicker-container').slideUp();
			$('.main_tooltip').css('display','none');
			currCalendar = '';
		}
		else
		{
			$(".datepicker_in").data('dateRangePicker').setStart(startDate);
			$(".datepicker_in").data('dateRangePicker').setEnd(endDate,true);
			$("#datepicker_in").addClass('valid');
			$("#datepicker_out").addClass('valid');
			$("#datepicker_in").removeClass('error');
			$('label[for=datepicker_in]').css('display','none');
			$("#datepicker_out").removeClass('error');
			$('label[for=datepicker_out]').css('display','none');
			$('#nights').addClass('valid');
			$('.datepicker-container').slideUp();
			$('.main_tooltip').css('display','none');
			currCalendar = '';
		}
	});
	
	$('#datepicker_in').on('focus',function(event){
		currCalendar = 'datepicker_in';
		$('span[class=next]').click();
		$('span[class=prev]').click();
		$('.main_tooltip').css('display','none');
		$(event.target).next().next().css('display','block');
		$('.datepicker-container').slideDown();
	});
	$('#datepicker_out').on('focus',function(event){
		currCalendar = 'datepicker_out';
		$('span[class=next]').click();
		$('span[class=prev]').click();
		$('.main_tooltip').css('display','none');
		$(event.target).next().next().css('display','block');
		$('.datepicker-container').slideDown();
	});
	/*=============== end initialize datepickers =================*/
	
	/*========= script for displaying horizontal search box =================*/
 	$(document).on('click',function(event){
		parent1 = "",parent2 = "",parent3 = "",parent4 = ""
		if($(event.target).parents().eq(0).length !== 0)
		{
			parent1 = $(event.target).parents().eq(0)[0].className;
		}
		if($(event.target).parents().eq(1).length !== 0)
		{
			parent2 = $(event.target).parents().eq(1)[0].className;
		}
		if($(event.target).parents().eq(2).length !== 0)
		{
			parent3 = $(event.target).parents().eq(2)[0].className;
		}
		if($(event.target).parents().eq(3).length !== 0)
		{
			parent4 = $(event.target).parents().eq(3)[0].className;
		}
		current = $(event.target)[0].className;
		if(current.search("horiz-search") !== -1)
		{
			$('#horiz-box').slideToggle();
		}
		else
		{
			if(parent1 !== 'engine-dropdown-row' && parent2 !== 'engine-dropdown-row' && parent3 !== 'engine-dropdown-row' && 
			   parent4 !== 'engine-dropdown-row' && current !== 'engine-dropdown-row' && current !== 'engine-dropdown-btns' && 
			   current !== 'btn-addrow' && current !== 'btn-cnfrm')
			{
			$('#horiz-box').hide();
			}
		}
    });
	
	$(document).on('change','#rooms_change',function(event){
		var horizVal = $(this).val();
		$('.engine-dropdown-row').css('display','none');
		$('.engine-dropdown-row:lt('+horizVal+')').css('display','block');
	});
	
	$(document).on('change','.horiz-child',function(event){
		var horizClass = $(this).attr('id');
		horizClass = horizClass+'_ages';
		var horizVal = $(this).val();
		if(horizVal > 0)
		{
			selElems = $('.'+horizClass).find("select");
			$('.'+horizClass).css('display','block');
			$('.'+horizClass).find("select").attr('disabled','disabled');
			for(var el = 0; el < selElems.length; el++)
			{
				if(el < horizVal)
				{
					$(selElems[el]).removeAttr('disabled');
				}
			}
		}
		else
		{
			$('.'+horizClass).css('display','none');
			$('.'+horizClass).find("select").attr('disabled','disabled');
		}
	});
 	/*========= End script for displaying horizontal search box ===========*/
        /*========= Start script for displaying room details ===========*/
        $("#create_booking_guests").on('focus',function(){
            $('.datepicker-container').slideUp();
        });
        $(document).on('click','#addStickyRoom',function(event){
            event.preventDefault();
            var roomValOld = parseInt($('#rooms_change').val());
            if(roomValOld < 5)
            {
                roomValNew = parseInt(roomValOld)+1;
                preValRooms1 = roomValNew;
                //$('.engine-dropdown-row:lt('+roomValNew+')').css('display','block');
                $('.engine-dropdown-row:lt('+roomValNew+')').slideDown(500);
                $('#rooms_change').val(roomValNew);
                var totalChild = calculate_children_main('#rooms_change','.horiz-child');
                var totalAdult = calculate_adults_main('#rooms_change','.adults-sticky');
                var result = $('#rooms_change').val()+' rooms, '+(totalAdult+totalChild)+' guests';
                $('#adultsChildSticky').val(result);
            }
        });
        /*========= End script for displaying room details ===========*/
	$(window).on("load",function(){
		$(".search-list-holder").mCustomScrollbar({
			axis:'y',
			mouseWheel:true
		});
	});
});