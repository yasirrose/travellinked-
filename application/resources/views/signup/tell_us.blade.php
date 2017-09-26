@extends('layouts.singinLayout')
@section('content')
<div class="signup-page" id="signup-page" style="">
   <div class="signup-page-inner">
       <div class="signup-page-logo">
           <a href="#">
               <img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png">
           </a>
       </div>
     <div class="signup-page-form" id="tell-us">
      <div class="signup-wizard-links">
        <ul>
            <li><a href="#secondPage"></a></li>
            <li><a href="#phoneC"></a></li>
            <li><a href="#emailConfirm"></a></li>
            <li><a href="#emailConfirm"></a></li>

        </ul>
    </div>
    <div class="signup-form-head">
        <h1>Tell us a little more about you</h1>
        <p>What is the purpose of your account, and how do you plan to use Travel Linked?s</p>
    </div>
    <div class="signup-form-btm">
        <div class="signup-form-row">
            <label>Account Type</label>
            <div class="icon-control">
                <select class="signup-form-field" id="abt" name="about">
                    <option disabled selected>Select Who You Are</option>
                    <option value="gen">gentlman</option>
                    <option value="prof">professor</option>
                    <option value="manger">area manger</option>
                </select>
                <span class="ion ion-arrow-down-b"></span>
            </div>
        </div>
        <div class="signup-form-row">
            <label>How Did You Hear About Us?</label>
            <div class="icon-control">
                <select name="source" class="signup-form-field" id="src">
                    <option disabled selected>Select Source</option>
                    <option value="Forum">Forum</option>
                    <option value="Blog">Blog</option>
                    <option value="Advertisement">Advertisement</option>
                    <option value="Social Media">Social Media</option>
                    <option value="Friend">Friend</option>
                </select>
                <span class="ion ion-arrow-down-b"></span>
            </div>
        </div>
        <div class="signup-form-btn">
            <button id="ready" onclick="tellusYourself({{$id}})" type="submit">Ready To Go</button>
        </div>
    </div>
 </div>
   </div>
</div>
<script>
    function tellusYourself(id) {

       var about = $('#abt').val();
       var source = $('#src').val();

        $.ajax({
            url: "{{URL('afterRegister')}}",
            type: "POST",
            data:{
                "about" :about,
                "source" :source,
                "id":id,
                "_token": "{{csrf_token()}}"
            },
            success:function () {
                window.location.href = '{{url('userlogin/simple')}}';
            }


        })

    }
</script>
@endsection