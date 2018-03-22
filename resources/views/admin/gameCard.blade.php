@foreach($games as $game)
    <div class="col-md-4">
        <div class="game_card thumbnail">
            <a class="game_link" href="{{ $game->url }}">{{ $game->game_name }}</a>
            <div class="game_img">
                <a href="{{ $game->url }}"><img src="{{ $game->img }}"></a>
            </div>
            <div class="caption">
                <p><a href="{{ $game->url }}" class="btn btn-primary" role="button">Редактировать</a></p>
            </div>
        </div>
    </div>
@endforeach