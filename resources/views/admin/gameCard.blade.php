@foreach($games as $game)
    <div class="game_card">
        <a class="game_link" href="{{ $game->url }}">{{ $game->game_name }}</a>
        <div class="game_img">
            <a href="{{ $game->url }}"><img src="{{ $game->img }}"></a>
        </div>
    </div>
@endforeach