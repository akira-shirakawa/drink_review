@extends('layouts.app')
@section('meta')
<link rel="stylesheet" href="{{ asset('css/show_post.css') }}">
@endsection
@section('main')
<div class="is-center">
    <h2 class="mt-middle is-center"syle="height:100px"></h2>
    <div class="main_image">
        <img src="{{asset('uploads/'.$post->file_path)}}" class="image" alt="{{$post->name}}画像">
        <div class="title">      
        </div>
        <h1 class="title_string">{{$post->name}}</h1>
    </div>
    <div class="user_name">
        作成者：<img src="/uploads/{{ $post->user->file_path ?? 'fake.png'}}" id="user_image">{{$post->user->name}}
    </div>
    <div class="category">
        カテゴリー：
        @foreach($post->tags as $value)
        <a href="/search/?q=%23{{$value->name}}">{{$value->name}}</a>,
        
        @endforeach
    </div>
    <div class="good">よかったところ</div>
    <p>{{$post->good}}</p>
    <div class="bad">悪かったところ</div>
    <p>{{$post->bad}}</p>
    <div class="like">
        <span>参考になった</span>
        <span class="number">{{$post->likes->count()}}</span>
    </div>
</div>
@auth
<form action="/like" method="post" class="like_form">
@csrf
    <input type="hidden" value="{{$post->id}}" name="post_id">
</form>
@endauth

<div class="main_block mt-3 mb-3">
    <div class="main_block_header">
        関連
    </div>
    <div class="main_block_content two-items">
        @foreach($data as $value)
        <a class="main_block_item " href="/post/{{$value->id}}">
            <div class="main_block_image">
            <img src="{{asset('uploads/'.$value->file_path)}}" class="cover" alt="{{$value->name}}画像">
            </div>
            <div class="main_block_title">
            {{$value->name}}
            </div>
            <div class="main_block_create">
            {{$value->created_at}}
            </div>
        </a>
        @endforeach
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $('.like').click(function(){
        $('.like_form').submit();
    })
</script>

@endsection