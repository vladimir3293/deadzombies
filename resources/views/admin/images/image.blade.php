@extends('layouts.adminLayout')
@section('right_content')
    {{--<h1><a href="{{ route('getCategory',[$category->cat_url]) }}" target="_blank">{{ $category->cat_name }}</a></h1>--}}
    <div class="image-edit">
        <form class="cat_edit_form" enctype="multipart/form-data" method="POST"
              action="/admin/images/{{ $image->name }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <h1>{{ $image->name }}</h1>
            <img src="/img/{{ $image->name }}.jpg">
            <div class="form-group">
                <label for="cat_title">Тайтл</label>
                <input class="form-control" id="cat_title" name="title" type="text"
                       value="{{ $image->title }}">
            </div>
            <div class="form-group">
                <label for="cat_desc_meta">Альтернативный текст</label>
                <input class="form-control" id="cat_desc_meta" name="alt" type="text"
                       value="{{ $image->alt }}">
            </div>
            <div class="form-group image-edit-main">
                <label for="cat_desc_meta">Главное изображение</label>
                <input class="form-control" id="cat_desc_meta" name="main_img" type="checkbox"
                       value="true" @if($image->main_img)checked
                        @endif>
            </div>
            <input class="btn btn-primary" type="submit" value="Применить">
        </form>
        <form class="delete-form" method="POST" action="/admin/page/{{ $image->name }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input class="btn btn-danger" type="submit" value="Удалить">
        </form>
    </div>
@endsection
