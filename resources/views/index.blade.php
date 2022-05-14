@extends('layouts.app')
    @section('meta')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @endsection
    @section('main')
        <form method="get" action="/search" class="search_box mt-middle" >
            <input type="text" size="25" placeholder="キーワード検索" name="q">
                
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <div class="main_block mt-3">
            <div class="main_block_header">
                注目
            </div>
            <div class="main_block_content two-items">
                @foreach($ranking as $value)
                    <a class="main_block_item " href="{{route('post.show',['post'=>$value])}}">
                        <div class="main_block_image">
                        <img src="{{asset('uploads/'.$value->file_path)}}" class="cover" alt="{{$value->name}}画像">
                        </div>
                        <div class="main_block_title">

                        {{mb_strlen($value->name) > 10 ? mb_substr($value->name,0,10).'...' : $value->name}}</br>
                        <span>作成者：{{$value->user->name}}</span>
                        </div>
                        <div class="main_block_create">
                        {{$value->created_at}}</br>
                        <i class="far fa-thumbs-up"></i>
                        {{$value->likes->count()}}
                        </div>
                    </a>
                    @endforeach
                    <a href="/search/?q=%23sorting"class="show_more">もっと見る</a>
            </div>
        </div>
        <div class="main_block mt-3">
            <div class="main_block_header">
                人気カテゴリー
            </div>
            <div class="main_block_content two-items">
                @foreach($category as $value)               
                <a class="main_block_item category" href="/search/?q=%23{{$value->name}}">
                {{mb_strlen($value->name) > 20 ? mb_substr($value->name,0,10).'...' : $value->name}}
                </a>
                @endforeach
            </div>
        </div>
        <div class="main_block mt-3 mb-3">
            <div class="main_block_header">
                新着
            </div>
            <div class="main_block_content two-items">
                @foreach($data as $value)
                <a class="main_block_item " href="{{route('post.show',['post'=>$value])}}">
                    <div class="main_block_image">
                    <img src="{{asset('uploads/'.$value->file_path)}}" class="cover" alt="{{$value->name}}画像">
                    </div>
                    <div class="main_block_title">
                    {{mb_strlen($value->name) > 10 ? mb_substr($value->name,0,10).'...' : $value->name}}</br>
                    <span>作成者：{{$value->user->name}}</span>
                    </div>
                    <div class="main_block_create">
                    {{$value->created_at}}
                    </div>
                </a>
                @endforeach
                <a href="/search/?q=%23new"class="show_more">もっと見る</a>
            </div>
        </div>
    @endsection
          