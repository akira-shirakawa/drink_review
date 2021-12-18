@extends('layouts.app')
    @section('main')
        <form method="get" action="#" class="search_box mt-middle">
            <input type="text" size="25" placeholder="　キーワード検索">
                
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <div class="main_block mt-3">
            <div class="main_block_header">
                注目
            </div>
            <div class="main_block_content two-items">
                <div class="main_block_item ">

                </div>
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
                <div class="main_block_item ">

                </div>
            </div>
        </div>
    @endsection
          