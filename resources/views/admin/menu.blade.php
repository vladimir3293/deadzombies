{{--  <ul class="nav nav-pills nav-stacked">
<div class="dropdown">
    <a data-toggle="dropdown" href="#">Dropdown trigger</a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a href="/" data-toggle="tab">Home page</a></li>
        <li><a href="{{ route('admin') }}" data-toggle="tab">Admin page</a></li>
        <li><a href="{{ route('admin.getParser') }}">Parser</a></li>
    </ul>
</div>
--}}


<ul class="nav nav-pills nav-stacked">
    <li><a href="/" data-toggle="tab">Home page</a></li>
    <li><a href="{{ route('admin') }}" data-toggle="tab">Admin page</a></li>
    <li><a href="{{ route('admin.getParser') }}">Parser</a></li>
    <li><a href="/admin" class="nav-categories">Категории</a>
        <ul>
            @foreach($menu as $category)
                <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
            @endforeach
        </ul>
    </li>
</ul>