@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" class='post_titile'>{{ $post->post_title }}</a></p>

      <div class="post_bottom_areaa">
        <div class="post_bottom_area">
          {{-- ここにサブカテゴリーを追加する --}}
            <div class="subcategories">
              @foreach($post->subCategories as $subCategory)
                <span>{{ $subCategory->sub_category }}</span>
              @endforeach
            </div>
            <div class='counts'>
              <div class="mr-5">
              <i class="fa fa-comment text-secondary"></i><span class="">{{ $post->commentCounts($post->id)->count() }}</span>
                {{-- <p>{{ $post->commentCounts($post->id)->count() }}</p> --}}
              </div>
              <div>
                  @if(Auth::user()->is_Like($post->id))
                  <p class="m-0 un_like_btn" post_id="{{ $post->id }}">
                      <i class="fas fa-heart"></i>
                      <span class="like_counts{{ $post->id }}">{{ \App\Models\posts\Like::likeCounts($post->id) }}</span>
                  </p>
                  @else
                  <p class="m-0 like_btn" post_id="{{ $post->id }}">
                      <i class="far fa-heart"></i>
                      <span class="like_counts{{ $post->id }}">{{ \App\Models\posts\Like::likeCounts($post->id) }}</span>
                  </p>
                  @endif
              </div>
            </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25" style="margin-right: 40px; border: none;">
      <div class="m-4" style="width: 100%;">
        <div class="post-btn" style="margin-bottom: 20px;">
          <a href="{{ route('post.input') }}" class="btn btn-info btn-block">投稿</a>
        </div>
        <div class="keyword" style="display: flex; margin-bottom: 20px;">
          <div class="keyword_size" style="flex: 0 0 70%;">
            <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest" style="width: 100%; background-color: #ECF1F6; border-radius: 5px; padding: 8px; border: 1px solid #ddd;">
          </div>
          <input type="submit" value="検索" form="postSearchRequest" class="btn btn-info btn-block" style="flex: 0 0 30%;">
        </div>
          <div class="d-flex" style="margin-top: 20px;">
            <form id="postSearchRequest" style="width: 100%;">
            <div class="d-flex justify-content-between align-items-center" style="height: 44px;">
              <input type="submit" name="like_posts" class="btn btn-danger category_btn pink_btn btn-block" style="height: 40px; margin: 0; border-width: 2px; margin-right: 2px;" value="いいねした投稿">
              <input type="submit" name="my_posts" class="btn btn-warning category_btn yellow_btn btn-block" style="height: 40px; margin: 0; border-width: 2px; margin-left: 2px;" value="自分の投稿">
            </div>
            </form>
          </div>
        <p class="sub-search">カテゴリー検索</p>
        {{-- サブカテゴリー表示とその投稿一覧の表示の実装 --}}
        <ul>
            @foreach($categories as $category)
            <li class="main_categories" category_id="{{ $category->id }}" style="border-bottom: 1px solid #ddd;">
                <div class="main_category_wrapper">
                    <div class="a-space-between" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                        <div class="main_category_toggle">{{ $category->main_category }}</div>
                        <div><i class="fas fa-chevron-down"></i></div>
                    </div>
                </div>
                <ul class="sub_categories">
                    @foreach($category->subCategories as $subCategory)
                    <li style="background-color: #ECF1F6; padding-left: 30px; padding-right: 30px;"> <!-- 右側のpaddingを追加 -->
                        <div class="underline"> <!-- 新しいスタイルを適用 -->
                            <input type="hidden" name="sub_category_id" value="{{ $subCategory->id }}">
                            <input type="submit" name="sub_search" class="category_btn" value="{{ $subCategory->sub_category }}" form="postSearchRequest">
                        </div>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
      </div>
    </div>
    <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
  </div>
@endsection
