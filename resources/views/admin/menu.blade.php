<ul class="nav nav-pills nav-stacked">
    <li><a href="/" data-toggle="tab">Home page</a></li>
    <li><a href="{{ route('admin') }}" data-toggle="tab">Admin page</a></li>
    <li class="nav-categoriess"><a class="nav-categories-linkk href="#">Игры</a>
        <ul>
            <li><a href="{{ route('admin.createGame') }}">Создать игру</a></li>
            <li><a href="{{ route('admin.getUnpublished') }}">Не опубликованные</a></li>
            <li><a href="{{ route('admin.getPublished') }}">Опубликованные</a></li>
        </ul>
    </li>
    <li class="nav-categories"><a href="/admin" class="nav-categories-link">Категории</a>
        <ul>
            @foreach($menu as $category)
                <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
            @endforeach
        </ul>
    </li>
    <li><a href="{{ route('admin.getParser') }}">Parser</a></li>
</ul>