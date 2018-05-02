<ul class="nav nav-pills nav-stacked">
    <li><a href="/" data-toggle="tab" target="_blank">На главную</a></li>
    <li><a href="{{ route('admin') }}" data-toggle="tab">Админка</a></li>
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