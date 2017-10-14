<ul class="main_menu">
    <li><a href="/admin/">Home page</a></li>
    @foreach($menu as $category)
        <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
    @endforeach
</ul>
