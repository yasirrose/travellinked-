$(window).load(function() {

    $(".grid_data").css("display", "block");

    $(".list_data").css("display", "none");

});

$(document).ready(function(e) {



    var destsCheker = false;

    var requestFlag = true;

    var filterFlag = false;

    var sorterFlag = ".recommended";

    var lastIndex = 0;

    var preValRooms = 0;

    var preValRooms1 = 0;

    var identity = "";

    var dests = [];

    var facs = [];

    var stars = [];

    var currCalendar = '';

    var totalDeals = $('#totalDeals').val();

    /*====== header script here =========*/

    var pathArray = location.href.split('/');

    var protocol = pathArray[0];

    var host = pathArray[2];

    var site_url = protocol + '//' + host + "/travellinked";

    strUrl = location.href;

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

    /*====================== home page search box script here ======================*/

    currentDate = '';

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

                $('#error_datePicker').css('display', 'none');


                document.getElementById("nights").value= DateDiff(s1,overWrite);

            }

            else

            {

                $("#datepicker_in").val(s1);

                $("#datepicker_out").val(s2);

                $('#error_datePicker').css('display', 'none');


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

    $(".search_hotel").keyup(function(){

        $("#input_hotel").val("");
        $("#locName").removeClass("error");
// $('#error_locName').css('display', 'none');

        var value = $(this).val();



        var html = "";
        if(value.length>1){
            $.ajax({

                type : "GET",

                url : site_url + "/search_hotels",

                data : {

                    name : value

                },

                dataType : 'json',

                cache : false,

                async:true,

                success : function(data) {

                    var c = 0;

                    var co = 0;

                    $.each(data, function(i, value) {

                        $('.search_result').css("display", "block");

                        if(value.hotelgroupname){

                            html += "<span class='location-lable-"+i+"' style='display:none;'>Location</span>"+

                                "<label class='selected_value' name='hotelgroupname' id='"+value.hotelgroupcode+"' value = '"+value.hotelgroupname+"'>" +value.hotelgroupname +"</label>";

                        }

                        if(value.city){

                            html += "<span class='city-lable-"+co+"' style='display:none;'>City</span>"+

                                "<label class='selected_value' name='city' id ='"+value.cityCode+"' value = '"+value.city+"'>" +value.city +"</label>";

                            co++;

                        }if(value.name){



                            var count = c++;

                            html += "<span class='hotel-lable-"+count+"' style='display:none;'>Hotel</span>"+

                                "<label class='selected_value' name='hotel' id='"+value.hotelCode+"' value = '"+value.name+"'>" +value.name +" (Hotel)</label>";



                        }



                    });

                    $('.search_result').html(html);



                }

            });
        }
    });




    $(document).on("click", ".selected_value", function(){

        var value = $(this).text();

        var id = $(this).attr("id");

        var name = $(this).attr("name");

        $(".search_hotel").val(value);

        $("#input_hotel").val(id);

        $("#stype").val(name);

        $('.search_result').hide();

    });



    $(document).on('change','.control-field',function(event){

        var currName = $(this).attr('id');

        var pattern = /(adultmain-)[1-5]/g;

        var pattern1 = /(childmain_)[1-5](_ages_)[1-8]/g;

        var pattern2 = /(adultsticky-)[1-5]/g;

        var pattern3 = /(childsticky_)[1-5](_ages_)[1-8]/g;

        var pattern4 = /(total_child_sticky)[1-5]/g;

        if(pattern.test(currName) == true)

        {

            if($(this).val() > 0)

            {

                $(this).removeClass('error');

            }

        }

        else if(pattern1.test(currName) == true)

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

        else if(pattern2.test(currName) == true)

        {

            if($(this).val() > 0)

            {

                $(this).removeClass('error');

            }

            var totalChild = calculate_children_main('#rooms_change','.horiz-child');
            console.log(totalChild);
            var totalAdult = calculate_adults_main('#rooms_change','.adults-sticky');

            var result = $('#rooms_change').val()+' rooms, '+(totalAdult+totalChild)+' guests';

            $('#adultsChildSticky').val(result);

        }

        else if(pattern3.test(currName) == true)

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

        else if(pattern4.test(currName) == true)

        {

            var totalChild = calculate_children_main('#rooms_change','.horiz-child');

            var totalAdult = calculate_adults_main('#rooms_change','.adults-sticky');

            var result = $('#rooms_change').val()+' rooms, '+(totalAdult+totalChild)+' guests';

            $('#adultsChildSticky').val(result);

        }

    });



    $(".search-form").validate({

        rules: {

            location_name:{

                required:true

            },

            checkin: "required",

            checkout: "required"

        },

        showErrors: function(errorMap, errorList) {

            var i = errorList.length;

            if(i>=1){
                var mainError = errorList[0];
                if(mainError.element.id=='locName'){
                    var data = document.getElementById(mainError.element.id).value;

                    if(data==''){
                        $('#error_locName').addClass('fade');
                        $("#locName").addClass('error');

                        console.log('ID '+mainError.element.id +' ' +mainError.message);
                    }
                    for(i = 0; i<errorList.length; i++){
                        $("#"+ errorList[i].element.id).addClass("error");
                    }
                }
                else{

                    // $("#"+mainError.element.id).addClass("error");

                    //  $('#error_datePicker').css('display', 'block');

                    // console.log('handle date picker');
                }
            }
            else{

                $('#error_datePicker').css('display', 'none');
                // $('#error_locName').css('display', 'none');
                $("#locName").removeClass("error");
                $("#locName").addClass("valid");

                // $("#"+mainError.element.id).removeClass("error");

            }

        },


        messages: {

            location_name:{required:"This field is required"},

            checkin: "This field is required",

            checkout:"This field is required"

        },

        submitHandler: function(form) {

            var errorFlag = 0;

            var rooms;

            rooms = $("#rooms_count").val();

            for(var i = 1; i<= rooms; i++){

                var val = $("#adultmain-"+i).val();

                var childVal = $("select[id=total_child_main"+i+"]").val();

                if(val == 0)

                {

                    $("#adultmain-"+i).addClass("error");

                    $("#adultmain-"+i).after('<label class="error">Please fill this field</label>');

                    errorFlag = errorFlag+1;

                }

                else

                {

                    if($("#adultmain-"+i).next()[0].localName == 'label')

                    {

                        $("#adultmain-"+i).next().remove();

                    }

                    if(childVal > 0)

                    {

                        for(var j = 1; j<= childVal; j++)

                        {

                            var curChildVal = $("select[id=childmain_"+i+"_ages_"+j+"]").val();

                            if(curChildVal == 0)

                            {

                                $("select[id=childmain_"+i+"_ages_"+j+"]").addClass("error");

                                $("select[id=childmain_"+i+"_ages_"+j+"]").after('<label class="error">Please fill this field</label>');

                                errorFlag = errorFlag+1;

                            }

                            else

                            {

                                if($("select[id=childmain_"+i+"_ages_"+j+"]").next()[0].localName == 'label')

                                {

                                    $("select[id=childmain_"+i+"_ages_"+j+"]").next().remove();

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

        }

    });

    /*====================== end home page search box script here ======================*/



    /*====================== sticky header search box script here ======================*/

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

                document.getElementById("nightsSticky").value= DateDiff(s1,overWrite);
                // $("#"+mainError.element.id).removeClass("error");

                $('#error_datePicker').css('display', 'none');
            }

            else

            {

                $("#datepicker_in_sticky").val(s1);
                $("#datepicker_out_sticky").val(s2);
                document.getElementById("nightsSticky").value= DateDiff(s1,s2);
                // $("#"+mainError.element.id).removeClass("error");
                $('#error_datePicker').css('display', 'none');
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

            $("#nightsSticky").val('');

            $(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

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

                $("#nightsSticky").val('');

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

            overWrite = (overWrite.getMonth() + 1) + '/' + (overWrite.getDate()) + '/' +  overWrite.getFullYear();

            overWrite.setDate(overWrite.getDate() + 1);

            $(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

            $(".datepicker_in_sticky").data('dateRangePicker').setEnd(overWrite,true);

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

            $('.datepicker-container-sticky').slideUp();

            setQueryStrings();
            $('.sticky_tooltip_in').css('display','none');

            $('.sticky_tooltip_out').css('display','none');

            currCalendar = '';

        }

        else

        {

            $(".datepicker_in_sticky").data('dateRangePicker').setStart(startDate);

            $(".datepicker_in_sticky").data('dateRangePicker').setEnd(endDate,true);

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

            $('.datepicker-container-sticky').slideUp();
            setQueryStrings();
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

    /*========= set selected date range on page load =========*/

    if(strUrl.search("/search") !== -1 || strUrl.search("/changeSearch") !== -1 || strUrl.search("/deals") !== -1

        || strUrl.search("/rooms") !== -1 || strUrl.search("/thankYou") !== -1 || strUrl.search("/destinations") !== -1

        || strUrl.search("/cities") !== -1 || strUrl.search("/no/inventory") !== -1)

    {

        onLoadCheckInSticky = $("#datepicker_in_sticky").val();

        onLoadCheckOutSticky = $("#datepicker_out_sticky").val();

        $(".datepicker_in_sticky").data('dateRangePicker').setStart(onLoadCheckInSticky);

        $(".datepicker_in_sticky").data('dateRangePicker').setEnd(onLoadCheckOutSticky,true);

        $("#datepicker_in_sticky").val(onLoadCheckInSticky);

        $("#datepicker_out_sticky").val(onLoadCheckOutSticky);

        $(".search_hotel_sticky").addClass('valid');

        $("#datepicker_in_sticky").addClass('valid');

        $("#datepicker_out_sticky").addClass('valid');

    }

    $(document).on('click','#clearDates',function(){

        $(".datepicker_in_sticky").data('dateRangePicker').clear();

    });

    /*===== end set selected date range on page load =========*/

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

            async:true,

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



    $(".sticky-form").validate({

        rules: {

            location_name:{

                required:true

            },

            checkin: "required",

            checkout: "required"

        },

        messages: {

            location_name:{required:"This field is required"},

            checkin: "This field is required",

            checkout:"This field is required"

        },
        showErrors: function(errorMap, errorList) {

            var i = errorList.length;
            if(i>=1){
                var mainError = errorList[0];
                if(mainError.element.name=='location_name'){
                    var data = $('input[name='+mainError.element.name+']').val();
                    if(data==''){
                        $("input[name=location_name]").addClass("error");
                        $('#error_location_name').css('display', 'block');
                        console.log('ID '+mainError.element.id +' ' +mainError.message);
                    }
                    for(i = 0; i<errorList.length; i++){
                        $("input[name="+ errorList[i].element.name+"]").addClass("error");
                    }
                }
                else{
                    // $("#"+mainError.element.id).addClass("error");

                    $('#error_datePicker2').css('display', 'block');

                    // console.log('handle date picker');
                }
            }
            else{
                $('#error_datePicker2').css('display', 'none');
                $('#error_location_name').css('display', 'none');
                $("input[name=location_name]").removeClass("error");
                $("#location_name").addClass("valid");

                // $("#"+mainError.element.id).removeClass("error");

            }

        },
        highlight: function(element, errorClass, validClass){

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



    /*$('.top_deal_offerbox:first').addClass('current');

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

     });*/



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





    /*$(window).bind("pageshow", function() {

     $(".search-loader").css("display","none");

     var page = window.location.pathname;

     if(page == "/travellinked/"){

     $(".search-form")[0].reset();

     }

     });*/





    $(window).click(function (event) {

        $('.search_result').hide();

        $('.search_result_sticky').hide();

        if($(event.target)[0].id !== 'datepicker_in' && $(event.target)[0].id !== 'datepicker_out')

        {

            $('.datepicker-container').slideUp('slow',function(){

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



    /********************** script for searech page filters **************************/

    $("#nameTags").ready(function(){

        $.ajax({

            type : "GET",

            url : site_url + "/hotelNames",

            dataType : 'json',

            cache : false,

            success : function(data){

                $( "#nameTags" ).autocomplete({

                    source: data,

                    create: function( event, ui ) {

                        $("ul.ui-autocomplete.ui-menu,.ui-autocomplete li").css({"background":"lightgrey","font-size":"12px","width":"228px","color":"black"});

                    },

                    select: function( event, ui ) {

                        getSelectedFilters();

                        tickMarkSelectedFilters();

                        facsParam = facs;

                        starsParam = stars;

                        destsParam = dests;

                        if(facs.length == 0){

                            facsParam = 0;

                        }

                        if(stars.length == 0){

                            starsParam = 0;

                        }

                        if(dests.length == 0){

                            destsParam = 0;

                        }

                        var selVal = ui.item.value;

                        $(".recommended").removeClass("inactive");

                        var t = $(".recommended").attr('href');

                        $('.tab-container').hide();

                        $(t).show();



                        $(".price").addClass("inactive");

                        $(".stars").addClass("inactive");

                        $(".hotels").addClass("inactive");

                        $(".vacation").addClass("inactive");

                        $(".overlay").show();

                        $.ajax({

                            type : "GET",

                            url : site_url + "/filterByHotelName",

                            data : {hotel : selVal,price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

                            dataType : 'json',

                            cache : false,

                            success : function(data){

                                tickMarkSelectedFilters();

                                $(".overlay").hide();

                                $(".filter-data").html(data);

                            }

                        });

                    }

                });

            }

        });

    });

    $(".recommended").click(function(){

        sorterFlag = '.recommended';

    });

    $(".sortByPrice").click(function(){

        sorterFlag = '.sortByPrice';

        var check = $(".sort_price .check-price").text();

        $(".overlay").show();

        getSelectedFilters();

        tickMarkSelectedFilters();

        facsParam = facs;

        starsParam = stars;

        destsParam = dests;

        if(facs.length == 0){

            facsParam = 0;

        }

        if(stars.length == 0){

            starsParam = 0;

        }

        if(dests.length == 0){

            destsParam = 0;

        }

        $.ajax({

            type : "GET",

            url : site_url + "/sortByPrice",

            data:{price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

            dataType : 'json',

            cache : false,

            success : function(data){

                tickMarkSelectedFilters();

                $(".overlay").hide();

                $(".sort_price").html(data);

            }

        });



    });



    $(".stars").click(function(){

        sorterFlag = '.stars';

        $(".overlay").show();

        getSelectedFilters();

        tickMarkSelectedFilters();

        facsParam = facs;

        starsParam = stars;

        destsParam = dests;

        if(facs.length == 0){

            facsParam = 0;

        }

        if(stars.length == 0){

            starsParam = 0;

        }

        if(dests.length == 0){

            destsParam = 0;

        }

        $.ajax({

            type : "GET",

            url : site_url + "/sortByStars",

            dataType : 'json',

            data:{price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

            cache : false,

            success : function(data){

                tickMarkSelectedFilters();

                $(".overlay").hide();

                $(".sort_star").html(data);

            }

        });

    });





    $(".hotels").click(function(){

        sorterFlag = '.hotels';

        $(".overlay").show();

        getSelectedFilters();

        tickMarkSelectedFilters();

        facsParam = facs;

        starsParam = stars;

        destsParam = dests;

        if(facs.length == 0){

            facsParam = 0;

        }

        if(stars.length == 0){

            starsParam = 0;

        }

        if(dests.length == 0){

            destsParam = 0;

        }

        $.ajax({

            type : "GET",

            url : site_url + "/sortByHotelNames",

            dataType : 'json',

            data:{price:$("#amount").val()},

            cache : false,

            success : function(data){

                tickMarkSelectedFilters();

                $(".overlay").hide();

                $(".sort_hotels").html(data);

            }

        });

    });



    $(document).on("change",".star-filter",function(){

        $(".overlay").show();

        lastIndex = 0;

        getSelectedFilters();

        tickMarkSelectedFilters();

        facsParam = facs;

        starsParam = stars;

        destsParam = dests;

        if(facs.length == 0){

            facsParam = 0;

        }

        if(stars.length == 0){

            starsParam = 0;

        }

        if(dests.length == 0){

            destsParam = 0;

        }

        $.ajax({

            type : "GET",

            url : site_url + "/hotelImages", //filterHotels

            dataType : 'json',

            data:{price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

            cache : false,

            success : function(data){

                tickMarkSelectedFilters();

                $(".overlay").hide();

                if(data.msg == "")

                {

                    lastIndex = totalDeals;

                    $(".filter-data").html('<h3>No record found</h3>');

                }

                else

                {

                    lastIndex = data.lastindex;

                    $(".filter-data").html(data.msg);

                }

            }

        });



    });





    $(document).on("change","#common-srch",function(){

        lastIndex = 0;

        if($(this).prop('checked') === true){

            $('.fac-filter').each(function(i){

                $(this).prop('checked',true);

            });

        }else{

            $('.fac-filter').each(function(i){

                $(this).prop('checked',false);

            });

        }



    });

    /*==== End Filter by stars========*/

    $(document).on("change",".fac-filter",function(){

        var curId = $(this).attr('id');

        $(".overlay").show();

        lastIndex = 0;

        getSelectedFilters();

        tickMarkSelectedFilters();

        facsParam = facs;

        starsParam = stars;

        destsParam = dests;

        if(facs.length == 0){

            facsParam = 0;

        }

        if(stars.length == 0){

            starsParam = 0;

        }

        if(dests.length == 0){

            destsParam = 0;

        }

        $.ajax({

            type : "GET",

            url : site_url + "/hotelImages",//filterHotels

            dataType : 'json',

            data:{price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

            cache : false,

            success : function(data){

                tickMarkSelectedFilters();

                $(".overlay").hide();

                if(data.msg == "")

                {

                    lastIndex = totalDeals;

                    $(".filter-data").html('<h3>No records found</h3>');

                }

                else

                {

                    lastIndex = data.lastindex;

                    $(".filter-data").html(data.msg);

                }

            }

        });

    });

    /*==== End Filter by amenities ========*/



    /*==== Ui Amount Slider for filter=====*/
    $( "#slider-range" ).slider({

        range: true,

        min: parseInt($('#minPrice').attr('class')),

        max: $('#maxPrice').attr('class'),

        values: [parseInt($('#minPrice').attr('class')),$('#maxPrice').attr('class')],

        slide: function( event, ui ) {


            $("#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );

        },

        change: function(event, ui) {

            $(".overlay").show();

            getSelectedFilters();

            tickMarkSelectedFilters();

            facsParam = facs;

            starsParam = stars;

            destsParam = dests;

            if(facs.length == 0){

                facsParam = 0;

            }

            if(stars.length == 0){

                starsParam = 0;

            }

            if(dests.length == 0){

                destsParam = 0;

            }

            $.ajax({

                type : "GET",

                url : site_url + "/filterByPrice", //FilterByslider

                data : {price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

                dataType : 'json',

                cache : false,

                success : function(data) {

                    tickMarkSelectedFilters();

                    $(".overlay").hide();

                    $(".filter-data").html(data);

                }

            });

        }

    });

    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +

        "-" + $( "#slider-range" ).slider( "values", 1 ));



    /*==== End Ui Slider=====*/



    /*======== Login pop up ====*/

    $(".login-link").click(function () {

        $("body").addClass("popup-open");

        $(".login-popup").addClass("open");

    });

    $(".close-btn").click(function () {

        $("body").removeClass("popup-open");

        $(".login-popup, .signup-popup, .forgot-popup, .reset-popup").removeClass("open");

    });

    $(".signup-link").click(function () {

        $("body").addClass("popup-open");

        $(".signup-popup").addClass("open");

    });

    $(".signup-to-login").click(function () {

        $(".signup-popup").removeClass("open");

        $(".login-popup").addClass("open");

    });

    $(".login-to-signup").click(function () {

        $(".login-popup").removeClass("open");

        $(".signup-popup").addClass("open");

    });

    $(".login-to-forgot").click(function () {

        $(".login-popup").removeClass("open");

        $(".forgot-popup").addClass("open");

    });

    /*========End Login pop up ====*/

    if(strUrl.search("/search") !== -1 || strUrl.search("/changeSearch") !== -1 || strUrl.search("/destinations") !== -1

        || strUrl.search("/cities") !== -1)

    {

        /*=========== get facilities ============*/

        requestFlag = false;

        $.ajax({

            type : "GET",

            url : site_url + "/hotelFacs",

            dataType : 'json',

            cache : false,

            async:true,

            success : function(data){

                $('#Facilities').html(data);

                var  size_facs = $(".outer-fac-filter").size();

                x=6;

                $('.outer-fac-filter:lt('+x+')').fadeIn();

                $("#more-facs").show();

                requestFlag = true;

                if(requestFlag === true)

                {

                    requestFlag = false;

                    checkAllFilters();

                    getSelectedFilters();

                    tickMarkSelectedFilters();

                    facsParam = facs;

                    starsParam = stars;

                    destsParam = dests;

                    if(facs.length == 0){

                        facsParam = 0;

                    }

                    if(stars.length == 0){

                        starsParam = 0;

                    }

                    if(dests.length == 0){

                        destsParam = 0;

                    }

                    $.ajax({

                        type : "GET",

                        url : site_url + "/hotelImages",

                        data:{price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

                        dataType : 'json',

                        cache : false,

                        async:false,

                        success : function(data){

                            var classCount = $('.'+data.identity).length;

                            if(classCount <= 0)

                            {

                                $(".filter-data").html(data.msg);

                                requestFlag = true;

                                lastIndex = data.lastindex;

                                tickMarkSelectedFilters();

                            }

                            else

                            {

                                $(".filter-data").append(data.msg);

                                requestFlag = true;

                                lastIndex = data.lastindex;

                                tickMarkSelectedFilters();

                            }

                            $(".search-loader").hide();

                        }

                    });

                }

            }

        });

        /*=========== get facilities ============*/

        $(document).scroll(function() {

            if ($(window).scrollTop()+1 >= $(document).height() - $(window).height()) {

                if(requestFlag === true)

                {

                    requestFlag = false;

                    getSelectedFilters();

                    tickMarkSelectedFilters();

                    facsParam = facs;

                    starsParam = stars;

                    destsParam = dests;

                    if(facs.length == 0){

                        facsParam = 0;

                    }

                    if(stars.length == 0){

                        starsParam = 0;

                    }

                    if(dests.length == 0){

                        destsParam = 0;

                    }

                    if(lastIndex < totalDeals)

                    {

                        ShowProgress();

                        $.ajax({

                            type : "GET",

                            url : site_url + "/hotelImages",

                            data:{price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

                            dataType : 'json',

                            cache : false,

                            async:true,

                            success : function(data){

                                if(data.error == 1)

                                {

                                    var classCount = $('.'+data.identity).length;

                                    lastIndex = totalDeals;

                                    if(classCount == 0)

                                    {

                                        $(".filter-data").html('<h3>No records found</h3>');

                                    }

                                    else

                                    {

                                        $("#textMsg").html("No more items to load!");

                                    }

                                    tickMarkSelectedFilters();

                                }

                                else if(data.error == 0)

                                {

                                    var classCount = $('.'+data.identity).length;

                                    lastIndex = data.lastindex;

                                    if(classCount <= 0)

                                    {

                                        if(sorterFlag == '.recommended')

                                        {

                                            $(".filter-data").html(data.msg);

                                            tickMarkSelectedFilters();

                                        }

                                        else

                                        {

                                            if(sorterFlag == '.sortByPrice')

                                            {

                                                getFlagResults('.sort_price','/sortByPrice');

                                            }

                                            else if(sorterFlag == '.stars')

                                            {

                                                getFlagResults('.sort_star','/sortByStars');

                                            }

                                            else if(sorterFlag == '.hotels')

                                            {

                                                getFlagResults('.sort_hotels','/sortByHotelNames');

                                            }

                                        }

                                    }

                                    else

                                    {

                                        if(sorterFlag == '.recommended')

                                        {

                                            $(".filter-data").append(data.msg);

                                            tickMarkSelectedFilters();

                                        }

                                        else

                                        {

                                            if(sorterFlag == '.sortByPrice')

                                            {

                                                getFlagResults('.sort_price','/sortByPrice');

                                            }

                                            else if(sorterFlag == '.stars')

                                            {

                                                getFlagResults('.sort_star','/sortByStars');

                                            }

                                            else if(sorterFlag == '.hotels')

                                            {

                                                getFlagResults('.sort_hotels','/sortByHotelNames');

                                            }

                                        }

                                    }

                                }

                            }

                        }).done(function(){

                            HideProgress();

                            requestFlag = true;

                        });

                    }

                    else

                    {

                        requestFlag = true;

                    }

                }

            }

        });



        function getFlagResults(appendClass,urlSegment)

        {

            getSelectedFilters();

            tickMarkSelectedFilters();

            facsParam = facs;

            starsParam = stars;

            destsParam = dests;

            if(facs.length == 0){

                facsParam = 0;

            }

            if(stars.length == 0){

                starsParam = 0;

            }

            if(dests.length == 0){

                destsParam = 0;

            }

            $.ajax({

                type : "GET",

                url : site_url+urlSegment,

                data:{price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

                dataType : 'json',

                cache : false,

                success : function(data){

                    tickMarkSelectedFilters();

                    $(appendClass).html(data);

                    HideProgress();

                    requestFlag = true;

                }

            });

        }

        function HideProgress(){

            $('#infscr-loading').hide();

        }



        function ShowProgress(){

            $('#infscr-loading').show();

            $("#textMsg").html("loading more items!");

        }



        $(document).on('click','.sidebar-content ul li',function(event){

            var currFilterBox = $(this).children().find('input[type=checkbox]');

            if($(event.target)[0].className == 'fac-filter' || $(event.target)[0].className == 'star-filter'

                || $(event.target)[0].className == 'dest-filters common-dest')

            {

                if($(currFilterBox).length == 1)

                {

                    if($(currFilterBox).prop('checked') == true)

                    {

                        $(this).prop('checked',false);

                    }

                    else

                    {

                        $(this).prop('checked',true);

                    }

                }

            }

            else

            {

                console.log($(currFilterBox));

                if($(currFilterBox).length == 1)

                {

                    $(currFilterBox).click();

                }

            }

        });



    }

    function getSelectedFilters()

    {

        starElems   = $('.star-filter');

        facElems 	= $('.fac-filter');

        destElems   = $(".dest-count li").length;



        /*================= this script is to manage filter by area ======================*/

        dests = [];

        facs = [];

        stars = [];

        filterFlag = false;



        $(".dest-count li").find("input").each(function(i, val){

            if($(this).prop("checked") === true)

            {

                $(this).prop("checked",true);

                dests.push($(this).attr('id'));

                filterFlag = true;

            }

            else

            {

                $(this).prop("checked",false);

            }

        });

        /*================= Ens script to manage filter by area ======================*/



        for(i = 0; i< starElems.length; i++)

        {

            if($(starElems[i]).prop('checked'))

            {

                $(starElems[i]).prop("checked",true);

                stars.push($(starElems[i]).val());

                filterFlag = true;

            }

            else

            {

                $(starElems[i]).prop("checked",true);

            }

        }

        for(i = 0; i< facElems.length; i++)

        {

            if($(facElems[i]).prop('checked'))

            {

                $(facElems[i]).prop("checked",true);

                facs.push($(facElems[i]).attr('id'));

                filterFlag = true;

            }

            else

            {

                $(facElems[i]).prop("checked",false);

            }

        }

    }

    function tickMarkSelectedFilters()

    {

        starElems   = $('.star-filter');

        facElems 	= $('.fac-filter').not('#common-srch');

        /*================= this script is to manage filter by area ======================*/

        $(".dest-count li").find("input").each(function(i, val){

            var curElem = $(this).attr('id');

            var curFlag = 0;

            for(j = 0; j<dests.length; j++)

            {

                if(curElem === dests[j])

                {

                    curFlag = curFlag+1;

                    break;

                }

            }

            if(curFlag > 0)

            {

                $(this).prop('checked',true);

            }

            else

            {

                $(this).prop('checked',false);

            }

        });

        /*================= this script is to manage filter by area ======================*/



        for(i = 0; i< starElems.length; i++)

        {

            var curElem = $(starElems[i]).val();

            var curFlag = 0;

            for(k = 0; k<stars.length; k++)

            {

                if(curElem === stars[k])

                {

                    curFlag = curFlag+1;

                    break;

                }

            }

            if(curFlag > 0)

            {

                $(starElems[i]).prop('checked',true);

            }

            else

            {

                $(starElems[i]).prop('checked',false);

            }

        }

        facCount = 0;

        for(i = 0; i< facElems.length; i++)

        {

            var curElem = $(facElems[i]).attr('id');

            var curFlag = 0;

            for(l = 0; l<facs.length; l++)

            {

                if(curElem === facs[l])

                {

                    curFlag = curFlag+1;

                    break;

                }

            }

            if(curFlag > 0)

            {

                $(facElems[i]).prop('checked',true);

                facCount = facCount+1;

            }

            else

            {

                $(facElems[i]).prop('checked',false);

            }

        }

        if(facCount === facElems.length)

        {

            $('#common-srch').prop('checked',true);

        }

        else

        {

            $('#common-srch').prop('checked',false);

        }

    }

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

    function checkAllFilters()

    {

        starElems   = $('.star-filter');

        facElems 	= $('.fac-filter');

        destElems   = $(".dest-count li").length;



        /*================= this script is to manage filter by area ======================*/

        dests = [];

        facs = [];

        stars = [];

        filterFlag = false;



        $(".dest-count li").find("input").each(function(i, val){

            $(this).prop("checked",true);

            dests.push($(this).attr('id'));

        });

        /*================= Ens script to manage filter by area ======================*/

        for(i = 0; i< starElems.length; i++)

        {

            $(starElems[i]).prop("checked",true);

            stars.push($(starElems[i]).val());

        }

        for(i = 0; i< facElems.length; i++)

        {

            $(facElems[i]).prop("checked",true);

            facs.push($(facElems[i]).attr('id'));

        }

        filterFlag = true;

    }

    /*============script for filter by area=================*/

    $(document).on("change",".allDesFilter",function(){

        $(".overlay").show();

        if($(this).prop('checked') === true)

        {

            $('.dest-filters').each(function(i){

                $(this).prop('checked',true);

            });

        }

        else

        {

            $('.dest-filters').each(function(i){

                $(this).prop('checked',false);

            });

        }

        lastIndex = 0;

        getSelectedFilters();

        tickMarkSelectedFilters();

        facsParam = facs;

        starsParam = stars;

        destsParam = dests;

        if(facs.length == 0){

            facsParam = 0;

        }

        if(stars.length == 0){

            starsParam = 0;

        }

        if(dests.length == 0){

            destsParam = 0;

        }

        var value = $(".allDesFilter").attr("id");

        $.ajax({

            type : "GET",

            url : site_url + "/hotelImages", //destination

            data : {price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam},

            dataType : 'json',

            async:true,

            cache : false,

            success : function(response){


                tickMarkSelecetedFilters();

                // console.log(tickMarkSelecetedFilters());
                $(".overlay").hide();

                // $(".overlay").show();

                if(response.msg == "")

                {

                    lastIndex = totalDeals;

                    $(".filter-data").html('<h3>No record found</h3>');

                }

                else

                {

                    lastIndex = response.lastindex;

                    $(".filter-data").html(response.msg);

                }

            }

        });

    });



    $(document).on("click",".dest-filters",function(){
        debugger

        $(".overlay").show();

        lastIndex = 0;

        var chekStatus = false;

        $(".allDesFilter").prop('checked',false);

        $('.dest-filters').each(function(i){

            if($(this).prop('checked') === true){

                chekStatus = true;

            }

        });

        getSelectedFilters();

        tickMarkSelectedFilters();

        facsParam = facs;

        starsParam = stars;

        destsParam = dests;

        if(facs.length == 0){

            facsParam = 0;

        }

        if(stars.length == 0){

            starsParam = 0;

        }

        if(dests.length == 0){

            destsParam = 0;

        }

        var value = $(".allDesFilter").attr("id");

        var check = $(this).attr("data-link");

        $.ajax({

            type : "GET",

            url : site_url + "/hotelImages", //destination

            data : {
                price:$("#amount").val(),filters:filterFlag,facss:facsParam,destss:destsParam,starss:starsParam
            },

            dataType : 'json',

            async:true,

            cache : false,

            success : function(response){

                tickMarkSelectedFilters();

                $(".overlay").hide();

                if(response.msg == "")

                {

                    lastIndex = totalDeals;

                    $(".filter-data").html('<h3>No record found</h3>');

                }

                else

                {

                    lastIndex = response.lastindex;

                    $(".filter-data").html(response.msg);

                }

            }

        });

    });



    /*============ End script for filter by area=================*/

    /*=========script for load more facilities =================*/

    $(document).on('click','#more-facs',function (){

        var  size_facs = $(".outer-fac-filter").size();

        console.log(size_facs);

        x = size_facs;

        $('.outer-fac-filter:lt('+x+')').fadeIn();

        if(size_facs == x){

            $("#more-facs").hide();

            $("#less-facs").show();

        }

    });



    $(document).on('click','#less-facs',function (){

        x = 6;

        $('.outer-fac-filter').hide();

        $('.outer-fac-filter:lt('+x+')').fadeIn();

        $("#less-facs").hide();

        $("#more-facs").show();

    });

    /*=========End script for load more room page left sidebar tabs===========*/

    /*========= script for displaying home page search box rooms =============*/

    $(document).on('change','#rooms_count',function(event){

        var horizVal = $(this).val();

        if(preValRooms === 0)

        {

            preValRooms = horizVal;

            $('.search-engine-row-display-hide:lt('+horizVal+')').slideDown(500);

        }

        else

        {

            if(preValRooms < horizVal)

            {

                preValRooms = horizVal;

                $('.search-engine-row-display-hide:lt('+horizVal+')').slideDown(500);

            }

            else if(preValRooms >= horizVal)

            {

                preValRooms = horizVal;

                $('.search-engine-row-display-hide:gt('+(horizVal-1)+')').slideUp(500);

            }

        }

        //$('.search-engine-row-display-hide').css('display','none');

        /*$('.search-engine-row-display-hide:lt('+horizVal+')').css('display','block');*/

    });



    $(document).on('change','.search-engine-child',function(event){

        var horizClass = $(this).attr('id');

        horizClass = horizClass+'_ages';

        var horizVal = $(this).val();

        if(horizVal > 0)

        {

            selElems = $('.'+horizClass).find("select");

            //$('.'+horizClass).css('display','block');

            $('.'+horizClass).slideDown(500);

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

            //$('.'+horizClass).css('display','none');

            $('.'+horizClass).find("select").attr('disabled','disabled');

            $('.'+horizClass).slideUp(500);

        }

    });

    /*========= End script for displaying home page search box rooms ========*/



    /*========= script for displaying horizontal search box =================*/

    $(document).on('click',function(event){

        parent1 = "",parent2 = "",parent3 = "",parent4 = "",parent5 = ""

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

                parent4 !== 'engine-dropdown-row' && current !== 'engine-dropdown-row' && current !== 'engine-dropdown-btns' &&

                parent5 !== 'engine-dropdown-row' && current !== 'btn-addrow' && current !== 'btn-cnfrm')

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

            preValRooms1 = roomValNew;

            //$('.engine-dropdown-row:lt('+roomValNew+')').css('display','block');

            $('.engine-dropdown-row:lt('+roomValNew+')').slideDown(500);

            var newVal = $('#rooms_change').val(roomValNew);

            var totalChild = calculate_children_main('#rooms_change','.horiz-child');

            var totalAdult = calculate_adults_main('#rooms_change','.adults-sticky');



            var result = $('#rooms_change').val()+' rooms, '+(totalAdult+totalChild)+' guests';

            $('#adultsChildSticky').val(result);

        }

    });


    $(document).on('change','.adults-sticky',function(event){

        var currName = $(this).attr('name');

        $('select[name='+currName+']').val($(this).val());

        var totalChild = calculate_children('#rooms_change','.horiz-child');

        var totalAdult = calculate_adults_main('#rooms_change','.adults-sticky');
        var rooms = $('#rooms_change').val();
        // console.log(rooms);
        var result = rooms + 'rooms, '+(totalAdult+totalChild)+' guests';
        // console.log(result);
        $('#adultsChildSticky').val(result);

        // $('#adultChildSumRooms').val(result);

        setQueryStrings();

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

        }

        else

        {

            if(preValRooms1 < horizVal)

            {

                preValRooms1 = horizVal;

                $('.engine-dropdown-row:not(.engine-dropdown-row-rooms):lt('+horizVal+')').slideDown(500);

            }

            else if(preValRooms1 >= horizVal)

            {

                preValRooms1 = horizVal;

                $('.engine-dropdown-row:not(.engine-dropdown-row-rooms):gt('+(horizVal-1)+')').slideUp(500);

            }

        }

        var totalChild = calculate_children_main('#rooms_change','.horiz-child');

        var totalAdult = calculate_adults_main('#rooms_change','.adults-sticky');

        var result = $('#rooms_change').val()+' rooms, '+(totalAdult+totalChild)+' guests';

        $('#adultsChildSticky').val(result);

        //$('.engine-dropdown-row').css('display','none');

        //$('.engine-dropdown-row:lt('+horizVal+')').css('display','block');

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
        console.log(totalChild);
        var totalAdult = calculate_adults_main('#rooms_change','.adults-sticky');

        var result = $('#rooms_change').val()+' rooms, '+(totalAdult+totalChild)+' guests';

        $('#adultsChildSticky').val(result);

        $('#adultChildSumRooms').val(result);

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

    function calculate_children_main(roomsClass,childClass)

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

    function calculate_adults_main(roomsClass,adultClass)

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



    /*========= Script for displaying toggle hotel list on destination box ========*/

    $(".m-titlenav-h").click(function(){

        $(this).parent(".m-titlenav").toggleClass("active");

    });

    /*==== end script for displaying toggle hotel list on destination box ========*/



    $(document).on('click','.scroll-btn',function(){

        $(".popup-d-body").mCustomScrollbar("scrollTo","top");

    });



}); /*===== Close ready function =======*/



$(document).on("click", function () {

    $(".ui-menu-item").hide();

});
