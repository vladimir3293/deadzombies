<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content=@yield('description')>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
{{--    <link rel="icon" href="/favicon.ico" type="image/x-icon">--}}

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

<div class="wrapper">
    <header class="top-block-wrapper">
        @include('topBlock')

    </header>
    <div class="content">
        @yield('content')
        {{--<div class="go-top">--}}
            {{--<a href="#">наверх</a>--}}
        {{--</div>--}}
    </div>
    @include('footer')
</div>
{{--<div id="message"><a href="#top">Scroll to top</a></div>--}}
</body>
</html>