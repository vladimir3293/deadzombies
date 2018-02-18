{{--
@foreach($games as $game)
    <div class="game-card col-md-4">
        <a class="game_link" href="{{ $game->url }}">{{ $game->game_name }}</a>
        <div class="game-img">
            <a href="{{ $game->url }}"><img src="{{ $game->img }}"></a>
        </div>
    </div>
@endforeach
--}}
<div class="row">
    @foreach($games as $game)
        <div class="game-card col-sm-6 col-md-4">
            <div class="thumbnail">
                <h3>Thumbnail label</h3>

                <img src="{{ $game->img }}" alt="123">
                <div class="caption">

                    <p>sgsfgsfdg</p>
                    <p><a href="{{ $game->url }}" class="btn btn-primary" role="button">Button</a>
                        <a href="{{ $game->url }}" class="btn btn-default" role="button">Button</a></p>
                </div>
            </div>
        </div>
    @endforeach
</div>