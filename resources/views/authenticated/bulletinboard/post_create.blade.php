@extends('layouts.sidebar')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}"></optgroup>
        <!-- サブカテゴリー表示 -->

        @foreach($main_category->subCategories as $subCategory)
          <option value="{{ $subCategory->id }}">{{ $subCategory->sub_category }}</option>
        @endforeach

        </optgroup>
        @endforeach
      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>

  {{-- @can('admin') --}}
  <div class="w-25 ml-auto mr-auto">
      <div class="category_area mt-5 p-5">
          <!-- メインカテゴリー追加フォーム -->
          <div class="mb-4">
              <p class="m-0">メインカテゴリー</p>
              <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="main_category_name" required>
                  <input type="submit" value="追加" class="btn btn-primary mt-2">
              </form>
          </div>

          <!-- サブカテゴリー追加フォーム -->
            <div>
                <p class="m-0">サブカテゴリー</p>
                <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">
                    {{ csrf_field() }}
                    <select name="main_category_id" class="form-control mt-2" required>
                        @foreach($main_categories as $mainCategory)
                            <option value="{{ $mainCategory->id }}">{{ $mainCategory->main_category }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control mt-2" name="sub_category_name" required>
                    <input type="submit" value="追加" class="btn btn-primary mt-2">
                </form>
            </div>
      </div>
  </div>
{{-- @endcan --}}
</div>
@endsection
