<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon"  href="{{ asset('/favicon.svg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grocery Web site</title>
    <!-- font awsome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/elements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    @yield('meta')
</head>
<body>
    <!-- header section starts -->
    <header class="header">
        <a href="/" class="logo"><i class="fas fa-wine-glass-alt mr-1"></i>Drink review</a>
        <nav class="navbar">
           
            <a href="/">ホーム</a>
           
            @guest
            <a href="/login">ログイン</a>
            <a href="/register">新規登録</a>
            @endguest
            @auth
           
            <span id="logout-button">ログアウト</span>
            @endauth
           
        </nav>
    </header>
    <div class="main">
        <div class="container">
            <div class="left">
faf
            </div>
            <div class="center">
               @yield('main')
            </div>
            <div class="right">
               
            </div>
        </div>
        
    </div>
    <footer class="footer">
        <p>Drink review Akira's portfolio</p>
    </footer>
    <!-- header section ends -->
    <form id="logout" method="POST" action="{{ route('logout') }}"> 
      @csrf 
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<!-- custom js file link -->
<script src="js/main.js"></script>
</body>
</html>