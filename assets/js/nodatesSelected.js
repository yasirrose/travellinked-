$(window).load(function(){

	$(".search-loader").hide();

});

$(document).ready(function(e){

	var pathArray = location.href.split('/');

	var protocol = pathArray[0];

	var host = pathArray[2];

	var preValRooms1 = 0;

	var preValRooms2 = 0;

	var currCalendar = '';

	var site_url = protocol + '//' + host + "/travellinked";

	var pageUrl = location.href;

	var defaultMin = $('#defaultMin').attr('class');

	/*================ functions for date calculations and others =================*/

	function zeroPad(num, count)

	{

		var numZeropad = num + '';

		while (numZeropad.length < count) {

			numZeropad = "0" + numZeropad;

		}

		return numZeropad;

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

	function DateDiff(date1,date2) 

	{

		var datediff = (new Date(date2)).getTime() - new Date(date1).getTime();

		var p = datediff / (24 * 60 * 60 * 1000);	

		return (datediff / (24 * 60 * 60 * 1000));

	}

	/*================ end functions for date calculations and others ==============*/

	currentDateRooms = '';

	$('.check_in').dateRangePicker({

		separator : ' to ',

		format: 'MM/DD/YYYY',

		startDate: new Date(),

		maxDays:31,

		stickyMonths: true,

		inline:true,

		container:'.checkin-container',

		alwaysOpen:true,

		beforeShowDay: function(t)

		{

			var startDate = $('#check_in').val();

			if(startDate !== '')

			{

				var dat = new Date(t);

				if(DateDiff(startDate,dat) > 30)

				{

					if(currCalendar == '#check_in')

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

					if(DateDiff(startDate,dat) < 0 && currCalendar == '#check_out')

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

				$("#check_in").val(s1);

				$("#check_out").val(overWrite);

				$("#datepicker_in_sticky").val(s1);

				$("#datepicker_out_sticky").val(overWrite);

				document.getElementById("nightsRoomPage").value= DateDiff(s1,overWrite);

				document.getElementById("nightsSticky").value= DateDiff(s1,overWrite);

			}

			else

			{

				$("#check_in").val(s1);

				$("#check_out").val(s2);

				$("#datepicker_in_sticky").val(s1);

				$("#datepicker_out_sticky").val(s2);

				document.getElementById("nightsRoomPage").value= DateDiff(s1,s2);

				document.getElementById("nightsSticky").value= DateDiff(s1,s2);

			}

		}

	}).bind('datepicker-first-date-selected', function(event, obj)

	{

		var startDate = $('#check_in').val();

		var endDate = $('#check_in').val();

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

			var startDate = month+'/'+day+'/' + obj.date1.getFullYear();

			$("#check_in").val(startDate);

			$("#datepicker_in_sticky").val(startDate);

			$("#datepicker_in_sticky").addClass('valid');

			$("#check_in").addClass('valid');

			$("#check_in").removeClass('error');

			$('label[for=check_in]').css('display','none');

			$("#check_out").val('');

			$("#check_out").removeClass('valid');

			$("#nightsRoomPage").val('');

			$(".check_in").data('dateRangePicker').setStart(startDate);

			$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

			$("#check_out").focus();

		}

		else if(startDate != '')

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

			if(currCalendar == '#check_in')

			{

				$(".check_in").data('dateRangePicker').clear();

				$(".datepicker_in_sticky").data('dateRangePicker').clear();

				$("#check_in").val(endDate);

				$("#check_in").addClass('valid');

				$("#datepicker_in_sticky").val(startDate);

				$("#datepicker_in_sticky").addClass('valid');

				$("#check_in").removeClass('error');

				$('label[for=check_in]').css('display','none');

				$("#check_out").val('');

				$("#check_out").removeClass('valid');

				$("#nightsRoomPage").val('');

				$(".check_in").data('dateRangePicker').setStart(endDate);

				$(".datepicker_in_sticky").data('dateRangePicker').setStart(endDate);

				$("#check_out").focus();

			}

			else if(DateDiff(startDate,endDate) <= 0)

			{

				overWrite = new Date(startDate);

				overWrite.setDate(overWrite.getDate() + 1);

				overWrite = (overWrite.getMonth() + 1) + '/' + (overWrite.getDate()) + '/' +  overWrite.getFullYear();

				$(".check_in").data('dateRangePicker').setStart(startDate);

				$(".check_in").data('dateRangePicker').setEnd(overWrite,true);

				$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

				$(".datepicker_in_sticky").data('dateRangePicker').setEnd(overWrite,true);

				$("#check_in").addClass('valid');

				$("#check_out").addClass('valid');

				$("#check_in").removeClass('error');

				$('label[for=check_in]').css('display','none');

				$("#check_out").removeClass('error');

				$('label[for=check_out]').css('display','none');

				$("#datepicker_in_sticky").addClass('valid');

				$("#datepicker_out_sticky").addClass('valid');

				setQueryStrings();

				$('.checkin-container').slideUp();

				$('.main_tooltip').css('display','none');

				currCalendar = '';

			}

			else

			{

				$(".check_in").data('dateRangePicker').setStart(startDate);

				$(".check_in").data('dateRangePicker').setEnd(endDate,true);

				$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

				$(".datepicker_in_sticky").data('dateRangePicker').setEnd(endDate,true);

				$("#check_in").addClass('valid');

				$("#check_out").addClass('valid');

				$("#check_in").removeClass('error');

				$('label[for=check_in]').css('display','none');

				$("#check_out").removeClass('error');

				$('label[for=check_out]').css('display','none');

				$("#datepicker_in_sticky").addClass('valid');

				$("#datepicker_out_sticky").addClass('valid');

				$('.checkin-container').slideUp();

				setQueryStrings();

				$('.main_tooltip').css('display','none');

				currCalendar = '';

			}

		}

		

	}).bind('datepicker-change',function(event,obj)

	{

		var startDate = $('#check_in').val();

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

			$(".check_in").data('dateRangePicker').setStart(startDate);

			$(".check_in").data('dateRangePicker').setEnd(overWrite,true);

			$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

			$(".datepicker_in_sticky").data('dateRangePicker').setEnd(overWrite,true);

			$("#check_in").addClass('valid');

			$("#check_out").addClass('valid');

			$("#check_in").removeClass('error');

			$('label[for=check_in]').css('display','none');

			$("#check_out").removeClass('error');

			$('label[for=check_out]').css('display','none');

			$("#datepicker_in_sticky").addClass('valid');

			$("#datepicker_out_sticky").addClass('valid');

			setQueryStrings();

			$('.checkin-container').slideUp();

			$('.main_tooltip').css('display','none');

			currCalendar = '';

		}

		else

		{

			$(".check_in").data('dateRangePicker').setStart(startDate);

			$(".check_in").data('dateRangePicker').setEnd(endDate,true);

			$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

			$(".datepicker_in_sticky").data('dateRangePicker').setEnd(endDate,true);

			$("#check_in").addClass('valid');

			$("#check_out").addClass('valid');

			$("#check_in").removeClass('error');

			$('label[for=check_in]').css('display','none');

			$("#check_out").removeClass('error');

			$('label[for=check_out]').css('display','none');

			$("#datepicker_in_sticky").addClass('valid');

			$("#datepicker_out_sticky").addClass('valid');

			setQueryStrings();

			$('.checkin-container').slideUp();

			$('.main_tooltip').css('display','none');

			currCalendar = '';

		}

	});

	

	$('#check_in').on('focus',function(event){

		currCalendar = '#check_in';

		$('span[class=next]').click();

		$('span[class=prev]').click();

		$('.main_tooltip').css('display','none');

		$(event.target).next().next().css('display','block');

		$('.checkin-container').slideDown();

	});

	$('#check_out').on('focus',function(event){

		currCalendar = '#check_out';

		$('span[class=next]').click();

		$('span[class=prev]').click();

		$('.main_tooltip').css('display','none');

		$(event.target).next().next().css('display','block');

		$('.checkin-container').slideDown();

	});

	

	function setQueryStrings()

	{

		if($('#check_in').val() !== '' && $('#check_out').val() !== '')

		{

			var queryString = '';

			var chkIn = $('#check_in').val();

			var chkOut = $('#check_out').val();

			var urlRooms = $('#horiz_rooms').val();

			var queryString = '?checkin='+chkIn+'&checkout='+chkOut+'&rooms='+urlRooms;

			for(var rl = 1;rl<=urlRooms;rl++)

			{

				var urlAdultsName = $('#adultrooms-'+rl).attr('name');

				var urlAdultsVal = $('#adultrooms-'+rl).val();

				queryString = queryString+'&'+urlAdultsName+'='+urlAdultsVal;

				var urlChildrenName = $('#total_child_rooms'+rl).attr('name');

				var urlChildrenVal = $('#total_child_rooms'+rl).val()||0;

				queryString = queryString+'&'+urlChildrenName+'='+urlChildrenVal;

				for(var cl = 1;cl<=urlChildrenVal;cl++)

				{

					var urlAgeName = $('#childrooms_'+rl+'_ages_'+cl).attr('name');

					var urlAgeVal = $('#childrooms_'+rl+'_ages_'+cl).val();

					queryString = queryString+'&'+urlAgeName+'='+urlAgeVal;

				}

			}

			window.history.pushState({},document.title,queryString);

		}

		else

		{

			window.history.pushState({},document.title,'./');

		}

	}

	$("#updateSearchRoomPage").validate({

		rules: {

		checkinRoomPage: "required",

		checkoutRoomPage: "required"

		},

		messages: {

		checkinRoomPage: "This field is required",

		checkoutRoomPage:"This field is required"

		},

		highlight: function(element, errorClass, validClass){

			$(element).addClass("error");

		},

		unhighlight: function(element, errorClass, validClass){

			$(element).removeClass("error");

		},

		submitHandler: function(form){

		var errorFlag = 0;

		var rooms;

		rooms = $("#horiz_rooms").val();

			for(var i = 1; i<= rooms; i++){

				var val = $("#adultrooms-"+i).val();

				var childVal = $("select[id=total_child_rooms"+i+"]").val();

				if(val == 0)

				{

					$("#adultrooms-"+i).addClass("error");

					$("#adultrooms-"+i).after('<label class="error">Please fill this field</label>');

					errorFlag = errorFlag+1;

				}

				else

				{

					if($("#adultrooms-"+i).next()[0].localName == 'label')

					{

						$("#adultrooms-"+i).next().remove();

					}

					if(childVal > 0)

					{

						for(var j = 1; j<= childVal; j++)

						{

							var curChildVal = $("select[id=childrooms_"+i+"_ages_"+j+"]").val();

							if(curChildVal == 0)

							{

								$("select[id=childrooms_"+i+"_ages_"+j+"]").addClass("error");

								$("select[id=childrooms_"+i+"_ages_"+j+"]").after('<label class="error">Please fill this field</label>');

								errorFlag = errorFlag+1;

							}

							else

							{

								if($("select[id=childrooms_"+i+"_ages_"+j+"]").next()[0].localName == 'label')

								{

									$("select[id=childrooms_"+i+"_ages_"+j+"]").next().remove();

								}

							}

						}

					}

				}

			}

			if(errorFlag == 0)

			{

				$(".overlay").show();

				params = $("#updateSearchRoomPage").serialize();

				$.ajax({

					type : "GET",

					url : site_url + "/searchWithNewParams",

					dataType : 'json',

					data:params,

					cache : false,

					success : function(data) {

						$(".overlay").hide();

						if(data.error == 500)

						{

							window.location.href = site_url +"/500";	

							return false;

						}

						else if(data.error == 1)

						{

							$('.top-room-description').addClass('no-dates-selected');

							$("#roomsReplacable").html(data.msg);

							$("#submit_booking").hide();

							$(".minDeal").html('See Availability');

							$("#adjustDatesText").show();

							$("#roomMainHeading").text('No Room Available');

							$("#adjustDatesButton").show();

							$("#adjustDatesFalse").hide();

							$("#adjustDatesTrue").show();

							showRooms();

						}

						else if(data.error == 0)

						{

							$("#submit_booking").show();

							$(".minDeal").css('visibility','visible');

							$("#minDealLeft").show();

							$("#minDeal1").show();

							$("#adjustDatesText").hide();

							$("#adjustDatesButton").hide();

							$("#adjustDatesFalse").show();

							$("#adjustDatesTrue").hide();

							$("#roomMainHeading").text('Pick a Room');

							$("#roomsReplacable").html(data.msg);

							$(".minDeal").html(data.minPrice+'/night');

							$("#minDealLeft").html(data.minPrice);

							defaultMin = data.minPrice;

							defaultMin = defaultMin.replace('$','');

							$('.top-room-description').removeClass('no-dates-selected');

							showRooms();

						}

					}

				  });

			}

			else

			{

				$('#horiz-box-rooms').show();

			}

		}

	});

	/*====================== end rooms header search box script here ==============*/

	/*=========script for load more room page left sidebar tabs===========*/

	showRooms();

	function showRooms()

	{

		$('.roomBlocks').each(function(){

			var currBtn = $(this).attr('name');

			var  size_rooms = $(this).find(".pform-1").size();

			x = 5;

			$(this).find('.pform-1:lt('+x+')').fadeIn();

			if(size_rooms > 5)

			{

				$(this).find('.pform-1').eq(4).addClass('radius-last');

			}

			if(size_rooms <= x){

				$('#'+currBtn).hide();

			}

		});

	}

	$(document).on('click','.viewMoreOption',function(){

		var currElem = $(this).attr('id');

		var  size_rooms = $('div[name='+currElem+']').find(".pform-1").size();

		$('div[name='+currElem+']').find('.pform-1:lt('+size_rooms+')').fadeIn();

		$('div[name='+currElem+']').find('.pform-1').eq(4).removeClass('radius-last');

		//$(this).hide();

		$(this).removeClass('viewMoreOption');

		$(this).addClass('viewLessOption');

		$(this).find('a').html('View Less Option&nbsp; <i class="icon ion-ios-arrow-thin-up"></i>');

	});

	

	$(document).on('click','.viewLessOption',function(){

		var currElem = $(this).attr('id');

		var  size_rooms = $('div[name='+currElem+']').find(".pform-1").size();

		var x = 4;

		$('div[name='+currElem+']').find('.pform-1:gt('+x+')').hide();

		$('div[name='+currElem+']').find('.pform-1').eq(x).addClass('radius-last');

		//$(this).hide();

		$(this).removeClass('viewLessOption');

		$(this).addClass('viewMoreOption');

		$(this).find('a').html('View More Option&nbsp; <i class="icon ion-ios-arrow-thin-down"></i>');

	});

 /*=========End script for load more room page left sidebar tabs===========*/

 

 /*======== Script for room page left sidebar tabs===========*/

 if(pageUrl.search("/rooms") !== -1 || pageUrl.search("/deals") !== -1 || pageUrl.search("/viewHotel") !== -1)

 {

	$(document).on("click","#adjustDatesButton",function(event){

		event.preventDefault();

		$('html, body').animate({

			scrollTop: $("#roomAvlSection").offset().top -50

		}, 500,function(){

			$('#check_in').focus();

		});

	});

	$(document).on("click","#adjustDatesTrueButton",function(event){

		event.preventDefault();

		$('html, body').animate({

			scrollTop: $("#roomAvlSection").offset().top -100

		}, 500,function(){

			$('#check_in').focus();

		});

	});

	$('#map').css('pointer-events','none');

	$('#mapSection').on("mouseup",function(){

		$('#map').css('pointer-events','none');

	});

	$('#mapSection').on("mousedown",function(){

		$('#map').css('pointer-events','auto');

	});

	$("#map").mouseleave(function () {

		$('#map').css('pointer-events','none'); 

	});

	/*==== script for jump links =================*/

	 $('.jumplinks-nav ul li a').on('click', function(){

		var scrollAnchor = $(this).attr('data-scroll');

		var scrollPoint = $('#'+scrollAnchor).offset().top - 90;

		$('body,html').animate({

			scrollTop: scrollPoint

		}, 500);

		return false;

	});

	/*==== script for jump links =================*/

	$(window).scroll(function(){

		if ($(window).scrollTop()+80 >= ($(document).height() - $(window).height())-30)

		 {

			 $('.adjust_dates_buttons').addClass('button_visible');

		 }

		 else

		 {

			 $('.adjust_dates_buttons').removeClass('button_visible');

		 }

		 var scrollPos = $(document).scrollTop();

		 $('.jumplinks-nav ul li a').each(function(index,element){

            var currLink = $(this);

			var refElement = $('#'+currLink.attr("data-scroll"));

			if ((refElement.offset().top)-100 <= scrollPos){

				$('.jumplinks-nav ul li a').removeClass("active");

				currLink.addClass("active");

			}

			else{

				currLink.removeClass("active");

			}

         });

	});

	

	$(document).on('click','.book_room',function(){

		var currStatus = $(this).prop('checked');

		$(this).parents().eq(3).find('input[class = book_room]').prop('checked',false);

		/*if(currStatus == true)

		{

			console.log("True");

			$(this).prop('checked',true);

		}

		else

		{

			console.log("False");

			$(this).prop('checked',false);

		}*/

		$(this).prop('checked',true);

		var bookElems = $('input[class = book_room]:checked');

		var aggregate = 0;

		$(bookElems).each(function(){

			var currElem = $(this).parents().eq(2).find('.right-amout')[0].innerText;

			currElem = currElem.replace('/night','');

			currElem = currElem.replace('$','');

			aggregate = aggregate+parseFloat(currElem);

		});

		if(aggregate > 0)

		{

			$(".minDeal").html('$'+aggregate.toFixed(2)+'/night');

			$("#minDealLeft").html('$'+aggregate.toFixed(2));

		}

		else

		{

			$(".minDeal").html('$'+defaultMin+'/night');

			$("#minDealLeft").html('$'+defaultMin);

		}

	});

	

	$(document).on('click','#fbShare',function fbShare(){

		var shareHref = 'http://www.facebook.com/sharer.php?'+$('#fbContent').attr('class')+'&u='+encodeURIComponent(location.href);

		window.open(shareHref,'_blank');

	});

	$(document).on('click','#twitterShare',function fbShare(){

		var shareHref = 'https://twitter.com/share?'+$('#twitterContent').attr('class')+'&url='+encodeURIComponent(location.href);

		window.open(shareHref,'_blank');

	});

	$(document).on('click','#pinShare',function fbShare(){

		var shareHref = 'https://pinterest.com/pin/create/button/?'+$('#pinContent').attr('class')+'&url='+encodeURIComponent(location.href);

		window.open(shareHref,'_blank');

	});

	$(document).on('click','#mailShare',function fbShare(){

		var shareHref = 'mailto:?'+$('#mailContent').attr('class')+' '+encodeURIComponent(location.href);

		window.open(shareHref,'_blank');

	});

	$(document).on('click','#gShare',function fbShare(){

		var shareHref = 'https://plus.google.com/share?'+'url='+encodeURIComponent(location.href);

		window.open(shareHref,'_blank');

	});

 }

/*==========End script for room page left sidebar tabs===========*/

	$("#submit_booking,#minDeal1").click(function(){

		var selected = [];

		$(".book_room:checked").each(function(){

    		selected.push($(this).val());

		});

		if(selected.length > 0)

		{

			$("#booking_form").submit();

		}

		else

		{

			var hotelCode = $('input[name=hcodeRoomPage]').val();


			window.location.href = site_url+'/payment/'+hotelCode;

		}


	});

/*========= script for displaying horizontal search box =================*/

 	$(document).on('click',function(event){

		parent1 = "",parent2 = "",parent3 = "",parent4 = "",parent5= ""

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

		if($(event.target).parents().eq(4).length !== 0)

		{

			parent5 = $(event.target).parents().eq(4)[0].className;

		}

		current = $(event.target)[0].className;

		if(current.search("rooms-horiz-box") !== -1)

		{

			$('#horiz-box-rooms').slideToggle("fast");

		}

		else

		{

			if(parent1 !== 'engine-dropdown-row engine-dropdown-row-rooms' && parent2 !== 'engine-dropdown-row engine-dropdown-row-rooms' && parent3 !== 'engine-dropdown-row engine-dropdown-row-rooms' && 

			   parent4 !== 'engine-dropdown-row engine-dropdown-row-rooms' && parent5 !== 'engine-dropdown-row engine-dropdown-row-rooms' && current !== 'engine-dropdown-row engine-dropdown-row-rooms' && current !== 'engine-dropdown-btns' && 

			   current !== 'btn-addrow' && current !== 'btn-cnfrm')

			{

			$('#horiz-box-rooms').hide();

			}

		}

    });

	

	$(document).on('click','#addHorizRoom',function(event){

		event.preventDefault();

		var roomValOld = parseInt($('#horiz_rooms').val());

		if(roomValOld < 5)

		{

			roomValNew = parseInt(roomValOld)+1;

			preValRooms2 = roomValNew;

			$('.engine-dropdown-row:not(.engine-dropdown-row-rooms):lt('+roomValNew+')').css('display','block');

			$('.engine-dropdown-row-rooms:lt('+roomValNew+')').slideDown(500);

			$('#horiz_rooms').val(roomValNew);

			$('#rooms_change').val(roomValNew);

		}

		var totalChild = calculate_children('#horiz_rooms','.horiz-child-rooms');

		var totalAdult = calculate_adults('#horiz_rooms','.horiz-adults-rooms');

		var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

		$('#adultChildSumRooms').val(result);

		$('#adultsChildSticky').val(result);

		setQueryStrings();

	});

	

	$(document).on('click','#confirmHorizRoom',function(event){

		event.preventDefault();

		$('#horiz-box-rooms').hide();

	});

	

	$(document).on('change','#horiz_rooms',function(event){

		var horizVal = $(this).val();

		if(preValRooms2 === 0)

		{

			preValRooms2 = horizVal;

			$('.engine-dropdown-row-rooms:lt('+horizVal+')').slideDown(500);

			$('.engine-dropdown-row:not(.engine-dropdown-row-rooms)').css('display','none');

			$('.engine-dropdown-row:lt('+horizVal+')').css('display','block');

		}

		else

		{

			if(preValRooms2 < horizVal)

			{

				preValRooms2 = horizVal;

				$('.engine-dropdown-row-rooms:lt('+horizVal+')').slideDown(500);

				$('.engine-dropdown-row:not(.engine-dropdown-row-rooms)').css('display','none');

				$('.engine-dropdown-row:lt('+horizVal+')').css('display','block');

			}

			else if(preValRooms2 >= horizVal)

			{

				preValRooms2 = horizVal;

				$('.engine-dropdown-row-rooms:gt('+(horizVal-1)+')').slideUp(500);

				$('.engine-dropdown-row:not(.engine-dropdown-row-rooms)').css('display','none');

				$('.engine-dropdown-row:lt('+horizVal+')').css('display','block');

			}

		}

		$('#rooms_change').val(horizVal);

		$('#horiz_rooms').val(horizVal);

		var totalChild = calculate_children('#horiz_rooms','.horiz-child-rooms');

		var totalAdult = calculate_adults('#horiz_rooms','.horiz-adults-rooms');

		var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

		$('#adultChildSumRooms').val(result);

		$('#adultsChildSticky').val(result);

		setQueryStrings();

	});

	

	$(document).on('change','.horiz-adults-rooms',function(event){

		var currName = $(this).attr('name');

		$('select[name='+currName+']').val($(this).val());

		var totalChild = calculate_children('#horiz_rooms','.horiz-child-rooms');

		var totalAdult = calculate_adults('#horiz_rooms','.horiz-adults-rooms');

		var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

		$('#adultChildSumRooms').val(result);

		$('#adultsChildSticky').val(result);

		setQueryStrings();

	});

	

	$(document).on('change','.horiz-child-rooms',function(event){

		var horizClass = $(this).attr('id');

		var horizClass1 = horizClass.replace('rooms','sticky');

		var currName = $(this).attr('name');

		$('select[name='+currName+']').val($(this).val());

		horizClass = horizClass+'_ages';

		horizClass1 = horizClass1+'_ages';

		var horizVal = $(this).val();

		if(horizVal > 0)

		{

			selElems = $('.'+horizClass).find("select");

			$('.'+horizClass).css('display','block');

			$('.'+horizClass).find("select").attr('disabled','disabled');

			selElems1 = $('.'+horizClass1).find("select");

			$('.'+horizClass1).css('display','block');

			$('.'+horizClass1).find("select").attr('disabled','disabled');

			for(var el = 0; el < selElems.length; el++)

			{

				if(el < horizVal)

				{

					$(selElems[el]).removeAttr('disabled');

					$(selElems1[el]).removeAttr('disabled');

				}

			}

		}

		else

		{

			$('.'+horizClass).find("select").attr('disabled','disabled');

			$('.'+horizClass).css('display','none');

			$('.'+horizClass1).find("select").attr('disabled','disabled');

			$('.'+horizClass1).css('display','none');

		}

		var totalChild = calculate_children('#horiz_rooms','.horiz-child-rooms');

		var totalAdult = calculate_adults('#horiz_rooms','.horiz-adults-rooms');

		var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

		$('#adultChildSumRooms').val(result);

		$('#adultsChildSticky').val(result);

		setQueryStrings();

	});

	

	function calculate_children(roomsClass,childClass)

	{

		var roomsCount = $(roomsClass).val();

		var childElems = $(childClass);

		var totalChild = 0;

		for(var i = 0; i < roomsCount; i++)

		{

			var currVal = parseInt($(childElems[i])[0].value)||0;

			totalChild = totalChild+currVal;

		}

		return totalChild;

	}

	function calculate_adults(roomsClass,adultClass)

	{

		var roomsCount = $(roomsClass).val();

		var adultElems = $(adultClass);

		var totalAdult = 0;

		for(var i = 0; i < roomsCount; i++)

		{

			var currVal = parseInt($(adultElems[i])[0].value)||0;

			totalAdult = totalAdult+currVal;

		}

		return totalAdult;

	}

/*========= End script for displaying horizontal search box ===========*/



/*========== script for sticky header processing ===================================*/



/*====================== sticky header search box script here ======================*/

	currentDateSticky = '';

	$('.datepicker_in_sticky').dateRangePicker({

		separator : ' to ',

		format: 'MM/DD/YYYY',

		startDate: new Date(),

		maxDays:31,

		stickyMonths: true,

		inline:true,

		container:'.datepicker-container-sticky',

		alwaysOpen:true,

		beforeShowDay: function(t)

		{

			var startDate = $('#datepicker_in_sticky').val();

			if(startDate !== '')

			{

				var dat = new Date(t);

				if(DateDiff(startDate,dat) > 30)

				{

					if(currCalendar == '#datepicker_in_sticky')

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

					if(DateDiff(startDate,dat) < 0 && currCalendar == '#datepicker_out_sticky')

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

				$("#datepicker_in_sticky").val(s1);

				$("#datepicker_out_sticky").val(overWrite);

				$("#check_in").val(s1);

				$("#check_out").val(overWrite);

				document.getElementById("nightsRoomPage").value= DateDiff(s1,overWrite);

				document.getElementById("nightsSticky").value= DateDiff(s1,overWrite);

			}

			else

			{

				$("#datepicker_in_sticky").val(s1);

				$("#datepicker_out_sticky").val(s2);

				$("#check_in").val(s1);

				$("#check_out").val(s2);

				document.getElementById("nightsRoomPage").value= DateDiff(s1,s2);

				document.getElementById("nightsSticky").value= DateDiff(s1,s2);

			}

		}

	}).bind('datepicker-first-date-selected', function(event, obj)

	{

		var startDate = $('#datepicker_in_sticky').val();

		var endDate = $('#datepicker_out_sticky').val();

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

			var startDate = month+'/'+day+'/' + obj.date1.getFullYear();

			$("#datepicker_in_sticky").val(startDate);

			$("#datepicker_in_sticky").addClass('valid');

			$("#datepicker_in_sticky").removeClass('error');

			$('label[for=datepicker_in_sticky]').css('display','none');

			$("#datepicker_out_sticky").val('');

			$("#datepicker_out_sticky").removeClass('valid');

			$("#check_in").val(startDate);

			$("#check_in").addClass('valid');

			$("#check_in").removeClass('error');

			$('label[for=check_in]').css('display','none');

			$("#nightsSticky").val('');

			$("#nightsRoomPage").val('');

			$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

			$(".check_in").data('dateRangePicker').setStart(startDate);

			$("#datepicker_out_sticky").focus();

		}

		else if(startDate != '')

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

			if(currCalendar == '#datepicker_in_sticky')

			{

				$(".datepicker_in_sticky").data('dateRangePicker').clear();

				$("#datepicker_in_sticky").val(endDate);

				$("#datepicker_in_sticky").addClass('valid');

				$("#datepicker_in_sticky").removeClass('error');

				$('label[for=datepicker_in_sticky]').css('display','none');

				$("#datepicker_out_sticky").val('');

				$("#datepicker_out_sticky").removeClass('valid');

				$("#check_in").val(startDate);

				$("#check_in").addClass('valid');

				$("#check_in").removeClass('error');

				$('label[for=check_in]').css('display','none');

				$("#nightsSticky").val('');

				$("#nightsRoomPage").val('');

				$(".check_in").data('dateRangePicker').setStart(startDate);

				$(".datepicker_in_sticky").data('dateRangePicker').setStart(endDate);

				$("#datepicker_out_sticky").focus();

			}

			else if(DateDiff(startDate,endDate) <= 0)

			{

				overWrite = new Date(startDate);

				overWrite.setDate(overWrite.getDate() + 1);

				overWrite = (overWrite.getMonth() + 1) + '/' + (overWrite.getDate()) + '/' +  overWrite.getFullYear();

				$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

				$(".datepicker_in_sticky").data('dateRangePicker').setEnd(overWrite,true);

				$(".check_in").data('dateRangePicker').setStart(startDate);

				$(".check_in").data('dateRangePicker').setEnd(overWrite,true);

				$("#datepicker_in_sticky").addClass('valid');

				$("#datepicker_out_sticky").addClass('valid');

				$("#datepicker_in_sticky").removeClass('error');

				$('label[for=datepicker_in_sticky]').css('display','none');

				$("#datepicker_out_sticky").removeClass('error');

				$('label[for=datepicker_out_sticky]').css('display','none');

				$("#check_in").addClass('valid');

				$("#check_in").removeClass('error');

				$('label[for=check_in]').css('display','none');

				$("#check_out").addClass('valid');

				$("#check_out").removeClass('error');

				$('label[for=check_out]').css('display','none');

				if($('.search_hotel_sticky').val() !== '')

				{

					$('.search_hotel_sticky').addClass('valid');

					$('.search_hotel_sticky').removeClass('error');

					$('.destination-autofill').removeClass("coloredOutline");

					$(".staying-days").removeClass('error');	

				}

				setQueryStrings();

				$('.datepicker-container-sticky').slideUp();

				$('.sticky_tooltip_in').css('display','none');

				$('.sticky_tooltip_out').css('display','none');

				currCalendar = '';

			}

			else

			{

				$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

				$(".datepicker_in_sticky").data('dateRangePicker').setEnd(endDate,true);

				$(".check_in").data('dateRangePicker').setStart(startDate);

				$(".check_in").data('dateRangePicker').setEnd(endDate,true);

				$("#datepicker_in_sticky").addClass('valid');

				$("#datepicker_out_sticky").addClass('valid');

				$("#datepicker_in_sticky").removeClass('error');

				$('label[for=datepicker_in_sticky]').css('display','none');

				$("#datepicker_out_sticky").removeClass('error');

				$('label[for=datepicker_out_sticky]').css('display','none');

				$("#check_in").addClass('valid');

				$("#check_in").removeClass('error');

				$('label[for=check_in]').css('display','none');

				$("#check_out").addClass('valid');

				$("#check_out").removeClass('error');

				$('label[for=check_out]').css('display','none');

				if($('.search_hotel_sticky').val() !== '')

				{

					$('.destination-autofill').removeClass("coloredOutline");

					$('.search_hotel_sticky').addClass('valid');

					$('.search_hotel_sticky').removeClass('error');

					$(".staying-days").removeClass('error');	

				}

				setQueryStrings();

				$('.datepicker-container-sticky').slideUp();

				$('.sticky_tooltip_in').css('display','none');

				$('.sticky_tooltip_out').css('display','none');

				currCalendar = '';

			}

		}

		

	}).bind('datepicker-change',function(event,obj)

	{

		var startDate = $('#datepicker_in_sticky').val();

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

			overWrite.setDate(overWrite.getDate() + 1);

			overWrite = (overWrite.getMonth() + 1) + '/' + (overWrite.getDate()) + '/' +  overWrite.getFullYear();

			$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

			$(".datepicker_in_sticky").data('dateRangePicker').setEnd(overWrite,true);

			$(".check_in").data('dateRangePicker').setStart(startDate);

			$(".check_in").data('dateRangePicker').setEnd(overWrite,true);

			$("#datepicker_in_sticky").addClass('valid');

			$("#datepicker_out_sticky").addClass('valid');

			$("#datepicker_in_sticky").removeClass('error');

			$('label[for=datepicker_in_sticky]').css('display','none');

			$("#datepicker_out_sticky").removeClass('error');

			$('label[for=datepicker_out_sticky]').css('display','none');

			if($('.search_hotel_sticky').val() !== '')

			{

				$('.destination-autofill').removeClass("coloredOutline");

				$('.search_hotel_sticky').addClass('valid');

				$('.search_hotel_sticky').removeClass('error');

				$(".staying-days").removeClass('error');	

			}

			$("#check_in").addClass('valid');

			$("#check_in").removeClass('error');

			$('label[for=check_in]').css('display','none');

			$("#check_out").addClass('valid');

			$("#check_out").removeClass('error');

			$('label[for=check_out]').css('display','none');

			setQueryStrings();

			$('.datepicker-container-sticky').slideUp();

			$('.sticky_tooltip_in').css('display','none');

			$('.sticky_tooltip_out').css('display','none');

			currCalendar = '';

		}

		else

		{

			$(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

			$(".datepicker_in_sticky").data('dateRangePicker').setEnd(endDate,true);

			$(".check_in").data('dateRangePicker').setStart(startDate);

			$(".check_in").data('dateRangePicker').setEnd(endDate,true);

			$("#datepicker_in_sticky").addClass('valid');

			$("#datepicker_out_sticky").addClass('valid');

			$("#datepicker_in_sticky").removeClass('error');

			$('label[for=datepicker_in_sticky]').css('display','none');

			$("#datepicker_out_sticky").removeClass('error');

			$('label[for=datepicker_out_sticky]').css('display','none');

			if($('.search_hotel_sticky').val() !== '')

			{

				$('.destination-autofill').removeClass("coloredOutline");

				$('.search_hotel_sticky').addClass('valid');

				$('.search_hotel_sticky').removeClass('error');

				$(".staying-days").removeClass('error');	

			}

			$("#check_in").addClass('valid');

			$("#check_in").removeClass('error');

			$('label[for=check_in]').css('display','none');

			$("#check_out").addClass('valid');

			$("#check_out").removeClass('error');

			$('label[for=check_out]').css('display','none');

			setQueryStrings();

			$('.datepicker-container-sticky').slideUp();

			$('.sticky_tooltip_in').css('display','none');

			$('.sticky_tooltip_out').css('display','none');

			currCalendar = '';

		}

	});

	

	$('#datepicker_in_sticky').on('focus',function(event){

		currCalendar = '#datepicker_in_sticky';

		$('span[class=next]').click();

		$('span[class=prev]').click();

		$('.sticky_tooltip_out').css('display','none');

		$('.sticky_tooltip_in').css('display','block');

		$('.datepicker-container-sticky').slideDown();

	});

	$('#datepicker_out_sticky').on('focus',function(event){

		currCalendar = '#datepicker_out_sticky';

		$('span[class=next]').click();

		$('span[class=prev]').click();

		$('.sticky_tooltip_in').css('display','none');

		$('.sticky_tooltip_out').css('display','block');

		$('.datepicker-container-sticky').slideDown();

	});

	

	$(document).on('click','#clearDates',function(){

		$(".datepicker_in_sticky").data('dateRangePicker').clear();

		$(".check_in").data('dateRangePicker').clear();

		$("#nightsRoomPage").val('');

		$("#nightsSticky").val('');

		setQueryStrings();

	});

	

	$(".search_hotel_sticky").keyup(function(){

		$("#input_hotelSticky").val("");

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

		var c = 0;

		var co = 0;

		$.each(data, function(i, value) {

		$('.search_result_sticky').css("display", "block");

		if(value.hotelgroupname){

		html += "<span class='location-lable-"+i+"' style='display:none;'>Location</span>"+

		"<label class='selected_value_sticky' name='hotelgroupname' id='"+value.hotelgroupcode+"' value = '"+value.hotelgroupname+"'>" +value.hotelgroupname +"</label>";

		}

		if(value.city){	

		html += "<span class='city-lable-"+co+"' style='display:none;'>City</span>"+

		"<label class='selected_value_sticky' name='city' id ='"+value.cityCode+"' value = '"+value.city+"'>" +value.city +"</label>";

			co++;

		}if(value.name){

		

		var count = c++;

		html += "<span class='hotel-lable-"+count+"' style='display:none;'>Hotel</span>"+

		"<label class='selected_value_sticky' name='hotel' id='"+value.hotelCode+"' value = '"+value.name+"'>" +value.name +" (Hotel)</label>";	

		

		}

		

		});

		$('.search_result_sticky').html(html);

		

		}

		});

	});

 

	$(document).on("click", ".selected_value_sticky", function(){

		var value = $(this).text();

		var id = $(this).attr("id");

		var name = $(this).attr("name");

		$(".search_hotel_sticky").val(value);

		$("#input_hotelSticky").val(id);

		$("#stypeSticky").val(name);

		$('.search_result_sticky').hide();

	});

	

	$(window).click(function () { 

		$('.search_result_sticky').hide();

	});

	

	$(".sticky-form").validate({

		rules: {

		location_name:{

		required:true

		},

		checkin: "required",

		checkout: "required",

		nights: "required"

		},

		messages: {

		location_name:{required:"This field is required"},

		checkin: "This field is required",

		checkout:"This field is required",

		nights: "This field is required",

		},

		highlight: function(element, errorClass, validClass) {

		  if($(element)[0].id === 'datepicker_out_sticky' || $(element)[0].id === 'datepicker_in_sticky')

		  {

			  $('.destination-autofill').addClass("coloredOutline");

			  $('.staying-days').addClass("error");

			  $('.search_hotel_sticky').addClass('error');

			  $('#datepicker_out_sticky').closest('label').css('display','block');

		  }

		  else if($(element)[0].name === 'location_name')

		  {

			  $('.destination-autofill').addClass("coloredOutline");

			  $('.search_hotel_sticky').removeClass('valid');

			  $('.staying-days').addClass("error");

			  $(element).addClass("error");

		  }

		  else

		  {

			  $(element).addClass("error");

		  }

	

		},

		unhighlight: function(element, errorClass, validClass){

		  if($(element)[0].id === 'datepicker_out_sticky' || $(element)[0].id === 'datepicker_in_sticky')

		  {

			  if($('#datepicker_out_sticky').val() !== '' && $('#datepicker_in_sticky').val() !== '')

			  {

				  if($('.search_hotel_sticky').val() !== '')

				  {

					$('.staying-days').removeClass("error");

					$('.destination-autofill').removeClass("coloredOutline");

					$('.search_hotel_sticky').addClass('valid');

			  		$('label[for=datepicker_in_sticky]').css('display','none');

					$('label[for=datepicker_out_sticky]').css('display','none');

				  }

			  }

		  }

		  else if($(element)[0].name === 'location_name')

		  {

			  if($('#datepicker_out_sticky').val() !== '' && $('#datepicker_in_sticky').val() !== '')

			  {

				  $('.staying-days').removeClass("error");

				  $('.destination-autofill').removeClass("coloredOutline");

				  $('.search_hotel_sticky').addClass('valid');

				  $('label[for=datepicker_in_sticky]').css('display','none');

				  $('label[for=datepicker_out_sticky]').css('display','none');

				  $('#datepicker_in_sticky').addClass('valid');

				  $('#datepicker_out_sticky').addClass('valid');

				  $(element).removeClass("error");

			  }

		  }

		  else

		  {

			  $(element).removeClass("error");

		  }

		},

		submitHandler: function(form){

		var errorFlag = 0;

		var rooms;

		rooms = $("#rooms_change").val();

			for(var i = 1; i<= rooms; i++){

				var val = $("#adultsticky-"+i).val();

				var childVal = $("select[id=total_child_sticky"+i+"]").val();

				if(val == 0)

				{

					$("#adultsticky-"+i).addClass("error");

					$("#adultsticky-"+i).after('<label class="error">Please fill this field</label>');

					errorFlag = errorFlag+1;

				}

				else

				{

					if($("#adultsticky-"+i).next()[0].localName == 'label')

					{

						$("#adultsticky-"+i).next().remove();

					}

					if(childVal > 0)

					{

						for(var j = 1; j<= childVal; j++)

						{

							var curChildVal = $("select[id=childsticky_"+i+"_ages_"+j+"]").val();

							if(curChildVal == 0)

							{

								$("select[id=childsticky_"+i+"_ages_"+j+"]").addClass("error");

								$("select[id=childsticky_"+i+"_ages_"+j+"]").after('<label class="error">Please fill this field</label>');

								errorFlag = errorFlag+1;

							}

							else

							{

								if($("select[id=childsticky_"+i+"_ages_"+j+"]").next()[0].localName == 'label')

								{

									$("select[id=childsticky_"+i+"_ages_"+j+"]").next().remove();

								}

							}

						}

					}

				}

			}

			if(errorFlag == 0)

			{

				$(".search-loader").show();

				form.submit(); 

			}

			else

			{

				$('#horiz-box').show();

			}

		}

	});

	

	

	/*====================== end sticky header search box script here ======================*/

	

	/*========= script for displaying horizontal search box =================*/

 	$(document).on('click',function(event){

		parent1 = "",parent2 = "",parent3 = "",parent4 = "",parent5=""

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

		if($(event.target).parents().eq(4).length !== 0)

		{

			parent5 = $(event.target).parents().eq(4)[0].className;

		}

		current = $(event.target)[0].className;

		if(current.search("horiz-search") !== -1)

		{

			$('#horiz-box').slideToggle("fast");

		}

		else

		{

			if(parent1 !== 'engine-dropdown-row' && parent2 !== 'engine-dropdown-row' && parent3 !== 'engine-dropdown-row' && 

			   parent4 !== 'engine-dropdown-row' && current !== 'engine-dropdown-row' && parent5 !== 'engine-dropdown-row' &&

			   current !== 'engine-dropdown-btns' && current !== 'btn-addrow' && current !== 'btn-cnfrm')

			{

			$('#horiz-box').hide();

			}

		}

    });

	

	$(document).on('click','#addStickyRoom',function(event){

		event.preventDefault();

		var roomValOld = parseInt($('#rooms_change').val());

		if(roomValOld < 5)

		{

			roomValNew = parseInt(roomValOld)+1;

			preValRooms2 = roomValNew;

			$('.engine-dropdown-row-rooms:lt('+roomValNew+')').css('display','block');

			$('.engine-dropdown-row:not(.engine-dropdown-row-rooms):lt('+roomValNew+')').slideDown(500);

			$('#horiz_rooms').val(roomValNew);

			$('#rooms_change').val(roomValNew);

			var totalChild = calculate_children('#rooms_change','.horiz-child');

			var totalAdult = calculate_adults('#rooms_change','.adults-sticky');

			var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

			$('#adultsChildSticky').val(result);

			$('#adultChildSumRooms').val(result);

			setQueryStrings();

		}

	});

	

	$(document).on('click','#confirmStickyRoom',function(event){

		event.preventDefault();

		$('#horiz-box').hide();

	});

	

	$(document).on('change','#rooms_change',function(event){

		var horizVal = $(this).val();

		if(preValRooms1 === 0)

		{

			preValRooms1 = horizVal;

			$('.engine-dropdown-row:not(.engine-dropdown-row-rooms):lt('+horizVal+')').slideDown(500);

			$('.engine-dropdown-row-rooms').css('display','none');

			$('.engine-dropdown-row-rooms:lt('+horizVal+')').css('display','block');

		}

		else

		{

			if(preValRooms1 < horizVal)

			{

				preValRooms1 = horizVal;

				$('.engine-dropdown-row:not(.engine-dropdown-row-rooms):lt('+horizVal+')').slideDown(500);

				$('.engine-dropdown-row-rooms').css('display','none');

				$('.engine-dropdown-row-rooms:lt('+horizVal+')').css('display','block');

			}

			else if(preValRooms1 >= horizVal)

			{

				preValRooms1 = horizVal;

				$('.engine-dropdown-row:not(.engine-dropdown-row-rooms):gt('+(horizVal-1)+')').slideUp(500);

				$('.engine-dropdown-row-rooms').css('display','none');

				$('.engine-dropdown-row-rooms:lt('+horizVal+')').css('display','block');

			}

		}

		$('#horiz_rooms').val(horizVal);

		$('#rooms_change').val(horizVal);

		var totalChild = calculate_children('#rooms_change','.horiz-child');

		var totalAdult = calculate_adults('#rooms_change','.adults-sticky');

		var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

		$('#adultsChildSticky').val(result);

		$('#adultChildSumRooms').val(result);

		setQueryStrings();

	});

	

	$(document).on('change','.horiz-child',function(event){

		var horizClass = $(this).attr('id');

		var horizClass1 = horizClass.replace('sticky','rooms');

		var currName = $(this).attr('name');

		$('select[name='+currName+']').val($(this).val());

		horizClass = horizClass+'_ages';

		horizClass1 = horizClass1+'_ages';

		var horizVal = $(this).val();

		if(horizVal > 0)

		{

			selElems = $('.'+horizClass).find("select");

			$('.'+horizClass).css('display','block');

			$('.'+horizClass).find("select").attr('disabled','disabled');

			selElems1 = $('.'+horizClass1).find("select");

			$('.'+horizClass1).css('display','block');

			$('.'+horizClass1).find("select").attr('disabled','disabled');

			for(var el = 0; el < selElems.length; el++)

			{

				if(el < horizVal)

				{

					$(selElems[el]).removeAttr('disabled');

					$(selElems1[el]).removeAttr('disabled');

				}

			}

		}

		else

		{

			$('.'+horizClass).css('display','none');

			$('.'+horizClass).find("select").attr('disabled','disabled');

			$('.'+horizClass1).css('display','none');

			$('.'+horizClass1).find("select").attr('disabled','disabled');

		}

		var totalChild = calculate_children('#rooms_change','.horiz-child');

		var totalAdult = calculate_adults('#rooms_change','.adults-sticky');

		var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

		$('#adultsChildSticky').val(result);

		$('#adultChildSumRooms').val(result);

		setQueryStrings();

	});

	

	$(document).on('change','.adults-sticky',function(event){

		var currName = $(this).attr('name');

		$('select[name='+currName+']').val($(this).val());

		var totalChild = calculate_children('#rooms_change','.horiz-child');

		var totalAdult = calculate_adults('#rooms_change','.adults-sticky');

		var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

		$('#adultsChildSticky').val(result);

		$('#adultChildSumRooms').val(result);

		setQueryStrings();

	});

	

	$(document).on('change','.control-field',function(event){

		var currName = $(this).attr('name');

		var currName1 = $(this).attr('id');

		var pattern = /(children_)[1-8](_age_)[1-8]/g;

		var pattern1 = /(childsticky_)[1-5](_ages_)[1-8]/g;

		var pattern2 = /(childrooms_)[1-5](_ages_)[1-8]/g;

		if(pattern.test(currName) == true)

		{

			$('select[name='+currName+']').val($(this).val());

			var totalChild = calculate_children('#rooms_change','.horiz-child');

			var totalAdult = calculate_adults('#rooms_change','.adults-sticky');

			var result = $('#horiz_rooms').val()+' rooms, '+(totalAdult+totalChild)+' guests';

			$('#adultsChildSticky').val(result);

			$('#adultChildSumRooms').val(result);

			setQueryStrings();	

		}

		

		if(pattern1.test(currName1) == true)

		{

			if($(this).val() > 0)

			{

				$(this).removeClass('error');

				if($(this).next()[0].localName == 'label')

				{

					$(this).next().remove();

				}	

			}

		}

		else if(pattern2.test(currName1) == true)

		{

			if($(this).val() > 0)

			{

				$(this).removeClass('error');

				if($(this).next()[0].localName == 'label')

				{

					$(this).next().remove();

				}	

			}

		}

	});

	

 /*========= End script for displaying horizontal search box ===========*/

 

 /*========= script for selecting rooms by clciking on div  ===========*/

 $(document).on('click','.pform-1',function(event){

	var currCheckBox = $(this).children().find('.book_room');

	if($(event.target)[0].localName !== 'a'){

		if($(currCheckBox).length == 1)

		{

			if($(event.target)[0].className !== 'book_room')

			{

				$(currCheckBox).click();

			}

		}

	}

 });

  /*========= end script for selecting rooms by clciking on div  ===========*/

  

  /*==== script for adjusting calendar tooltip on resize =======================*/

  $(window).click(function (event) { 

		if($(event.target)[0].id !== 'check_in' && $(event.target)[0].id !== 'check_out')

		{

			$('.checkin-container').slideUp('slow',function(){

				$('.main_tooltip').css('display','none');

			});

		}

		if($(event.target)[0].id !== 'datepicker_in_sticky' && $(event.target)[0].id !== 'datepicker_out_sticky')

		{

			$('.datepicker-container-sticky').slideUp('slow',function(){

				$('.sticky_tooltip_in').css('display','none');

				$('.sticky_tooltip_out').css('display','none');

			});

		}

	});

 /*==== end script for adjusting calendar tooltip on resize =================*/

});