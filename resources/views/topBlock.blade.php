<header class="top-block">
    <div class="top-block-slider">
        <div class="top-block-slider-header">

        </div>
        <ul>
            <li><a href="/">Главная</a></li>
            @foreach($categories as $category)
                <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
            @endforeach
        </ul>
        <div class="top-block-slider-footer">

        </div>

    </div>
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
    </div>
</header>
