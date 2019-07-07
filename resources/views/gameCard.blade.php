@foreach($games as $innerGame)
    <div class="game-card">
        <a href="{{ $innerGame->url }}" title="Игра {{ $innerGame->game_title }}">
            <img alt="{{ $innerGame->imgAlt }}" title="{{ $innerGame->imgTitle }}" src="{{ $innerGame->img }}">
            <span>{{ $innerGame->game_name }}</span>
        </a>
    </div>
@endforeach