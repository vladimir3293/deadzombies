@foreach($games as $game)
    <div class="col-md-4">
        <div class="game-card thumbnail">
            <h4><a href="{{ $game->url }}">{{ $game->game_name }}</a></h4>
            <div class="game-img">
                <a href="{{ $game->url }}"><img src="{{ $game->img }}"></a>
            </div>
            <a href="{{ $game->url }}" class="btn btn-primary game-card-button" role="button">Редактировать</a>
        </div>
    </div>
@endforeach