@extends('layouts.adminLayout')

@section('title',$game->game_name)

@section('right_content')
    <h1>{{ $game->game_name }}</h1>
    <div class="form-group">
        <div class="radio">
            @if($game->game_show)
                <label><input class="radio" name="game_show" type="radio" value="0">Не отображать</label>
                <label><input class="radio" name="game_show" type="radio" value="1" checked="checked">Отображать
                </label>
            @else
                <label><input class="radio" name="game_show" type="radio" value="0" checked="checked">Не
                    отображать</label>
                <label><input class="radio" name="game_show" type="radio" value="1">Отображать</label>
            @endif
        </div>
    </div>
    <div class="game_edit">
        <div class="game_form">
            <form method="post" action="/admin/game/{{ $game->game_url }}" enctype="multipart/form-data" role="form">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="game_rename">Переименовать</label>
                    <input class="form-control" name="game_rename" id="game_rename" type="text">
                </div>
                <div class="form-group">
                    <label for="game_cat">Категория: {{ $game->cat }}</label>
                    <select class="form-control" id="game_cat" name="game_cat">
                        <option value="0" selected>не изменять</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->cat_id }}">{{ $category->cat_url }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label><input class="checkbox" name="del_cat" type="checkbox" value="1">Убрать категорию</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="game_title">Тайтл:</label>
                    <input class="form-control" id="game_title" name="game_title" type="text"
                           value="{{ $game->game_title }}">
                </div>

                <div class="form-group">
                    <label for="game_desc_meta">Мета описание:</label>
                    <input class="form-control" id="game_desc_meta" name="game_desc_meta" type="text"
                           value="{{  $game->game_desc_meta }}">
                </div>

                <div class="form-group">
                    <label for="game_key_meta">Мета ключи:</label>
                    <input class="form-control" id="game_key_meta" name="game_key_meta" type="text"
                           value="{{ $game->game_key_meta }}">
                </div>

                <div class="form-group">
                    <label for="game_desc"> Описание: </label>
                    <textarea class="form-control" id="game_desc" name="game_desc" class="game_desc" rows="4">
                        {{ $game->game_desc }}</textarea>
                </div>
                <div class="form-group">
                    <label for="game_control"> Управление: </label>
                    <textarea class="form-control" name="game_control" id="game_control"
                              class="game_desc">{{ $game->game_control }}</textarea>
                </div>
                <div class="form-group">
                    <label for="source">Ссылка на игру</label>
                    <input class="form-control" type="text" name="source" id="source" value="{{ $game->source }}">
                </div>
                <div class="form-group">
                    <p>Изображение 1 {{ $game->img1 }}</p>
                    <input class="form-control" type="file" name="img1">
                </div>
                <div class="form-group">
                    <p>Изображение 2 {{ $game->img2 }}</p>
                    <input class="form-control" type="file" name="img2">
                </div>
                <div class="form-group">
                    <p>Изображение 3 {{ $game->img3 }}</p>
                    <input class="form-control" type="file" name="img3">
                </div>
                <input class="btn btn-primary" type="submit" value="Применить">
            </form>
            <form class="delete-form" method="post" action="/admin/game/{{ $game->game_url }}">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <div class="game_delete">
                    <input class="btn btn-danger" type="submit" value="Удалить">
                </div>
            </form>
        </div>
    </div>

    <div class="flash">

        <iframe src="{{ $game->source }}"
                name="topFrame"
                scrolling="no"
                height="{{ $game->gameHeight }}"
                width="100%">
        </iframe>

    </div>

@endsection