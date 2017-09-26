$(document).ready(function(e) {
	var pathArray = location.href.split('/');
	var protocol = pathArray[0];
	var host = pathArray[2];
	var site_url = protocol + '//' + host + "/travellinked";
		
		
/*=== code for sidebar====*/	
	$(".has-ul a").click(function(){
		$(this).next(".sub-menu").addClass("slide-open");
		$(".admin-leftbar").addClass("nav-open");
	});
	$(".submenu-overlay").click(function(){
		$(this).parent(".sub-menu").removeClass("slide-open");
		$(".admin-leftbar").removeClass("nav-open");
	});


/*====code for datatable====*/
   $('#example').DataTable();
	
/*==== code for booking page tabs===*/	
	$(".has-ul a").click(function(){
		$(this).next(".sub-menu").addClass("slide-open");
		$(".admin-leftbar").addClass("nav-open");
	});
	$(".submenu-overlay").click(function(){
		$(this).parent(".sub-menu").removeClass("slide-open");
		$(".admin-leftbar").removeClass("nav-open");
	});
	
	jQuery('ul.tabs-model').each(function(){
    // For each set of tabs-model, we want to keep track of
    // which tab is active and its associated content
    var $active, $content, $links = jQuery(this).find('a');

    // If the location.hash matches one of the links, use that as the active tab.
    // If no match is found, use the first link as the initial active tab.
    $active = jQuery($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
    $active.addClass('active');

    $content = jQuery($active[0].hash);

    // Hide the remaining content
    $links.not($active).each(function () {
      jQuery(this.hash).hide();
    });

    // Bind the click event handler
    jQuery(this).on('click', 'a', function(e){
      // Make the old tab inactive.
      $active.removeClass('active');
      $content.hide();

      // Update the variables with the new link and content
      $active = $(this);
      $content = $(this.hash);

      // Make the tab active.
      $active.addClass('active');
      $content.show();

      // Prevent the anchor's default click action
      e.preventDefault();
    });
  });

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

/*====== function for rates validation======*/
$("#settingForm").validate({
  rules: {
    "markup[flight][value]": {required:true,number:true},
    "markup[flight][discount]": {required:true,number:true},
    "markup[hotel][value]": {required:true,number:true},
    "markup[hotel][discount]": {required:true,number:true},
    "markup[transfers][value]": {required:true,number:true},
    "markup[transfers][discount]": {required:true,number:true},
    "markup[bus][value]": {required:true,number:true},
    "markup[bus][discount]": {required:true,number:true},
    "markup[holidays][value]": {required:true,number:true},
    "markup[holidays][discount]": {required:true,number:true},
    "markup[cars][value]": {required:true,number:true},
    "markup[cars][discount]": {required:true,number:true}
  },
  messages:{
  	"markup[flight][value]":{required:"<p style='color:#A94442'>Please enter value of tax</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[flight][discount]":{required:"<p style='color:#A94442'>Please enter value of discount</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[hotel][value]":{required:"<p style='color:#A94442'>Please enter value of tax</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[hotel][discount]":{required:"<p style='color:#A94442'>Please enter value of discount</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[transfers][value]":{required:"<p style='color:#A94442'>Please enter value of tax</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[transfers][discount]":{required:"<p style='color:#A94442'>Please enter value of discount</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[bus][value]":{required:"<p style='color:#A94442'>Please enter value of tax</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[bus][discount]":{required:"<p style='color:#A94442'>Please enter value of discount</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[holidays][value]":{required:"<p style='color:#A94442'>Please enter value of tax</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[holidays][discount]":{required:"<p style='color:#A94442'>Please enter value of discount</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[cars][value]":{required:"<p style='color:#A94442'>Please enter value of tax</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  	"markup[cars][discount]":{required:"<p style='color:#A94442'>Please enter value of discount</p>",number:"<p style='color:#A94442'>Only numbers are allowed</p>"},
  },
  submitHandler: function(form) {
	form.submit(); 
  }
});

	
});
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}
function bookings_tab2() {
    document.getElementById("bookings_tab2").classList.toggle("show");
}
function bookings_tab3() {
    document.getElementById("bookings_tab3").classList.toggle("show");
}
function bookings_tab4() {
    document.getElementById("bookings_tab4").classList.toggle("show");
}
/*===== Close ready function =======*/