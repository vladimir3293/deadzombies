@extends('layouts.adminLayout')

@section('title',$game->game_name)

@section('right_content')
    <h1><a href="{{ route('getGame',[$game->game_url])}}" target="_blank">{{$game->game_name }}</a></h1>
    <div class="game_edit">
        <div class="game_form">
            <form method="post" action="/admin/game/{{ $game->game_url }}" enctype="multipart/form-data" role="form">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
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
                <div class="form-group">
                    <label for="game_rename">Переименовать</label>
                    <input class="form-control" name="game_rename" id="game_rename" type="text">
                </div>
                <div class="form-group">
                    <label for="game_cat">Категория: {!! $game->cat !!}</label>
                    <select class="form-control" id="game_cat" name="game_cat">
                        <option value="0" selected>не изменять</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->cat_name }}</option>
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
                    <textarea class="form-control" id="game_desc" name="game_desc" class="game_desc"
                              rows="4">{{ $game->game_desc }}</textarea>
                </div>
                <div class="form-group">
                    <label for="game_control"> Управление: </label>
                    <textarea class="form-control" name="game_control" id="game_control"
                              class="game_desc">{{ $game->game_control }}</textarea>
                </div>
                <div class="form-group">
                    <label for="source">Ссылка на игру</label>
                    <input class="form-control" type="text" name="source" id="source" value="{{ $game->source }}">
                    <iframe id="game-player"
                            data-src="{{ $game->source }}"
                            frameborder="0"
                            name="topFrame"
                            scrolling="no"
                            allowfullscreen="true"
                            allowtransparency="true"
                            {{--style="margin: 50px;"--}}
                            {{--height="100vh" ;--}}
                            {{--width="{{ $game->number }}vh"--}}
                            {{--height="{{ $game->gameHeight }}"--}}
                            {{--width="{{ $game->gameWidth }}"--}}
                    >
                    </iframe>
                    <span id="show-game" class="btn btn-primary">Показать игру</span>
                </div>
                <div class="form-group">
                    <label for="source">Высота:</label>
                    <input class="form-control" type="text" name="height" id="source" value="{{ $game->height }}">
                </div>
                <div class="form-group">
                    <label for="source">Ширина:</label>
                    <input class="form-control" type="text" name="width" id="source" value="{{ $game->width }}">
                </div>
                <div class="form-group">
                    <p>Изображение {{ $game->imgExist }}</p>
                    @if($game->imgExist != 'НЕТ')
                        <img src="/img/{{ $game->game_url }}.jpg">
                    @endif
                    <input class="form-control" type="file" name="img">
                </div>
                <input class="btn btn-primary" type="submit" value="Применить">
            </form>

        </div>
        <h4>Теги:</h4>

        @foreach($tagsGame as $tagGame)
            <form method="post" action="/admin/game/tag/{{ $game->game_url }}">
                <div class="form-group">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}

                    <input name="tagId" type="hidden" value="{{ $tagGame->id }}">
                    <input class="btn btn-danger" type="submit" value="Удалить тег">
                    <label><a href="{{ route('admin.getTag',[$tagGame->url]) }}">{{ $tagGame->name }}</a></label>
                    <span>@if($tagGame->display)Отображается@elseНЕ отображается@endif</span>
                </div>
            </form>
        @endforeach
        <form method="post" action="/admin/game/tag/{{ $game->game_url }}">
            {{ method_field('POST') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="game_cat">Добавить тег</label>
                <select class="form-control" name="tagId">
                    @foreach($tagsAll as $tagAll)
                        <option value="{{ $tagAll->id }}">{{ $tagAll->name }}</option>
                    @endforeach
                </select>
            </div>
            <input class="btn btn-primary" type="submit" value="Добвать тег">
        </form>
    </div>

    <div class="flash">

        {{--<iframe src="{{ $game->source }}"--}}
                {{--name="topFrame"--}}
                {{--scrolling="no"--}}
                {{--height="{{ $game->height }}"--}}
                {{--width="{{ $game->width }}">--}}
        {{--</iframe>--}}

    </div>

    <form method="post" action="/admin/game/{{ $game->game_url }}">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input class="btn btn-danger" type="submit" value="Удалить игру">
    </form>

@endsection