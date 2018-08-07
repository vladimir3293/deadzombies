@foreach($games as $game)
    <div class="game-card">
        <a href="{{ $game->url }}" title="The flash game {{ $game->url }}">
            <img alt="image of the game {{ $game->game_name }}" src="{{ $game->img }}">
            <span>{{ $game->game_name }}</span>
        </a>
    </div>
@endforeach