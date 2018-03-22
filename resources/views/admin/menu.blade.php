<ul class="nav nav-pills nav-stacked">
    <li><a href="/">Home page</a></li>
    <li><a href="{{ route('admin') }}">Admin page</a></li>
    <li><a href="{{ route('admin.getParser') }}">Parser</a></li>
    @foreach($menu as $category)
        <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
    @endforeach
</ul>