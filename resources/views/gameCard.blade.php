<div class="row">
    @foreach($games as $game)
        <div class="col-sm-6 col-md-3">
            <div class="game-card">
                <a class="game_link" href="{{ $game->url }}">{{ $game->game_name }}dssd</a>
                <div class="game_img">
                    <a href="{{ $game->url }}"title="The flash game {{ $game->url }}"><img alt="image of the game {{ $game->name }}" src="{{ $game->img }}"></a>
                </div>

                <div class="det">
                    <a class="details" href="{{ $game->url }}">PLAY</a>
                    <img src="/img/like.png" alt="How many people like this game" title="like button">
                    <span class="likes">32</span>
                </div>

            </div>
        </div>
    @endforeach
</div>