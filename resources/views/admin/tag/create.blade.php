@extends('layouts.adminLayout')

@section('title','Tags')


@section('right_content')
    <article>
        <form action="/admin/tag/" method="post" enctype="multipart/form-data" role="form">
            {{ method_field('POST') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="game_rename">Создать тег</label>
                <input class="form-control" name="tagName" type="text">
            </div>
            <input class="btn btn-primary" type="submit" value="Создать тег">
        </form>

    </article>
@endsection
