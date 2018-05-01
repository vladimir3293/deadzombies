<ul class="nav nav-pills nav-stacked">
    <li><a href="/" data-toggle="tab" target="_blank">На главную</a></li>
    <li><a href="{{ route('admin') }}" data-toggle="tab">Админка</a></li>
    <li class="nav-categoriess"><a class="nav-categories-link" href="{{ route('admin.getAllGames') }}">Игры</a>
        <ul>
            <li><a href="{{ route('admin.createGame') }}">Создать игру</a></li>
            <li><a href="{{ route('admin.getPublished') }}">Опубликованные</a></li>
            <li><a href="{{ route('admin.getUnpublished') }}">Не опубликованные</a></li>
        </ul>
    </li>
    <li class="nav-categories"><a href="{{ route('admin.category.getAll') }}" class="nav-categories-link">Категории</a>
        <ul>
            <li><a href="{{ route('admin.category.create') }}">Создать категорию</a></li>
            <li><a href="{{ route('admin.category.getPublished') }}">Опубликованные</a></li>
            <li><a href="{{ route('admin.category.getUnpublished') }}">Не опубликованные</a></li>
        </ul>
    </li>
    <li><a href="{{ route('admin.getTags') }}">Теги</a></li>
    <li><a href="{{ route('admin.getParser') }}">Парсер</a></li>
</ul>