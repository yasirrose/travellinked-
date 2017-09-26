$(document).ready(function(e){
	var globalStr = '';
	var defaultHtml = '<div class="no-search-box">'+
                        '<div class="no-search-content">'+
                            '<h3>No term supplied</h3>'+
                            '<p>Please type something in search box to get results</p>'+
                        '</div>'+
                        '<div class="recent-searches">'+
                        '</div>'+
                    '</div>';
	/*====== main site url and current url =========*/
	var pathArray = location.href.split('/');
	var protocol = pathArray[0];
	var host = pathArray[2];
	var site_url = protocol + '//' + host + "/travellinked";
	strUrl = location.href;
	/*====== main site url and current url =========*/
	$(".al-search-box input").on('change keyup paste', function() {
		if($(this).val() !== '')
		{
			$('#tabnav1').html('');
			$('#tabnav2').html('');
			$('#tabnav3').html('');
			$(".searh-autobox").addClass("open");
			$(".admin-leftbar").addClass("nav-open");
			$("#sidenav-search").val($(this).val());
			getFilterdRecords($(this).val());
		}
		else
		{
			$('#tabnav1').html(defaultHtml);
			$('#tabnav2').html(defaultHtml);
			$('#tabnav3').html(defaultHtml);
		}
	});
	$(".searh-autobox-close span").click(function(){
		$("#sidenav-search").val('');
		$(".al-search-box input").val('');
		$(".searh-autobox").removeClass("open");
		$(".admin-leftbar").removeClass("nav-open");
	});
	
	$('.search-auto-clear').click(function(){
		$("#sidenav-search").val('');
		$(".al-search-box input").val('');
		$('#tabnav1').html(defaultHtml);
		$('#tabnav2').html(defaultHtml);
		$('#tabnav3').html(defaultHtml);
	});
	
	$(document).on('change keyup paste','#sidenav-search',function() {
		if($(this).val() !== '')
		{
			$('#tabnav1').html('');
			$('#tabnav2').html('');
			$('#tabnav3').html('');
			var param = $("#sidenav-search").val();
			getFilterdRecords(param);
		}
		else
		{
			$('#tabnav1').html(defaultHtml);
			$('#tabnav2').html(defaultHtml);
			$('#tabnav3').html(defaultHtml);
		}
	});
	
	function getFilterdRecords(param)
	{
		$.ajax({
			type : "GET",
			url : site_url + "/admin/get_sidenav_search",
			data:{params:param},
			dataType : 'json',
			cache : false,
			success : function(response){
				$('#tabnav1').html('');
				$('#tabnav2').html('');
				$('#tabnav3').html('');
				$('#tabnav1').html(response.alldata);
				$('#tabnav2').html(response.bookings);
				$('#tabnav3').html(response.users);
			}
		});
	}
	
});