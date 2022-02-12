@extends('layouts.app')
@section('meta')
<link rel="stylesheet" href="{{ asset('css/show_post.css') }}">
@endsection
@section('main')
<div class="is-center">
    <h2 class="mt-middle is-center"></h2>
    <div class="main_image">
        <img src="{{asset('uploads/'.$post->file_path)}}" class="image" alt="{{$post->name}}画像">
        <div class="title">      
        </div>
        <h1 class="title_string">{{$post->name}}</h1>
    </div>
    @foreach($post->tags as $value)
    {{$value->name}}
    @endforeach
    <div class="good">よかったところ</div>
    <p>{{$post->good}}</p>
    <div class="bad">悪かったところ</div>
    <p>{{$post->bad}}</p>
    <div class="like">
        <span>参考になった</span>
        <span class="number">{{$post->likes->count()}}</span>
    </div>
</div>
<form action="/like" method="post" class="like_form">
@csrf
    <input type="hidden" value="{{$post->id}}" name="post_id">
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $('.like').click(function(){
        $('.like_form').submit();
    })
</script>

@endsection