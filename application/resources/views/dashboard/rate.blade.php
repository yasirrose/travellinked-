@extends('adminlayouts.main2')
@section('content')
    <!--main content-->
    <div class="wrapper">

        <div class="content-wrapper">
            <div class="content-heading"><em class="fa fa-credit-card"></em> <span class="admin-breadcrumb"><a href="#">Rate Management</a> </span>
                {{--<div class="pull-right"> <button class="btn btn-primary">Cancel</button> <button class="btn btn-primary">Save Customer</button> </div>--}}
            </div>
            <form action="{{url('admin/save_markup/').'/'.$rate->global_id}}" method="post" id="settingForm">
                @include('flash.flash') {!! csrf_field() !!}
                <div >
                    <h4 id="margs">Margin</h4>
                </div>

                <input type="hidden" id="status_field" name="status_field" value="{{$rate->status=='markup' ? "markup" : "margin"}}">

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-label">Choose Amount Type</label>
                            <div class="form-group">
                                <div class="radio-inline">
                                    <input type="radio" id="marg0"  name="marg"  value="0" {{ $rate->margin_status=='0' ? "checked" : "" }} />
                                    <label class="form-label" for="">Percentage</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" id="marg2"  name="marg"  value="-1" {{ $rate->margin_status=='-1' ? "checked" : "" }}/>
                                    <label class="form-label" for="">N/A</label>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Enter Desired Amount</label>
                            <input type="text" class="form-control" id="marg" type="text" name="margin" value="{{$rate->margin}}">
                        </div>
                    </div>
                </div>
                <div>
                    <h4 id="marks">Markup{{  $rate->status=='margin' ? "(N/A)" : " " }}</h4>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-label">Choose Amount Type</label>
                            <div class="form-group">
                                <div class="radio-inline">
                                    <input type="radio" id="mark0" name="mar" value="0" {{ $rate->markup_status=='0' ? "checked" : "" }}  />
                                    <label class="form-label" for="">Percentage</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" id="mark1" name="mar" {{ $rate->markup_status=='1' ? "checked" : "" }}  value="1"/>
                                    <label class="form-label" for="">Fixed</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" id='mark2'  name="mar"  value="-1"{{ $rate->markup_status=='-1' ? "checked" : "" }} />
                                    <label class="form-label" for="">N/A</label>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Enter Desired Amount</label>
                            <input type="text" class="form-control" type="text" name="markup" value="{{$rate->markup}}">
                        </div>
                    </div>
                </div>
                <div>
                    <h4>Tax</h4>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-label">Choose Amount Type</label>
                            <div class="form-group">
                                <div class="radio-inline">
                                    <input type="radio"  name="t"  value="0"  <?php if($rate->tax_status==0){?> checked=""<?php } ?>  />
                                    <label class="form-label" for="">Percentage</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" name="t"  value="1"  <?php if($rate->tax_status==1){?> checked="" <?php } ?>  />
                                    <label class="form-label" for="">Fixed</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio"  name="t"  value="-1" <?php if($rate->tax_status==-1){?> checked="" <?php } ?> />
                                    <label class="form-label" for="">N/A</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Enter Desired Amount</label>
                            <input type="text" class="form-control" type="text" name="tax" value="{{$rate->tax}}">
                        </div>
                    </div>
                </div>
                <div>
                    <h4>Discount</h4>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="form-label">Choose Amount Type</label>
                            <div class="form-group">
                                <div class="radio-inline">
                                    <input type="radio"  name="dis" value="0"  <?php if($rate->discount_status==0){?> checked<?php } ?>    />
                                    <label class="form-label" for="">Percentage</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" name="dis" value="1"  <?php if($rate->discount_status==1){?> checked<?php } ?> />
                                    <label class="form-label" for="">Fixed</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio"  name="dis"  value="-1" <?php if($rate->discount_status==-1){?> checked<?php } ?> />
                                    <label class="form-label" for="">N/A</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Enter Desired Amount</label>
                            <input type="text" class="form-control" type="text" name="discount" value="{{$rate->discount}}">
                        </div>
                    </div>
                </div>
              <button class="btn btn-primary" style="margin-top:10px;margin-right:20px;">Save Changes</button> </form>
        </div>
        <script>
            var element = document.getElementById("{{$activeID}}");
            element.classList.add("active");
        </script>
    </div>
@endsection
@section('script')
    <script>
        $("input:radio[name='marg']").click(function () {
            var val =$(this).val();
            if(val == 0){
                $("#mark2").prop("checked", true);
            }
        });
        $("input[name=mar]:radio").click(function () {
            var val =$(this).val();
            if(val == 1 || val == 0){
                 $("#marg2").prop("checked", true);
            }
        });
    </script>
@endsection