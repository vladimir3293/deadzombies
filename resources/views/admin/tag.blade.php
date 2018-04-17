@extends('layouts.adminLayout')

@section('title','Тег')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>{{ $tag->name }}</h1>
        </header>
    </article>
    <form method="post" action="/admin/game/{{ $tag->url }}" enctype="multipart/form-data" role="form">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="form-group">
            <label for="game_rename">Переименовать</label>
            <input class="form-control" name="game_rename" id="game_rename" type="text">
        </div>

        <div class="form-group">
            <label for="game_title">Тайтл:</label>
            <input class="form-control" id="game_title" name="title" type="text"
                   value="{{ $tag->title }}">
        </div>

        <div class="form-group">
            <label for="game_desc_meta">Мета описание:</label>
            <input class="form-control" id="game_desc_meta" name="metaDesc" type="text"
                   value="{{  $tag->meta_desc }}">
        </div>

        <div class="form-group">
            <label for="game_key_meta">Мета ключи:</label>
            <input class="form-control" id="game_key_meta" name="metaKey" type="text"
                   value="{{ $tag->meta_key }}">
        </div>

        <div class="form-group">
            <label for="game_desc"> Описание: </label>
            <textarea class="form-control" id="game_desc" name="tagDesc" class="game_desc" rows="4">{{ $tag->desc }}</textarea>
        </div>
        <input class="btn btn-primary" type="submit" value="Изменить">
    </form>

@endsection
