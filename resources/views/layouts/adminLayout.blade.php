<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content=@yield('description')>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/test.css">

</head>
<body>
<div class="wrapper container">
    <div class="row">
        <aside class="sidebar col-md-2">
                @include('admin.menu')
        </aside>
        <section class="col-md-10">
            @yield('right_content')
        </section>
    </div>

    <div class="clr"></div>
    <div class="footer">
        @yield('footer')
    </div>
</div>
</body>
</html>