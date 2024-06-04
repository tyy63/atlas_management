@extends('layouts.sidebar')

@section('content')
<div class="w-75 m-auto">

  <div class="w-100" style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <p class="text-center" style="font-size: 20px; margin-top: 30px; padding-top: 30px;">{{ $calendar->getTitle() }}</p>
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>



@endsection
