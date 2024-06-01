@extends('layouts.sidebar')

@section('content')
<div class="search_content w-100 border d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person" style="margin: 10px; padding-left: 20px; padding-top: 10px;box-shadow: 2px 2px 4px;">
      <div class="line_a">
        <span>ID : </span><span>{{ $user->id }}</span>
      </div>
      <div class="line_a"><span>名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div class="line_a">
        <span>カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div class="line_a">
        @if($user->sex == 1)
        <span>性別 : </span><span>男</span>
        @elseif($user->sex == 2)
        <span>性別 : </span><span>女</span>
        @else
        <span>性別 : </span><span>その他</span>
        @endif
      </div>
      <div class="line_a">
        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div class="line_a">
        @if($user->role == 1)
        <span>権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span>権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span>権限 : </span><span>講師(英語)</span>
        @else
        <span>権限 : </span><span>生徒</span>
        @endif
      </div>
      <div class="line_a">
        @if($user->role == 4)
        <span>選択科目 :</span>
          @foreach($user->subjects as $subject)
          {{ $subject->subject }}
          @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>

  <div class="search_area w-25 border">
    <div class="search_d">
      <p class="search_a">検索</p>
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" style="background-color:#CCCCCC; border: none; border-radius: 5px;" form="userSearchRequest">
      </div>
      <div>
        <div class="search_b"><label>カテゴリ</label></div>
        <select form="userSearchRequest" name="category" style="background-color: #CCCCCC; border: none;border-radius: 5px;">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div>
        <div class="search_b"><label>並び替え</label></div>
        <select name="updown" form="userSearchRequest" style="background-color:#CCCCCC; border: none;border-radius: 5px;">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="search_b">
        <p class="m-0 search_conditions"><span class="search_user_btn">検索条件の追加</span><i class="fas fa-chevron-up"></i></p>
                <div class="search_conditions_inner" style="background-color: #ECF1F6;">
          <div>
            <div class="search_b"><label>性別</label></div>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>
          <div>
            <div class="search_b"><label>権限</label></div>
            <select name="role" form="userSearchRequest" class="engineer" style="background-color: #CCCCCC; border: none; border-radius: 5px;">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <div class="search_b"><label>選択科目</label></div>
            <span>国語</span><input type="checkbox" name="subject[]" value="1" form="userSearchRequest">
            <span>数学</span><input type="checkbox" name="subject[]" value="2" form="userSearchRequest">
            <span>英語</span><input type="checkbox" name="subject[]" value="3" form="userSearchRequest">
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center" style="margin-top: 30px;">
        <input type="submit" name="search_btn" value="検索" class="btn btn-info" style="width: 70%;" form="userSearchRequest">
      </div>
      <div class="d-flex justify-content-center mt-2">
        <input type="reset" value="リセット" class="reset-button" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
