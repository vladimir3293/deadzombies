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
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>

    <!-- include libraries(jQuery, bootstrap) -->
    {{--    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">--}}
    {{--    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>--}}
    {{--    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>--}}
    <script src="/admin/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="/admin/css/summernote.css" rel="stylesheet">
    <script src="/admin/js/summernote.js"></script>

    {{--    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">--}}
    {{--    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>--}}

    <script src="/admin/js/admin.js"></script>

</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Right Side Of Navbar -->
{{--            <ul class="nav navbar-nav navbar-right">--}}

                <form class="top-block-button" method="post" action="{{ route('logout') }}">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <input class="btn btn-default" type="submit" value="Выйти">
                </form>
{{--            </ul>--}}

            <!-- Кнопка «Гамбургер» отображается только в мобильном виде (предназначена для открытия основного содержимого Navbar) -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand hidden-xs" href="{{ route('admin') }}">
                Админка
            </a>

        </div>

        <!-- Right Side Of Navbar -->
                <ul class="top-block-button-widthscreen nav navbar-nav navbar-right">
                    <p class="navbar-text">{{ Auth::user()->name }}</p>

                    <form class="navbar-form navbar-left" method="post" action="{{ route('logout') }}">
                        {{ method_field('POST') }}
                        {{ csrf_field() }}
                        <input class="btn btn-default" type="submit" value="Выйти">
                    </form>
                </ul>

        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li><a href="/" target="_blank">На главную</a></li>
                <li><a href="{{ route('admin') }}" data-toggle="tab">Админка</a></li>
                <li class="nav-categoriess"><a class="nav-categories-link" href="{{ route('admin.pages.getAll') }}">Страницы</a>
                </li>
                <li class="nav-categoriess"><a class="nav-categories-link" href="{{ route('admin.game.getAll') }}">Игры</a>
                    <ul>
                        <li><a href="{{ route('admin.game.create') }}">Создать игру</a></li>
                        <li><a href="{{ route('admin.game.getPublished') }}">Опубликованные</a></li>
                        <li><a href="{{ route('admin.game.getUnpublished') }}">Не опубликованные</a></li>
                    </ul>
                </li>
                <li class="nav-categories"><a href="{{ route('admin.category.getAll') }}">Категории</a>
                    <ul>
                        <li><a href="{{ route('admin.category.create') }}">Создать категорию</a></li>
                        <li><a href="{{ route('admin.category.getPublished') }}">Опубликованные</a></li>
                        <li><a href="{{ route('admin.category.getUnpublished') }}">Не опубликованные</a></li>
                    </ul>
                </li>
                <li class="nav-categories"><a href="{{ route('admin.tag.getAll') }}">Теги</a>
                    <ul>
                        <li><a href="{{ route('admin.tag.create') }}">Создать тег</a></li>
                        <li><a href="{{ route('admin.tag.getPublished') }}">Опубликованные</a></li>
                        <li><a href="{{ route('admin.tag.getUnpublished') }}">Не опубликованные</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('admin.getParser') }}">Парсер</a></li>
            </ul>
        </div>
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
{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $('#summernote').summernote();--}}
{{--    });--}}
{{--</script>--}}
</body>
</html>