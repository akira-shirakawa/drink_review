@extends('layouts.app')
@section('meta')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection
    @section('main')
        <div class="box mt-big h2 p-1 mb-3">
            <h2 class="align-center mt-3">ログイン</h2>
            <div class="alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            <form method="POST" action="{{ route('login') }}">
                    @csrf
                
                <div class="input mt-3">
                    <input type="text" placeholder="メールアドレス" name="email" value="{{old('email')}}">
                    <i class="far fa-envelope"></i>
                </div>
                <div class="input mt-3">
                    <input type="password" placeholder="パスワード" name="password">
                    <i class="fas fa-unlock-alt"></i>
                </div>
                
                <input type="submit" class="button mt-3 mb-3" value="登録">
            </form>
        </div>
    @endsection
          