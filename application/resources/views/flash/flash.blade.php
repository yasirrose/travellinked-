<! DOCTYPE html>

<head>

<title></title>



</head>



<body>





    @if(session()->has('success'))

       

        <div style="background-color:#0fbd71; color:#fff; font-size:16px;" class="alert alert-success alert-success fade in" role="alert">

         <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                      <span aria-hidden="true">×</span></button>

                      <strong>Congrats!</strong>

         {{session()->get('success')}}</div>

    @endif





   @if(session()->has('error'))

        <div style="background-color:#a94442; color:#fff; font-size:16px;" class="alert alert-warning alert-danger fade in" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close">

          <span aria-hidden="true">×</span></button>

          <strong>Sorry!</strong>&nbsp;

           {{session()->get('error')}}

           </div>



 	@endif

    @if(session()->has('access'))

        <div style="background-color:#a94442; color:#fff; font-size:16px;" class="alert alert-warning alert-danger fade in" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close">

          <span aria-hidden="true">×</span></button>

          <strong>Alert!</strong>&nbsp;

           {{session()->get('access')}}

           </div>



 	@endif



  @if(session()->has('messages'))

         <div class="alert alert-warning alert-danger fade in" role="alert">

           <button type="button" class="close" data-dismiss="alert" aria-label="Close">

           <span aria-hidden="true">×</span></button>

           <strong>Sorry!</strong>  You have failed.

           <ul>

           @foreach (session()->get('messages')->all() as $message)

               <li>{{ $message  }}</li>

           @endforeach

           </ul>

         </div>

  @endif



  

</body>

</html>