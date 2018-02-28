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
    <link rel="stylesheet" href="/css/test.css">
</head>
<body>
<div class="wrapper container">
    <div class="row">
        <div class="col-md-5">
            <div class="sidebar">
                <header class="index-header">
                    {{-- todo layout composer for same parts --}}
                    <h1>Opisanie sayta h1</h1>
                    <img src="/img/logotype.png">
                </header>
                <nav>
                    <header>
                        <h1>Navigasiya na sayte</h1>
                    </header>
                    @include('admin.menu')
                    <footer>
                        <p>konec navigasii</p>
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
            <p> footer opisanie tam raznoe</p>
            @yield('footer')
        </footer>
    </div>
</div>
</body>
</html>