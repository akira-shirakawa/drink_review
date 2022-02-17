@extends('layouts.app')
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
                    <input type="text" placeholder="メールアドレス" name="email">
                    <i class="far fa-envelope"></i>
                </div>
                <div class="input mt-3">
                    <input type="password" placeholder="パスワード" name="password">
                    <i class="fas fa-unlock-alt"></i>
                </div>
                
                <input type="submit" class="button" value="登録">
            </form>
        </div>
    @endsection
          