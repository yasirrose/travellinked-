@extends('')
@section('content')

  @foreach($reservations as $reservation)
     {{dd($reservation)}}
  @endforeach
@endsection