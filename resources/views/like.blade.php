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
                <a class="header_right" href="/user/{{$user->id}}">自分の投稿</a>
                <a class="header_left" >参考になった投稿</a>
            </div>
            <div class="main_block_content two-items">
                @foreach($user->likes as $value)
                <a class="main_block_item " href="{{route('post.show',['post'=>$value])}}">
                    <div class="main_block_image">
                    <img src="{{asset('uploads/'.$value->file_path)}}" class="cover" alt="{{$value->name}}画像">
                    </div>
                    <div class="main_block_title">
                    {{mb_strlen($value->name) > 10 ? mb_substr($value->name,0,10).'...' : $value->name}}
                    </div>
                    <div class="main_block_create">
                    {{$value->created_at}}
                    </div>
                </a>
                @endforeach
            </div>
        </div>
<!-- 縮小画像の表示領域 -->

<!-- 以下、JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/mypage.js')}}" ></script>
@endsection