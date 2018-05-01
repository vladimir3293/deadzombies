@extends('layouts.adminLayout')

@section('title','Создать категорию')

@section('right_content')
    <h1>Создать катеорию</h1>
    <div class="game_edit">
        <div class="game_form">
            <form method="post" action="/admin/category/" enctype="multipart/form-data" role="form">
                {{ method_field('POST') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="game_rename">Название игры</label>
                    <input class="form-control" name="create_category" id="game_rename" type="text">
                </div>
                <input class="btn btn-primary" type="submit" value="Создать">
            </form>
        </div>
    </div>
@endsection