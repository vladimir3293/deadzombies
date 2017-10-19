@extends('admin')
@section('right_content')
    <h1>{{ $category->cat_name }}</h1>
    <div class="cat_edit_other">
        <form class="cat_edit_form" method="POST" action="/admin/category/{{ $category->cat_url }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="cat_rename">
                <span>Переименовать</span>
                <input name="cat_rename" type="text">
            </div>
            <div class="cat_order">
                <span>Порядок</span>
                <input name="cat_order" type="number" value="{{ $category->cat_order }}">
            </div>
            <div class="cat_rename">
                <span>Тайтл</span>
                <input name="cat_title" type="text" value="{{ $category->cat_title }}">
            </div>
            <div class="cat_rename">
                <span>Мета описание</span>
                <input name="cat_desc_meta" type="text" value="{{ $category->cat_desc_meta }}">
            </div>
            <div class="cat_rename">
                <span>Мета ключи</span>
                <input name="cat_key_meta" type="text" value="{{ $category->cat_key_meta }}">
            </div>
            <div class="cat_rename">
                <span>Заголовок h1</span>
                <input name="cat_h1" type="text" value="{{ $category->cat_h1 }}">
            </div>

            <textarea name="cat_desc" class="cat_desc">{{ $category->cat_desc }}</textarea>
            <input type="submit" value="Изменить">
        </form>
        <form class="cat_edit_form" method="POST" action="/admin/category/{{ $category->cat_url }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input type="submit" value="Удалить">
        </form>
    </div>
    @parent
@endsection
