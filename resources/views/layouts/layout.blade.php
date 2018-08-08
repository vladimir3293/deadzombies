<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content=@yield('description')>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <script src="/js/deadzombies.js"></script>
    {{--<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css">--}}
    <link rel="stylesheet" href="/css/scss.css">
</head>
{{-- TODO contrast ratio
                    --}}
<body>
<div class="wrapper container">
    <header class="top-block">
        <div class="top-block-content">
            <button>
                <svg viewBox="0 0 30 30" data-reactid="14">
                    <rect x="0" y="5" width="30" height="4" data-reactid="15"></rect>
                    <rect x="0" y="13" width="30" height="4" data-reactid="16"></rect>
                    <rect x="0" y="13" width="30" height="4" data-reactid="17"></rect>
                    <rect x="0" y="21" width="30" height="4" data-reactid="18"></rect>
                </svg>
            </button>
            <div class="top-block-link">
                <a href="/">Deadzombies</a>
            </div>
        </div>
    </header>
    <div class="sidebar">
        <header class="index-header">
            <h1>Html5 игры на</h1>
            <a href="/"><img src="/img/site/logotype.png"></a>
        </header>
        <nav>
            <header>
                <h1>Категории на сайте</h1>
            </header>
            @include('menu')
            <footer>
                <h1>удачной игры</h1>
            </footer>
        </nav>
    </div>
    <div class="right-content">
        @yield('right_content')
    </div>
    <footer class="index-footer">
                <img src="/img/site/footer.png">
                <p class="index-footer-desc">WE BRING AWESOME GAMES TO ALL SCREENS</p>
    </footer>
</div>
<a id="gotop" class="scrollTop" href="#" onclick="top.goTop(); return false;" style="display: block; opacity: 1;"></a>
</body>
</html>