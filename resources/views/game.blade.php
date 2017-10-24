@extends('admin')

@section('title','Аddddd')

@section('right_content')
    <h1>{{ $game->game_name }}</h1>
    <div class="game_edit">
        <div class="game_form">
            <form class="game_edit_form" method="post" action="/admin/game/{{ $game->game_url }}"
                  enctype="multipart/form-data">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="game_rename">
                    <span>Переименовать</span>
                    <input name="game_rename" type="text">
                </div>
                <div class="game_show">
                    <span> Отображение: </span>
                    @if($game->game_show)
                        <p><input name="game_show" type="radio" value="0">Не отображать</p>
                        <p><input name="game_show" type="radio" value="1" checked="checked">Отображать</p>
                    @else
                        <p><input name="game_show" type="radio" value="0" checked="checked">Не отображать</p>
                        <p><input name="game_show" type="radio" value="1">Отображать</p>
                    @endif
                </div>
                <div class="game_edit_other">
                    <div class="game_cat">
                        <span>Категория:</span>
                        <p class="game_cat_name">
                        <p>{{ $game->cat }}</p>
                        <select name="game_cat">
                            <option value="0" selected>не изменять</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->cat_id }}">{{ $category->cat_url }}</option>
                            @endforeach
                        </select>
                        <div class="game_delete">
                            <span>Убрать категорию</span>
                            <input name="del_cat" type="checkbox" value="1">
                        </div>
                    </div>
                    <div class="game_rename">
                        <span>Тайтл:</span>
                        <input name="game_title" type="text" value="{{ $game->game_title }}">
                    </div>
                    <div class="game_rename">
                        <span>Мета описание:</span>
                        <input name="game_desc_meta" type="text" value="{{  $game->game_desc_meta }}">
                    </div>
                    <div class="game_rename">
                        <span>Мета ключи:</span>
                        <input name="game_key_meta" type="text" value="{{ $game->game_key_meta }}">
                    </div>
                    <div class="game_desc">
                        <span> Описание: </span>
                        <textarea name="game_desc" class="game_desc">{{ $game->game_desc }}</textarea>

                        <span> Управление: </span>
                        <textarea name="game_control" class="game_desc">{{ $game->game_control }}</textarea>
                        <input type="file" name="image">
                    </div>
                    <input type="submit" value="Изменить">
                </div>
            </form>

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