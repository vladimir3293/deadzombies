@extends('layouts.adminLayout')
@section('right_content')
    {{--<h1><a href="{{ route('getCategory',[$category->cat_url]) }}" target="_blank">{{ $category->cat_name }}</a></h1>--}}
    <div class="cat_edit_other">
        <div class="form-group">
            <p>Изображения:</p>
            @if(!empty($page->imgExist))
                <div class="page-image-container">
                    @foreach($page->imgExist as $img)
                        <div class="page-image">
                            <a href="{{ route('admin.images.getImage',['image'=>$img->name]) }}">
                                <img src="/img/{{ $img->name }}-large.jpg"></a>
                            <span>title="{{$img->title}}" alt="{{$img->alt}}"</span>
                            <span>/img/{{ $img->name }}-small.jpg</span>
                            <span>/img/{{ $img->name }}.jpg</span>
                            <span>/img/{{ $img->name }}-large.jpg</span>
                            <form method="POST" action="/admin/images/{{ $img->name }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="pageId" value="{{$page->id}}">
                                <input class="btn btn-danger btn-sm" type="submit" value="Удалить">
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <form class="cat_edit_form" enctype="multipart/form-data" method="POST"
              action="/admin/images/">
            {{ method_field('POST') }}
            {{ csrf_field() }}
            <input type="hidden" name="pageId" value="{{$page->id}}">
            <input type="file" name="img">
            <input class="btn btn-primary btn-sm" type="submit" value="Добавить">
        </form>

        <form class="cat_edit_form" enctype="multipart/form-data" method="POST"
              action="/admin/pages/{{ $page->url }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <h1>Главная страница</h1>
            <div class="form-group">
                <label for="cat_title">Тайтл</label>
                <input class="form-control" id="cat_title" name="title" type="text"
                       value="{{ $page->title }}">
            </div>
            <div class="form-group">
                <label for="cat_title">h1</label>
                <input class="form-control" id="cat_title" name="h1" type="text"
                       value="{{ $page->h1 }}">
            </div>
            <div class="form-group">
                <label for="cat_desc_meta">Мета описание</label>
                <input class="form-control" id="cat_desc_meta" name="desc_meta" type="text"
                       value="{{ $page->desc_meta }}">
            </div>
            <div class="form-group">
                <label for="cat_key_meta">Мета ключи</label>
                <input class="form-control" id="cat_key_meta" name="desc_key" type="text"
                       value="{{ $page->desc_key }}">
            </div>
            <div class="form-group">
                <label for="cat_desc">Описание</label>
                <textarea id="summernote" class="form-control" rows="4" name="description"
                          class="cat_desc">{{ $page->description }}</textarea>
            </div>

            <input class="btn btn-primary" type="submit" value="Изменить">
        </form>
        <form class="delete-form" method="POST" action="/admin/pages/{{ $page->url }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input class="btn btn-danger" type="submit" value="Удалить">
        </form>
    </div>

@endsection
