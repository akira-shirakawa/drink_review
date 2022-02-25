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
                    <a class="main_block_item " href="/post/{{$value->id}}">
                        <div class="main_block_image">
                        <img src="{{asset('uploads/'.$value->file_path)}}" class="cover" alt="{{$value->name}}画像">
                        </div>
                        <div class="main_block_title">
                        {{$value->name}}
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
                カテゴリー
            </div>
            <div class="main_block_content two-items">
                <div class="main_block_item ">

                </div>
            </div>
        </div>
        <div class="main_block mt-3 mb-3">
            <div class="main_block_header">
                新着
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
                <a href="/search/?q=%23new"class="show_more">もっと見る</a>
            </div>
        </div>
    @endsection
          