@extends('layouts.adminLayout')

@section('title','Tags')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Теги: {{ $tagsCount }}</h1>
        </header>
        <form method="post" enctype="multipart/form-data" role="form">
            {{ method_field('POST') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="game_rename">Сохдать тег</label>
                <input class="form-control" name="page_number" id="game_rename" type="number">
            </div>
            <input class="btn btn-primary" type="submit" value="Начать">
        </form>
        @foreach($tags as $tag)
            <form method="post" enctype="multipart/form-data" role="form">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="game_rename">{{ $tag->name }}</label>
                    <input class="form-control" name="page_number" id="game_rename" type="number">
                </div>
                <input class="btn btn-primary" type="submit" value="Изменить">
            </form>
            <form method="post" enctype="multipart/form-data" role="form">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="game_rename">{{ $tag->name }}</label>
                    <input class="form-control" name="page_number" id="game_rename" type="number">
                </div>
                <input class="btn btn-primary" type="submit" value="Удалить">
            </form>
        @endforeach
    </article>
@endsection
