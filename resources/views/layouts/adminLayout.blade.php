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
    <script src="/admin/js/app.js"></script>
    <script src="/admin/js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">


            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ route('admin') }}">
                Админка
            </a>
        </div>

        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <p class="navbar-text">{{ Auth::user()->name }}</p>

            <form class="navbar-form navbar-left" method="post" action="{{ route('logout') }}">
                {{ method_field('POST') }}
                {{ csrf_field() }}
                <input class="btn btn-default" type="submit" value="Выйти">
            </form>
        </ul>

    </div>
</nav>

<div class="wrapper container">

    <div class="row">
        <div class="col-md-3">
            <div class="sidebar">
                <nav>
                    @include('admin.menu')
                </nav>
            </div>
        </div>
        <div class="col-md-9">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @yield('right_content')

        </div>
    </div>
</div>
<div class="footer-bottom">

    <div class="container">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <div class="copyright">

                    © 2018, Deadzombies, All rights reserved

                </div>

            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <div class="design">

                    <span> Web Design &amp; Development by zombie</span>

                </div>

            </div>

        </div>

    </div>

</div>
</body>
</html>