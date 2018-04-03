@extends('layouts.adminLayout')
@section('right_content')
    <h1>{{ $category->cat_name }}</h1>
    <div class="cat_edit_other">
        <form class="cat_edit_form" method="POST" action="/admin/category/{{ $category->cat_url }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="cat_rename">Переименовать</label>
                <input class="form-control" id="cat_rename" name="cat_rename" type="text">
            </div>
            <div class="form-group">
                <label for="cat_order">Порядок</label>
                <input class="form-control" id="cat_order" name="cat_order" type="number" value="{{ $category->cat_order }}">
            </div>
            <div class="form-group">
                <label for="cat_title">Тайтл</label>
                <input class="form-control" id="cat_title" name="cat_title" type="text" value="{{ $category->cat_title }}">
            </div>
            <div class="form-group">
                <label for="cat_desc_meta">Мета описание</label>
                <input class="form-control" id="cat_desc_meta" name="cat_desc_meta" type="text" value="{{ $category->cat_desc_meta }}">
            </div>
            <div class="form-group">
                <label for="cat_key_meta">Мета ключи</label>
                <input class="form-control" id="cat_key_meta" name="cat_key_meta" type="text" value="{{ $category->cat_key_meta }}">
            </div>
            <div class="form-group">
             <label for="cat_desc">Описание</label>
            <textarea id="cat_desc" class="form-control" rows="4" name="cat_desc" class="cat_desc">{{ $category->cat_desc }}</textarea>
            </div>
                <input class="btn btn-primary" type="submit" value="Изменить">
        </form>
        <form class="delete-form" method="POST" action="/admin/category/{{ $category->cat_url }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input class="btn btn-danger" type="submit" value="Удалить">
        </form>
    </div>
    <article>
        <header class="article-header">
            <h1>Игры в категории</h1>
        </header>
        @if(isset($games))
            <div class="row">
                @include('admin.gameCard')
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $games->links() }}
                </div>
        @endif
    </article>
@endsection
