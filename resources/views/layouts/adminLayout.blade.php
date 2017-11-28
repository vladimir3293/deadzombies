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
    <link rel="stylesheet" href="/css/admin_morda.css">
    <link rel=""href="/css/admin_morda.css">

</head>
<body>
<div class="wrap">
    <div class="sidebar">
        @include('admin.menu')
    </div>
    <div class="right_content">
        @yield('right_content')
    </div>
    <div class="clr"></div>
    <div class="footer">
        @yield('footer')
    </div>
</div>
</body>
</html>