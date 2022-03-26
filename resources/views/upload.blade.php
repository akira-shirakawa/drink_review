@extends('layouts.app')
@section('meta')
<link rel="stylesheet" href="{{ asset('css/upload.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css" integrity="sha512-uKwYJOyykD83YchxJbUxxbn8UcKAQBu+1hcLDRKZ9VtWfpMb1iYfJ74/UIjXQXWASwSzulZEC1SFGj+cslZh7Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('main')
<div class="is-center">
<h2 class="mt-middle is-center">新規投稿</h2>


<canvas id="canvas" width="0" height="0"></canvas>

<p class="validation_image"></p>
<label for="file" class="filelabel ">画像をアップロードする<span>(必須)</span></label>
<input type="file" name="fileinput" id="file" class="fileinput" accept="image/*">
<p class="label">タイトル<span>(必須)</span></p>
<p class="validation"></p>
<input type="text" name="name" value="" class="input">
<p class="label">カテゴリー</p>
<input name="tags" id="tags" value="" />
<p class="label">よかったところ</p>
<textarea name="good" rows="4"></textarea>
<p class="label">悪かったところ</p>
<textarea name="bad" rows="4"></textarea>
<button id="upload" class="mt-middle button"><i class="fa "></i>投稿</button>
</div>

 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/upload.js')}}" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js" integrity="sha512-wTIaZJCW/mkalkyQnuSiBodnM5SRT8tXJ3LkIUA/3vBJ01vWe5Ene7Fynicupjt4xqxZKXA97VgNBHvIf5WTvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('#tags').tagsInput();
</script>
@endsection