var pathArray = location.href.split('/');
var protocol = pathArray[0];
var host = pathArray[2];
var site_url = protocol + '//' + host + "/travellinked";
$("#user_register_form").validate({
    rules: {email: {required: true, email: true}},
    messages: {email: {required: "Please provide your email", equalTo: "Please enter a valid email"}},
    submitHandler: function () {
        var form = $("#user_register_form").serialize();
        $.ajax({
            type: "POST",
            url: site_url + "/user_register",
            data: form,
            dataType: 'json',
            cache: false,
            success: function (response) {
                if (response.error == 0) {
                    window.location.href = response.url;
                } else if (response == 1) {
                    $("#register_eamil_msg").html(response.msg);
                }
            }
        });
    }
});
$("#50off_register_form").validate({
    rules: {email: {required: true, email: true}},
    messages: {email: {required: "Please provide your email", equalTo: "Please enter a valid email"}},
    submitHandler: function () {
        var form = $("#50off_register_form").serialize();
        $.ajax({
            type: "POST",
            url: site_url + "/user_register",
            data: form,
            dataType: 'json',
            cache: false,
            success: function (response) {
                if (response.error == 0) {
                    window.location.href = response.url;
                } else if (response.error == 1) {
                    if ($('#free-access-email').next()[0].localName == 'label') {
                        $('label[for=free-access-email]').html(response.msg);
                        $('label[for=free-access-email]').css('display', 'block');
                    } else {
                        $('#free-access-email').after('<label for="free-access-email" class="error">' + response.msg + '</label>');
                    }
                }
            }
        });
    }
});
$('#fgt').click(function() {
    $('#thisshow').hide();
    $('#reset-this').show();
})
$("#user_login_form").validate({
    rules: {email: {required: true, email: true}, password: {required: true}},
    messages: {
        email: {required: "Please provide your email", equalTo: "Please enter a valid email"},
        password: {required: "Please enter password"}
    },
    submitHandler: function () {
        $("#msg").html("");
        var type = $('#type').val();
        var form = $("#user_login_form").serialize();
        $.ajax({
            type: "POST",
            url: site_url + "/user_login",
            data: form,
            dataType: 'json',
            cache: false,
            success: function (res) {
                if (res == 1) {
                    if(type == 'simple') {
                        window.location = "http://travellinked.com/travellinked";
                    }else if(type == 'room'){
                        window.location = $("#link").val();
                    }else{
                        window.location = "http://travellinked.com/travellinked/payment/"+type;
                    }
                } else if (res == 0) {
                    $("#msg").html("Sorry! login combination was not matched");
                } else if (res == 2) {
                     $("#msg").html("Sorry! You are no longer Activated");
                }
            }
        });
    }
});
/*============== set password to activate account for new user ===============*/
$("#activate").validate({
    rules: {password: {required: true}, con_password: {required: true, equalTo: '#password'}},
    messages: {
        password: {required: "This field is required"},
        con_password: {required: "This field is required", equalTo: "Please enter same value again"}
    },
    submitHandler: function () {
        var form = $("#activate").serialize();
        $.ajax({
            url: site_url + '/update-activation',
            type: "post",
            dataType: "json",
            cache: false,
            data: form,
            success: function (response) {
                if (response.error == 1) {
                    $('#message').html(response.msg);
                } else if (response.error == 0) {
                    window.location.href = response.url;
                }
            }
        });
    }
});
/*============== forgot password for user to set new password ===============*/
$("#forgot").validate({
    rules: {email: {required: true, email: true}},
    messages: {
        email: {
            required: "Please provide email associated with your account",
            email: "Email should be a valid email"
        }
    },
    submitHandler: function () {
        $('#forgot-message').empty();
        $('#send_mail').empty();
        var form = $("#forgot").serialize();
        $.ajax({
            url: site_url + '/forgot-password-email',
            type: "post",
            dataType: "json",
            cache: false,
            data: form,
            success: function (response) {
                // console.log(response);
                // console.log(response.success);
                // console.log(response.msg);
                if (response.success == 1) {
                    $('#message').text(response.msg);
                } else {
                $('#forgot-message').html('<p style="color:red">Email does not exist. Please enter your account email.</p>');
                //     alert('Email Sent Successfully');
                    window.location.href = "http://travellinked.com/travellinked/userlogin"
                }
            }
        });
    }
});
/*============== set password to activate account for new user ===============*/
$("#forget-activate").validate({
    rules: {
        password: {required: true},
        con_password: {required: true, equalTo: '#password'}
    },
    messages: {
        password: {required: "This field is required"},
        con_password: {required: "This field is required", equalTo: "Please enter same value again"}
    },
    submitHandler: function () {
        var form = $("#forget-activate").serialize();
        $.ajax({
            url: site_url + '/update_Password',
            type: "post",
            dataType: "json",
            cache: false,
            data: form,
            success: function (response) {
                console.log(response);
                console.log(response.success[0]);
                console.log(response.success['msg']);

                if(response.success[0] == 1){
                    $('#message').html(response.success['msg']);
                    window.setTimeout(function () {
                        window.location.href = response.url;
                    }, 1500)
                }else{
                    $('#message').html(response.msg);
                }
            }
        });
    }
});

/*================== resend confirmation link ====================*/
$("#resend-email").validate({
    rules: {email: {required: true, email: true}},
    messages: {email: {required: "Please provide your email", email: "Please enter a valid email"}},
    submitHandler: function () {
        $("#msg").html("");
        var form = $("#resend-email").serialize();
        $.ajax({
            type: "POST",
            url: site_url + "/resend_email",
            data: form,
            dataType: 'json',
            cache: false,
            success: function (res) {
                if (res.error == 0) {
                    $("#msg").html(res.msg);
                } else if (res.error == 1) {
                    $("#msg").html(res.msg);
                }
            }
        });
    }
});