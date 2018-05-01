<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content=@yield('description')>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/admin/css/app.css">
    <link rel="stylesheet" href="/admin/css/admin.css">
    {{--<script src="/admin/js/app.js"></script>--}}
    </head>
<body>
<div class="wrapper container">
    <div class="row">
        <div class="col-md-9">
            <h1>Админка</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="sidebar">
                <nav>
                    @include('admin.menu')
                </nav>
            </div>
        </div>
        <div class="col-md-9">
            <div class="right-content">
                @yield('right_content')
            </div>
        </div>
    </div>
    <div class="row">
        <footer class="index-footer col-md-12">
            <div class="footer">
                <div class="copy">
                    <img src="/img/footer.png">
                    <p class="descr">Все права на публикацию, принадлежат их владельцам. Весь материал расположенный на
                        сайте, взят из открытых источников.</p>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="clr"></div>
        </footer>
    </div>
</div>

</body>
</html>