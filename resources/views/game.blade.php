@extends('admin')

@section('title','Аddddd')

@section('right_content')
    <h1>{{ $game->game_name }}</h1>
    <div class="game_edit">
        <div class="game_form">
            <form class="game_edit_form" method="post" action="/admino4ka/editgame.php">
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
                            <p>{{ $game->category->cat_name }}</p>
                            <!--$game_all['cat_name']):echo $game_all['cat_name']; else: echo 'НЕТ';endif;?></p>-->
                            <select name="game_cat">
                                <option value="">не изменять</option>

                                <option value=""
                                </option>

                            </select>
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
                        <textarea name="game_desc" class="game_desc">{{ $game->desc }}</textarea>

                        <span> Управление: </span>
                        <textarea name="game_control" class="game_desc">{{ $game->game_control }}</textarea>
                    </div>
                    <input type="submit" value="Изменить">
                </div>
            </form>
            <div class="files">
                <div class="Imagine">
                    <span>Imagine:</span><input class="game_img"
                                                data-url="/admino4ka/upload.php?game_id={{ $game->game_id }}"
                                                name="game_img" type="file"></p>
                </div>
                <div class="flash">
                    <span>Flash:</span><input class="game_flash"
                                              data-url="/admino4ka/upload.php?game_id={{ $game->game_id }}"
                                              name="game_flash" type="file"></p>
                </div>
            </div>
            <div class="game_bottom">
                <form class="game__rename_delete" method="post" action="/admino4ka/editgame2.php">
                    <input name="game_id" type="hidden" value="{{ $game->game_id }}">
                    <div class="game_rename">
                        <span>Переименовать</span>
                        <input name="game_rename" type="text">
                    </div>
                    <div class="game_delete">
                        <span>Удалить</span>
                        <input name="game_delete" type="checkbox" value="1">
                    </div>
                    <input type="submit" value="Изменить">
                </form>
            </div>
        </div>
@endsection