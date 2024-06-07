@extends('layouts.sidebar')


@section('content')
<div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center; margin-top: 3%; margin-bottom: 3%;">

  <div class="w-75 vh-100" style="background-color: white; margin-top: 10%; margin-bottom: 10%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <p class="text-center" style="font-size: 20px; margin-top: 30px; padding-top: 30px;">{{ $calendar->getTitle() }}</p>
    {!! $calendar->render() !!}
    <div class="adjust-table-btn m-auto text-right">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
@endsection
