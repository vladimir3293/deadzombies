@extends('layouts.adminLayout')

@section('title','Тег')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>{{ $tag->name }}</h1>
        </header>
        <div class="row">
            <form method="post" action="/admin/tag/{{ $tag->url }}" enctype="multipart/form-data" role="form">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="game_rename">Переименовать</label>
                    <input class="form-control" name="tagRename" id="game_rename" type="text">
                </div>

                <div class="form-group">
                    <label for="game_title">Тайтл:</label>
                    <input class="form-control" id="game_title" name="tagTitle" type="text"
                           value="{{ $tag->title }}">
                </div>

                <div class="form-group">
                    <label for="game_desc_meta">Мета описание:</label>
                    <input class="form-control" id="game_desc_meta" name="tagMetaDesc" type="text"
                           value="{{  $tag->meta_desc }}">
                </div>

                <div class="form-group">
                    <label for="game_key_meta">Мета ключи:</label>
                    <input class="form-control" id="game_key_meta" name="tagMetaKey" type="text"
                           value="{{ $tag->meta_key }}">
                </div>

                <div class="form-group">
                    <label for="game_desc"> Описание: </label>
                    <textarea class="form-control" id="game_desc" name="tagDesc" class="game_desc"
                              rows="4">{{ $tag->description }}</textarea>
                </div>
                <input class="btn btn-primary" type="submit" value="Изменить">
            </form>
        </div>
        <div class="row">
            <form method="post" action="/admin/tag/addtag/{{ $tag->url }}">
                {{ method_field('POST') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="game_cat">Добавить подтег</label>
                    <select class="form-control" name="tagId">
                        @foreach($tagsAll as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input class="btn btn-primary" type="submit" value="Добвать тег">
            </form>
            <p>Подтеги:</p>
            @if(!empty($tags))
                @foreach($tags as $tag)
                    <p><a href="{{ route('admin.getTag',[$tag->url]) }}">{{ $tag->name }}</a></p>
                @endforeach
            @endif
        </div>
        <div class="row">
            <div class="col-md-4">
                <p>Игры:</p>
                @if(!empty($games))
                    @foreach($games as $game)
                        <p><a href="{{ route('admin.getGame',[$game->game_url]) }}">{{ $game->game_name }}</a></p>
                    @endforeach
                @endif
            </div>
            <div class="col-md-4">
                <p>Родительские теги:</p>
                @if(!empty($belongTag))
                    @foreach($belongTag as $tag)
                        <p><a href="{{ route('admin.getTag',[$tag->url]) }}">{{ $tag->name }}</a></p>
                    @endforeach
                @endif
            </div>
            <div class="col-md-4">
                <p>Категории:</p>
                @if(!empty($categories))
                    @foreach($categories as $cat)
                        <p><a href="{{ route('admin.getTag',[$cat->cat_url]) }}">{{ $cat->cat_name }}</a></p>
                    @endforeach
                @endif
            </div>
        </div>
    </article>
@endsection
