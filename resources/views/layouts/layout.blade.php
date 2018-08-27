<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content=@yield('description')>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <script src="/js/app.js"></script>

    <script src="/js/deadzombies.js"></script>
    {{--<link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css">--}}
    <link rel="stylesheet" href="/css/scss.css">
</head>
{{-- TODO contrast ratio check google recomendation
     TODO sidebar and top block view composer ask one infrormation
--}}
<body>
{{--<div id="top"></div>--}}

<div class="wrapper container">
    @include('topBlock')
    {{--<div class="test-container">--}}
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
    <div class="go-top">
        <a href="#">наверх</a>
    </div>
    <footer class="index-footer">
        <img src="/img/site/footer.png">
        <p class="index-footer-desc">WE BRING AWESOME GAMES TO ALL SCREENS</p>
    </footer>
</div>
{{--<div id="message"><a href="#top">Scroll to top</a></div>--}}
</body>
</html>