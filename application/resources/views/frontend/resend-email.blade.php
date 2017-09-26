@extends('layouts.main')
@section('content')
<div class="body-section">
    <div class="container">
        <div class="rsnd-cnfm-email">
            <h3>Resend Confirmation Email</h3>
            <?php if(empty(session()->get('userLogin')) || session()->get('userLogin') == 0){ ?>
            <p>Not a member? <a href="javascript:void(0)" class="signup-link">Sign up here</a>.</p>
            <?php } ?>
            <form method="post" id="resend-email">
            <p id="msg"></p>
            <div class="rsnd-cnfm-form">
                <label>Email Address</label>
                <div class="rsnd-cnfm-holder">
                	{!! csrf_field() !!}
                    <?php if(empty(session()->get('userLogin')) || session()->get('userLogin') == 0){ ?>
                    <input type="text" class="control-field" name="email" placeholder="Enter Email Address" required="required">
                    <?php }else{ ?>
                    <input type="text" class="control-field valid" name="email" required="required" value="{{session()->get('userEmail')}}">
                    <?php } ?>
                </div>
                <button>Send</button>
            </div>
            </form>
            <div class="click-to-home">
                <a href="{{url('/')}}">Return to home</a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
@endsection