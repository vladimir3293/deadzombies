@foreach($games as $innerGame)
    <div class="game-card">
        <a href="{{ $innerGame->url }}" title="The flash game {{ $innerGame->url }}">
            <img alt="image of the game {{ $innerGame->game_name }}" src="{{ $innerGame->img }}">
            <span>{{ $innerGame->game_name }}</span>
        </a>
    </div>
@endforeach