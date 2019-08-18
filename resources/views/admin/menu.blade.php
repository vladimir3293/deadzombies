{{--<!-- Классы navbar и navbar-default (базовые классы меню) -->--}}
{{--<nav class="navbar navbar-default">--}}
{{--    <!-- Контейнер (определяет ширину Navbar) -->--}}
{{--    <div class="container-fluid">--}}
{{--        <!-- Заголовок -->--}}
{{--        <div class="navbar-header">--}}
{{--            <!-- Кнопка «Гамбургер» отображается только в мобильном виде (предназначена для открытия основного содержимого Navbar) -->--}}
{{--            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">--}}
{{--                <span class="icon-bar"></span>--}}
{{--                <span class="icon-bar"></span>--}}
{{--                <span class="icon-bar"></span>--}}
{{--            </button>--}}
{{--            <!-- Бренд или название сайта (отображается в левой части меню) -->--}}
{{--            <a class="navbar-brand" href="#">Brand</a>--}}
{{--        </div>--}}
{{--        <!-- Основная часть меню (может содержать ссылки, формы и другие элементы) -->--}}
{{--        <div class="collapse navbar-collapse" id="navbar-main">--}}
{{--            <li><a href="/" target="_blank">На главную</a></li>--}}
{{--            <li><a href="{{ route('admin') }}" data-toggle="tab">Админка</a></li>--}}
{{--            <!-- Содержимое основной части -->--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}

{{--<div class="navbar navbar-default hidden-xs">--}}
{{--    <div class="container-fluid">--}}
{{--        <ul>--}}
{{--            <li><a href="/" target="_blank">На главную</a></li>--}}
{{--            <li><a href="{{ route('admin') }}" data-toggle="tab">Админка</a></li>--}}
{{--            <li class="nav-categoriess"><a class="nav-categories-link"--}}
{{--            </li>--}}
{{--            <li class="nav-categoriess"><a class="nav-categories-link" href="{{ route('admin.game.getAll') }}">Игры</a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('admin.game.create') }}">Создать игру</a></li>--}}
{{--                    <li><a href="{{ route('admin.game.getPublished') }}">Опубликованные</a></li>--}}
{{--                    <li><a href="{{ route('admin.game.getUnpublished') }}">Не опубликованные</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-categories"><a href="{{ route('admin.category.getAll') }}">Категории</a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('admin.category.create') }}">Создать категорию</a></li>--}}
{{--                    <li><a href="{{ route('admin.category.getPublished') }}">Опубликованные</a></li>--}}
{{--                    <li><a href="{{ route('admin.category.getUnpublished') }}">Не опубликованные</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-categories"><a href="{{ route('admin.tag.getAll') }}">Теги</a>--}}
{{--                <ul>--}}
{{--                    <li><a href="{{ route('admin.tag.create') }}">Создать тег</a></li>--}}
{{--                    <li><a href="{{ route('admin.tag.getPublished') }}">Опубликованные</a></li>--}}
{{--                    <li><a href="{{ route('admin.tag.getUnpublished') }}">Не опубликованные</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li><a href="{{ route('admin.getParser') }}">Парсер</a></li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</div>--}}


<ul class="menu nav nav-pills nav-stacked">
    <li><a href="/" target="_blank">На главную</a></li>
    <li><a href="{{ route('admin') }}">Админка</a></li>
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
<form method="post" action="/admin/search" enctype="multipart/form-data" role="form">
{{ method_field('POST') }}
{{ csrf_field() }}
    <div class="form-group">
        <label for="game_name">Поиск</label>
        <input class="form-control" name="game_name" id="game_name" type="text">
        <input class="btn btn-primary btn-sm" type="submit" value="Найти">
    </div>
</form>