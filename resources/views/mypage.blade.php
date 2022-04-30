@extends('layouts.app')
@section('meta')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection
@section('main')
<div class="alert-box">
  
    変更が保存されました。
  
</div>
<h2 class="mt-middle is-center">マイページ</h2>
@if($user->id = Auth::id())
<div class="mypage_wrap">
    <div class="left_side">
        <canvas id="canvas" width="0" height="0"></canvas>

        <img src="/uploads/{{ $user->file_path ?? 'fake.png'}}" id="user_image" width="60%">
    </div>
    <div class="right_side is-center">
        <label for="file" class="filelabel ">プロフィール画像をアップロードする(jpeg,png)</label>
        <input type="file" name="fileinput" id="file" class="fileinput" accept=".png,.jpeg">
        <p class="label">名前</p>
        <input type="text" name="name" value="{{ Auth::user()->name }}">
        <button id="upload" class="mt-middle button is-hide"><i class="fas"></i><span>変更</span></button>
    </div>
</div>
@endif
<!-- アップロードボタン -->
<div class="main_block mt-3 mb-3">
            <div class="main_block_header">
                <a class="header_left">自分の投稿</a>
                <a class="header_right" href="/like/{{$user->id}}">参考になった投稿</a>
            </div>
            <div class="main_block_content two-items">
                @foreach($user->posts as $value)
                <a class="main_block_item " href="{{route('post.show',['post'=>$value])}}">
                    <div class="main_block_image">
                        <img src="{{asset('uploads/'.$value->file_path)}}" class="cover" alt="{{$value->name}}画像">
                    </div>
                    <div class="main_block_title">
                    {{mb_strlen($value->name) > 10 ? mb_substr($value->name,0,10).'...' : $value->name}}
                    </div>
                    <div class="main_block_create">
                        {{$value->created_at}}
                        <i class="fas fa-bars"></i>
                        <div class="delete_box">
                            <div class="delete_box_item delete">
                                消去<i class="fas fa-trash-alt"></i>
                                <form action="/delete_post" method="post">
                                @csrf
                                    <input type="hidden" name ="post_id" value="{{$value->id}}">
                                </form>                        
                            </div>
                            <object>
                            <a href="/post/edit/{{$value->id}}" class="delete_box_item edit">
                               編集
                            </a>
                            </object>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/mypage.js')}}" ></script>
@endsection