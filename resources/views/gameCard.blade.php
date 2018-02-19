<div class="row">
    @foreach($games as $game)
        <div class="game-card col-sm-6 col-md-3">
            <div class="thumbnail">
                
                <h3><a class="game_link" href="{{ $game->url }}">zombie-2-player</a></h3>

                <img src="{{ $game->img }}" alt="123">
                <div class="caption">

                    <p>sgsfgsfdg</p>
                    <a href="{{ $game->url }}" class="btn btn-primary" role="button">PLAY</a>
                </div>
            </div>
        </div>
    @endforeach
</div>