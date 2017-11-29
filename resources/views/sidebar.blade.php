<a href="/"><img src="/img/logotype.png" alt="logotype"></a>
<div class="sidebar_inner">


    <div class="headline_others">
        <img src="/img/top-games.png">
        <span>TOP GAMES</span>
    </div>
    <div class="n_block">
        @if(isset($topGames))
            @foreach($topGames as $game)
                <div class="line">
                    <a href="{{ $game->url }}"><img
                                alt="{{ $game->game_name }}"
                                src="{{ $game->img_url }}"></a>
                    <div class="right">
                        <a href="{{ $game->url }}">{{ $game->game_name }}</a>
                        <p class="playSide">Played:{{ $game->game_played }}</p>
                        <img src="/img/like.png" alt="How many people like this game" title="like button">
                        <p class="likeSidebar">{{ $game->game_like }}</p>
                        <div class="clr"></div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>


    <ul class="main_menu">
        <li><a href="/">Home page</a></li>
        @if(isset($menu))
            @foreach($menu as $category)
                <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
            @endforeach
        @endif
    </ul>


    <div class="headline_others">
        <img src="/img/new-games.png">
        <span>NEW GAMES</span>
    </div>
    <div class="n_block">
        @if(isset($newGames))
            @foreach($newGames as $game)
                <div class="line">
                    <a href="{{ $game->url }}"><img
                                alt="{{ $game->game_name }}"
                                src="{{ $game->imgUrl }}"></a>
                    <div class="right">
                        <a href="{{ $game->url }}">{{ $game->game_name }}</a>
                        <div class="clr"></div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>


