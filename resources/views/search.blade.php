@extends('layouts.app')
@section('meta')
<link rel="stylesheet" href="{{ asset('css/upload.css') }}">
@endsection
@section('main')
<div class="is-center">
    <form method="get" action="/search" class="search_box mt-middle" >
            <input type="text" size="25" placeholder="キーワード検索" name="q">
                
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    <div class="main_block_content mt-middle">
       
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

@endsection