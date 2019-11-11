<div class="top-block">
    <div class="top-block-content">
        <button id="top-block-button">
            <svg viewBox="0 0 30 30" data-reactid="14">
                <rect x="0" y="5" width="30" height="4" data-reactid="15"></rect>
                <rect x="0" y="13" width="30" height="4" data-reactid="16"></rect>
                <rect x="0" y="13" width="30" height="4" data-reactid="17"></rect>
                <rect x="0" y="21" width="30" height="4" data-reactid="18"></rect>
            </svg>
        </button>
        <a class="top-block-logo" href="/"></a>
        <div class="top-block-search">
            <form method="post" action="/search" enctype="multipart/form-data" role="form">
                {{ method_field('GET') }}
                {{ csrf_field() }}
                <input name="q" type="search" placeholder="   Поиск игр...">
                <input type="submit" value="Найти">
            </form>
        </div>
        <div class="top-block-top-categories">
            <span>Лучшие категории</span>
            <ul>
                @foreach($topCategories as $category)
                    <li>
                        <a href="{!! $category->url !!}" title="Категория игр {{ $category->cat_name }}"><img
                                    alt="{{ $category->imgAlt }}"
                                    title="{{ $category->imgTitle }}"
                                    src="{{ $category->img }}"><span>{!! $category->cat_name !!}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="top-block-popular-categories">
            <span>Популярные категори</span>
            @if($popularCategories->isNotEmpty())
                <ul>
                    @foreach($popularCategories as $category)
                        <li>
                            <a href="{!! $category->url !!}" title="Категория игр {{ $category->cat_name }}">
                                <img alt="{{ $category->imgAlt }}"
                                     title="{{ $category->imgTitle }}"
                                     src="{{ $category->img }}">
                                <span>{!! $category->cat_name !!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="top-block-slider">
        <div class="top-block-slider-header">
        </div>
        <ul>
            @foreach($categories as $category)
                <li><a href="{!! $category->url !!}" title="Категория игр {{ $category->cat_name }}"><img
                                alt="{{ $category->imgAlt }}"
                                title="{{ $category->imgTitle }}"
                                src="{{ $category->img }}"><span>{!! $category->cat_name !!}</span></a>
                </li>
            @endforeach
        </ul>
        <div class="top-block-slider-footer">
        </div>
    </div>
</div>

