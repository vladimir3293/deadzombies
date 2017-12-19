<ul class="main_menu">
    <li><a href="/">Home page</a></li>
    <li><a href="/admin">Admin page</a></li>
    @foreach($menu as $category)
        <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
    @endforeach
</ul>
