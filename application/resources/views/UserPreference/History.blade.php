@extends('layouts.main')

@section('content')
<div class="body-section sky-bg">
		<div class="travelers-container">
            @include('UserPreference.leftSideBar')
            <div class="travelers-container-right">
            	<div class="travelers-container-title">History</div>
                <div class="travelers-work-msg">
                	<h2>We are working on it</h2>
                    <p>Sorry about that, this section will be ready soon</p>
                </div>
            </div>
    		<div class="clear"></div>
   		</div>
	</div>	


    <script>
var element = document.getElementById("{{$activeID}}");
element.classList.add("active");
</script>
@endsection

