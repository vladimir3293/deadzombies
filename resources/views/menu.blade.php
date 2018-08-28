<div class="sidebar-slider">
    <div class="sidebar-slider-header">

    </div>
    <ul>
        <li><a href="/">Главная</a></li>
        @foreach($menu as $category)
            <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
        @endforeach
    </ul>
    <div class="sidebar-slider-footer">
    </div>
</div>


{{--<ul>--}}
{{--<li id="menu" class="hidden-blockd"><a href="#">Меню</a></li>--}}
{{--<li class="menu-row" ><a href="/">Главная</a></li>--}}
{{--@foreach($menu as $category)--}}
{{--<li class="menu-row"><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>--}}
{{--@endforeach--}}
{{--</ul>--}}