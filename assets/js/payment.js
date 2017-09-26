/*===== for booking payment process===*/

var hostedInstance = '';



var style = {
  base: {
    // Add your base input styles here. For example:
    fontSize: '16px',
    lineHeight: '24px'
  }
};

var stripe = Stripe('pk_test_UpccNKmxBsqkDPl6Lwbb4do6');
var elements = stripe.elements();
// Create an instance of the card Element
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>
card.mount('#card-element');


card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});


var inputVariables = ['traveler_title',

		'traveler_fname',

		'traveler_lname',

		'traveler_email',

		'booking_cardholder',

		'card_number',

		'expiration_date',

		'booking_country',

		'booking_address1',

		'booking_city',

		'booking_state',

		'booking_zipcode',

		'booking_security_code',

		'member_title',

		'member_fname',

		'member_lname',

		'member_email',

		'member_phone'];


$("#cardForm").validate({

	rules: {

		traveler_title:{required:true},

		traveler_fname:{required:true},

		traveler_lname:{required:true},

		traveler_email:{required:true,email:true},

		booking_cardholder:{required:true},

		card_number:{required:true},

		expiration_date:{required:true},

		booking_country:{required:true},

		booking_address1:{required:true},

		booking_city:{required:true},

		booking_state:{required:true},

		booking_zipcode:{required:true},

		booking_security_code:{required:true,number:true},

		member_title:{required:true},

		member_fname:{required:true},

		member_lname:{required:true},

		member_email:{required:true,email:true},

		member_phone:{required:true,number:true}

	},

	messages:{

		traveler_title:{required:"Please select a title"},

		traveler_fname:{required:"Please enter first name"},

		traveler_lname:{required:"Please enter last name"},

		traveler_email:{required:"Please enter email",email:"Please enter a valid email"},

		booking_cardholder:{required:"Please enter cardholder name"},

		card_number:{required:"Please enter credit card number"},

		expiration_date:{required:"Please enter card expiration date in format(mm/yy)"},

		booking_country:{required:"Please select country"},

		booking_address1:{required:"Please enter address"},

		booking_city:{required:"Please enter city"},

		booking_state:{required:"Please enter state"},

		booking_zipcode:{required:"Please enter zip code"},

		booking_security_code:{required:"Please enter security code",number:"Only numbers are allowed"},

		member_title:{required:"Please select a title"},

		member_fname:{required:"Please enter first name"},

		member_lname:{required:"Please enter last name"},

		member_email:{required:"Please enter email",email:"Please enter a valid email"},

		member_phone:{required:"Please enter a phone",number:"Only numbers are allowed"}

	},
	showErrors: function(errorMap, errorList) {

		var i = errorList.length;
		if(i>=1){
			var mainError = errorList[0];
				var data = document.getElementsByName(mainError.element.name)[0].value;
				if(data ==''){
					$("input[name="+ mainError.element.name+"]").addClass("error");
					$('#error_' + mainError.element.name).css('display', 'block');
					console.log('ID '+mainError.element.name +' ' +mainError.message);
				}
				for(i = 0; i<errorList.length; i++){
					$("input[name="+ errorList[i].element.name+"]").addClass("error");
				}
		}
		else{
			inputVariables.forEach(function(entry){
				$("input[name="+ entry+"]").removeClass("error");
					$('#error_' + entry).css('display', 'none');
					$('input[name='+entry+']').addClass('valid');
			});
			// $("#"+mainError.element.id).removeClass("error");
		}

	}

});

var form = document.querySelector('#cardForm');

var authorization = 'sandbox_svvmc3r5_s3jyd57pjg7fpdqh';
document.getElementById('cardForm').addEventListener('submit', function (event) {

	event.preventDefault();
stripe.createToken(card).then(function(result) {
	 if (result.error) {
		 // Inform the user if there was an error
		 var errorElement = document.getElementById('card-errors');
		 errorElement.textContent = result.error.message;
	 } else {
		 // Send the token to your server
		 stripeTokenHandler(result.token);
	 }
 });

function stripeTokenHandler(token) {

			var title = $('.valid option:selected').val();

				var form = document.getElementById('cardForm');
				  var hiddenInput = document.createElement('input');
				  hiddenInput.setAttribute('type', 'hidden');
				  hiddenInput.setAttribute('name', 'stripeToken');
				  hiddenInput.setAttribute('value', token.id);
				  form.appendChild(hiddenInput);


			var data =$("#cardForm").serialize();

			$(".booking_process").show();

			$('html,body').animate({ scrollTop: 0 },2000);

			$.ajax({

			type : "GET",

			url : site_url + "/check_out",

			dataType : 'json',

			data :data,

			cache : false,

			success : function(data){

				if(data.error === 1)

				{

				$(".booking_process").hide();

				$("#success_msg").html(data.message);

				}

				else if(data.error === 0)

				{

					window.location.href = site_url+"/thankYou?success="+data.id;

				}

			}

		  });


}
});
