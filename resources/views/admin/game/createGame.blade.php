@extends('layouts.adminLayout')

@section('title','Создать игру')

@section('right_content')
    <h1>Создать игру</h1>
    <div class="game_edit">
        <div class="game_form">
            <form method="post" action="/admin/game/" enctype="multipart/form-data" role="form">
                {{ method_field('POST') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="game_rename">Название игры</label>
                    <input class="form-control" name="create_game" id="game_rename" type="text">
                </div>
                <input class="btn btn-primary" type="submit" value="Создать">
            </form>
        </div>
    </div>
@endsection