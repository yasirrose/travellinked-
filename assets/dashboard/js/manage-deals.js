$(document).ready(function(e) {

    var pathArray = location.href.split('/');

    var protocol = pathArray[0];

    var host = pathArray[2];

    var site_url = protocol + '//' + host + "/travellinked";


    $.ajax({

        url: site_url + "/admin/get_alarm_notification",
        type:"get",
        dataType:"json",
        success:function (data) {

            var json = data;
            var html= '';

            if(json == ''){

                html += ' <li> ' +
                    '<div class="list-group">    ' +
                    '                    <div class="media-box"> '+
                    '                    <div class="pull-left">' +
                    '                    </div>' +
                    '     <div class="media-box-body clearfix">' +
                    '                    <div class="media-box" style="text-align: center"><h5>No NOtifications</h5>' +
                    '                </div>' +
                    '                </div>' +
                    '                    </div>' +
                    '                    <!-- END list group-->' +
                    '                </li>';
            }
            $.each(json,function (index , value) {
                html += ' <li> ' +
                    '<div class="list-group">    ' +
                    '                <a href="/travellinked/admin/mute_notification/'+value.id+'" class="list-group-item">' +
                    '                    <div class="media-box">Hotel  '+ value.hotel_name +
                    '                    <div class="pull-left">' +
                    '                    </div>' +
                    '     <div class="media-box-body clearfix">' +
                    '                    <p class="m0">City '+ value.hotel_city +'</p>' +
                    '                    <div class="media-box">Ammount $  '+ value.total_ammount +
                    '                <p class="m0 text-muted">' +
                    '                    <small>'+ value.chekIn +'</small>' +
                    '                </p>' +
                    '                </div>' +
                    '                </div>' +
                    '                </a>' +
                    '                    </div>' +
                    '                    <!-- END list group-->' +
                    '                </li>';
            });


            $('#linkx').html(html);
        }

    });



    // /*=================== submit deal status form =================*/


    $('input[name=dealId]').on('click', function() {
        currForm = $(this).attr('id');
        $('input[name=dealId]').attr('disabled', 'disabled');

        $('.' + currForm).submit();

    });

    $('input[name=ApiId]').on('click', function() {


        currForm = $(this).attr('id');
        debugger;
        console.log(currForm)
        $('input[name=ApiId]').attr('disabled', 'disabled');

        $('.' + currForm).submit();

    });


    // id = currForm.replace('all','');
    // id = $('#ID' + id).val();
    // debugger;
    // window.location.href = "updateApistatus?id="+id;
    /*================== end submit deal status form =============*/



    /*=========== submit destination status form =================*/

    // $('input[name=destId]').on('click',function(event){

    // 	currForm = $(this).attr('id');

    // 	$('input[name=destId]').attr('disabled','disabled');

    // 	$('.'+currForm).submit();

    // });
    // function checkBoxVal(event) {
    //
    //     debugger;
    //     // currForm = $(this).attr('id');
    //     // $('input[name=destId]').attr('disabled', 'disabled');
    //     // $('.' + currForm).submit();
    //
    // }


    /*=========== end submit destination status form =============*/



    // $(document).on('click', '.close', function() {
    //
    //     $('div[role=alert]').fadeOut();
    //
    // });



    /*=================== initialize datepickers =================*/

    $("#startDate").datepicker({

        numberOfMonths: 1,

        dateFormat: 'mm/dd/yy',

        minDate: 0,

        firstDay: 0,

        inline: true,

    });

    $("#endDate").datepicker({

        numberOfMonths: 1,

        dateFormat: 'mm/dd/yy',

        minDate: 0,

        firstDay: 0,

        inline: true

    });

    $("#startDate").change(function() {

        var checkin = $(this).val();

        var checkin = $("#startDate").datepicker('getDate');

        checkin.setDate(checkin.getDate() + 1);

        var month = checkin.getMonth() + 1;

        var day = checkin.getDate();

        if (month < 10)

        {

            month = '0' + month;

        }

        if (day < 10)

        {

            day = '0' + day;

        }

        var Newdate = month + '/' + day + '/' + checkin.getFullYear();

        $("#endDate").val(Newdate);

    });

    $("#endDate").change(function() {

        var selectedDate1 = $("#startDate").datepicker('getDate');

        var selectedDate2 = $("#endDate").datepicker('getDate');

        if (selectedDate1 == null)

        {

            var Newdate = (selectedDate2.getMonth() + 1) + '/' + (selectedDate2.getDate() - 1) + '/' + selectedDate2.getFullYear();

            $("#startDate").val(Newdate);

            var selectedDate1 = $("#startDate").datepicker('getDate');

        }



        if (DateDiff(selectedDate1, selectedDate2) <= 0)

        {

            $("#endDate").addClass("error");

            $("#endDate").after('<label for="endDate" class="error">End date is less than start date</label>');

            var Newdate = (selectedDate1.getMonth() + 1) + '/' + (selectedDate1.getDate() + 1) + '/' + selectedDate1.getFullYear();

            $("#endDate").val(Newdate);

            var selectedDate2 = $("#endDate").datepicker('getDate');

        } else

        {

            $("#endDate").removeClass("error");

        }

    });

    function DateDiff(date1, date2)

    {

        var datediff = date2.getTime() - date1.getTime();

        var p = datediff / (24 * 60 * 60 * 1000);

        return (datediff / (24 * 60 * 60 * 1000));

    }

    /*=============== end initialize datepickers =================*/



    /*=================== populate autocomplete hotels ===========*/

    $(".search_hotel").keyup(function() {

        $('input[name=hotel_code]').val('');

        var value = $(this).val();

        var html = '';

        $.ajax({

            type: "GET",

            url: site_url + "/admin/getall_hotels",

            data: {

                name: value

            },

            dataType: 'json',

            cache: false,

            success: function(data) {

                var c = 0;

                var co = 0;

                $.each(data, function(i, value) {

                    $('.search_result').css("display", "block");

                    var count = c++;

                    html += "<span class='hotel-lable-" + count + "' style='display:none;'>Hotel</span>" +

                        "<option class='selected_value' name='hotel' id='" + value.hotelCode + "' value = '" + value.name + "'>" + value.name + "</option>";

                });

                $('.search_result').html(html);

            }

        });

    });

    $(document).on("click", ".selected_value", function() {

        var value = $(this).val();

        var id = $(this).attr("id");

        $(".search_hotel").val(value);

        $('input[name=hotel_code]').val(id);

        $('.search_result').hide();

    });

    $('body').click(function() {

        $('.search_result').hide();

    });

    /*=================== end populate autocomplete hotels =======*/



    /*=================== validate deals form ===================*/

    $('#upper-save').click(function() {

        $('#bottom-save').click();

    });

   /* $("#create-deal").validate({

        rules: {

            hotel_name: { required: true },

            deal_name: { required: true },

            start_date: { required: true },

            end_date: { required: true },

            deal_basedon: { required: true },

            deal_status: { required: true },

            deal_desc: { required: true }

        },

        messages: {

            hotel_name: { required: "Please select a hotel name" },

            deal_name: { required: "Please enter a deal name" },

            start_date: { required: "Please select a start date" },

            end_date: { required: "Please select a end date" },

            deal_basedon: { required: "Please select deal based on" },

            deal_status: { required: "Please select deal status" },

            deal_desc: { required: "Please enter deal description" }

        },

        submitHandler: function(form) {

            var flag = $("input[name=hotel_code]").val();

            if (flag !== '' && flag !== 'undefined')

            {

                $('input[name=hotel_name]').removeClass('error');

                form.submit();

            } else

            {

                $('input[name=hotel_name]').addClass('error');

                $('input[name=hotel_name]').after('<label for="hotel_name" class="error">Please select a hotel from dropdown list</label>');

            }

        }

    });*/

    /*=================== end validate deals form =================*/

    /*$(window).on("load", function() {

        $(".search-list-holder").mCustomScrollbar({

            axis: 'y',

            mouseWheel: true

        });

    });*/

});
function DealForm(id){
    var pathArray = location.href.split('/');

    var protocol = pathArray[0];

    var host = pathArray[2];

    var site_url = protocol + '//' + host + "/travellinked";


     $.ajax({

         url: site_url + "/admin/getupdatedealstatus/"+id,
         type:"get",

         success:function () {
            location.reload();
         }

      })


}