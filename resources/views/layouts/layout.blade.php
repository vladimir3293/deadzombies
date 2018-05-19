<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content=@yield('description')>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/css/scss.css">
</head>
{{-- TODO contrast ratio
                    --}}
<body>
<div class="wrapper container">
    <div class="row">
        <div class="col-md-5">
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
        </div>
        <div class="col-md-19">
            <div class="right-content">
                @yield('right_content')
            </div>
        </div>
    </div>
    <div class="row">
        <footer class="index-footer col-md-24">
            <div class="footer">
                <div class="copy">
                    <img src="/img/site/footer.png">
                    <p class="descr">Все права на публикацию, принадлежат их владельцам. Весь материал расположенный на сайте, взят из открытых источников.</p>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="clr"></div>
        </footer>
    </div>
</div>
</body>
</html>