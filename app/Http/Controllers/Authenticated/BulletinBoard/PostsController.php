<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;

use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Illuminate\Support\Facades\Validator;

use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
            //   dd($request);
        if(!empty($request->keyword)){
            $keyword = $request->keyword;
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
// サブカテゴリーと一致したら表示を追記
            ->orWhereHas('subCategories', function ($query) use ($keyword) {
            $query->where('sub_category', '=', $keyword);
            })
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();


// サブカテゴリー押すとその投稿が表示
        }else if ($request->sub_search) {
        $category_word = $request->sub_search;
        $posts = Post::with('user', 'postComments')->whereHas('subCategories', function ($query) use ($category_word)
        {$query->where('sub_category', $category_word);})->get();
        // dd($category_word);

        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::with('subCategories')->get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }


    public function postCreate(PostFormRequest $request){

        $subCategories = $request->sub_categories;
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
// 中間テーブルに登録する記述を追記
        $subCategories = $request->input('post_category_id', []);
        $post->subCategories()->attach($subCategories);

        return redirect()->route('post.show');
    }

    public function postEdit(PostFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    // メインカテゴリー作成
    public function mainCategoryCreate(Request $request){
          $request->validate([
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ],  [
            'main_category_name.required' => 'メインカテゴリーは必ず入力してください。',
            'main_category_name.string' => 'メインカテゴリー名は文字列でなければなりません。',
            'main_category_name.max' => 'メインカテゴリー名は100文字以内で入力してください。',
            'main_category_name.unique' => 'このメインカテゴリー名は既に登録されています。',
        ]);
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }


    // 一覧で表示させる
    public function showCategory()
    {
    $mainCategories = MainCategory::all();
    return view('post_create', compact('mainCategories'));
    }

// サブカテゴリー作成
    public function subCategoryCreate(Request $request)
    {
        $request->validate([
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
        ], [
            'sub_category_name.required' => 'サブカテゴリーは必ず入力してください。',
            'sub_category_name.string' => 'サブカテゴリー名は文字列でなければなりません。',
            'sub_category_name.max' => 'サブカテゴリー名は100文字以内で入力してください。',
            'sub_category_name.unique' => 'このサブカテゴリー名は既に登録されています。',
        ]);

    $mainCategories = MainCategory::get();
    SubCategory::create([
        'sub_category' => $request->sub_category_name,
        'main_category_id' => $request->main_category_id,

    ]);

    return redirect()->route('post.input');
    }



    // バリデーション機能を実装
    public function commentCreate(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'comment' => 'required|string|max:2500',
    ], [
        'comment.required' => 'コメントは必ず入力してください。',
        'comment.max' => 'コメントは2500文字までです。',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
        }
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
