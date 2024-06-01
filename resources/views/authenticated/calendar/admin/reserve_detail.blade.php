@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ $formattedDate }}</span><span class="ml-3">{{ $part }}部</span></p>



<style>
  .bordered-table {
    border-collapse: collapse;
    width: 100%;
  }

  .bordered-table th,
  .bordered-table td {
    padding: 8px;
  }

  .bordered-table tr:nth-child(even) {
    background-color: #C2EEFF;
  }

  .bordered-table tr:nth-child(odd) {
  background-color:#fff;
  }
</style>

<div class="h-75 border">
    <table class="bordered-table">
        <thead>
            <tr class="text-center" style="background-color: #03AAD2; color: #fff;">
                <th class="w-25">ID</th>
                <th class="w-25">名前</th>
                <th class="w-25">場所</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservePersons as $index => $reserve)
            @foreach($reserve->users as $user)
            <tr class="text-center {{ $index % 2 == 0 ? '' : 'even-row' }}">
                <td>{{ $user->id }}</td>
                <td>{{ $user->over_name }}{{ $user->under_name }}</td>
                <td><p>リモート</p></td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>




  </div>
</div>
@endsection
