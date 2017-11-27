@extends('layouts.layout')

@section('title','Аddddd')

@section('right_content')
    <h1>{{ $game->game_name }}</h1>

        <!--<div class="files">
                <form method="post" action=""
                /admin/game/{{ $game->game_url }}" enctype="multipart/form-data">
                <input type="file" name="image">
                <button type="submit">Отп</button>
                </form>-->


            <div class="game_delete">
                <span>Удалить</span>
                <input name="game_delete" type="checkbox" value="1">
            </div>
            <input type="submit" value="Изменить">
            </form>
        </div>
    </div>
@endsection