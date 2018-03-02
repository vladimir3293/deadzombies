<div class="row">
    @foreach($games as $game)
        <div class="col-sm-12 col-md-6">
            <div class="game-card">
                <a class="game-card-link" href="{{ $game->url }}">{{ $game->game_name }}dssd</a>
                <div class="game-card-img">
                    <a href="{{ $game->url }}" title="The flash game {{ $game->url }}"><img alt="image of the game {{ $game->name }}" src="{{ $game->img }}"></a>
                </div>
                <div class="game-card-desc">
                    <a href="{{ $game->url }}">PLAY</a>
                    <img src="/img/like.png" alt="How many people like this game" title="like button">
                    <span>32</span>
                </div>
            </div>
        </div>
    @endforeach
</div>