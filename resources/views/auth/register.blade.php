@extends('layouts.app')
    @section('main')
        <div class="box mt-big h2 p-1 mb-3">
            <h2 class="align-center mt-3">ユーザー登録</h2>
            <div class="alert">
                
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach

               
            </div>
            <form method="POST" action="{{ route('register') }}">
                    @csrf
                <div class="input mt-3">
                    <input type="text" placeholder="ユーザー名" name="name" old="name">
                    <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                </div>
                <div class="input mt-3">
                    <input type="text" placeholder="メールアドレス" name="email" old="email">
                    <i class="far fa-envelope"></i>
                </div>
                <div class="input mt-3">
                    <input type="password" placeholder="パスワード" name="password">
                    <i class="fas fa-unlock-alt"></i>
                </div>
                <div class="input mt-3 mb-3">
                    <input type="password" placeholder="パスワード（確認）" name="password_confirmation">
                    <i class="fas fa-unlock-alt"></i>
                </div>
                <input type="submit" class="button" value="登録">
            </form>
        </div>
    @endsection
          