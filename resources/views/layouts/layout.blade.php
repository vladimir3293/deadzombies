<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content=@yield('description')>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<div class="wrap">
    <div class="sidebar">
        @include('sidebar')
    </div>
    <div class="right_content">
        @yield('right_content')
    </div>
    <div class="clr"></div>
    <div class="footer">
        @section('footer')
            <div class="copy">
                <img src="/img/footer.png">
                <p class="descr">Все права на публикацию, принадлежат их владельцам. Весь материал расположенный на
                    сайте, взят из открытых источников.</p>
                <div class="clr"></div>
            </div>
        @show
    </div>
</div>
</body>
</html>