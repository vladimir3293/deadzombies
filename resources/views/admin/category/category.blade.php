@extends('layouts.adminLayout')
@section('title',$category->cat_name)
@section('right_content')
    <h1><a href="{{ route('getCategory',[$category->cat_url]) }}" target="_blank">{{ $category->cat_name }}</a></h1>
    <div class="cat_edit_other">
        <form class="cat_edit_form" enctype="multipart/form-data" method="POST"
              action="/admin/category/{{ $category->cat_url }}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
                <div class="radio">
                    @if($category->display)
                        <label><input class="radio" name="display" type="radio" value="0">Не отображать</label>
                        <label><input class="radio" name="display" type="radio" value="1" checked="checked">Отображать
                        </label>
                    @else
                        <label><input class="radio" name="display" type="radio" value="0" checked="checked">Не
                            отображать</label>
                        <label><input class="radio" name="display" type="radio" value="1">Отображать</label>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="cat_rename">Переименовать</label>
                <input class="form-control" id="cat_rename" name="cat_rename" type="text">
            </div>
            <div class="form-group">
                <label for="cat_order">Порядок</label>
                <input class="form-control" id="cat_order" name="cat_order" type="number"
                       value="{{ $category->cat_order }}">
            </div>
            <div class="form-group">
                <label for="cat_title">Тайтл</label>
                <input class="form-control" id="cat_title" name="cat_title" type="text"
                       value="{{ $category->cat_title }}">
            </div>
            <div class="form-group">
                <label for="cat_desc_meta">Мета описание</label>
                <input class="form-control" id="cat_desc_meta" name="cat_desc_meta" type="text"
                       value="{{ $category->cat_desc_meta }}">
            </div>
            <div class="form-group">
                <label for="cat_key_meta">Мета ключи</label>
                <input class="form-control" id="cat_key_meta" name="cat_key_meta" type="text"
                       value="{{ $category->cat_key_meta }}">

            </div>
            <div class="form-group">
                <label for="cat_h1">h1</label>
                <input class="form-control" id="cat_title" name="h1" type="text"
                       value="{{ $category->h1 }}">
            </div>
            <div class="form-group">
                <label for="cat_desc">Описание</label>
                <textarea id="summernote" class="form-control" rows="4" name="cat_desc"
                          class="cat_desc">{{ $category->cat_desc }}</textarea>
            </div>

            <div class="form-group">
                <p>Главное изображение:</p>
                @if(!empty($category->mainImg))
                    <img src="/img/{{ $category->mainImg->name }}.jpg">
                @else
                    <span>НЕТ</span>
                @endif
            </div>

            <input class="btn btn-primary" type="submit" value="Изменить категорию">
        </form>

        <div class="form-group">
            <h1>Доступные изображения:</h1>
            @if(!empty($category->imgExist))
                <div class="page-image-container">
                    @foreach($category->imgExist as $img)
                        <div class="page-image">
                            <div class="page-image-leftside">
                                <a href="{{ route('admin.images.getImage',['image'=>$img->name]) }}">
                                    <img src="/img/{{ $img->name }}-large.jpg"></a>
                            </div>
                            <div class="page-image-rightside">
                                <span>title="{{$img->title}}" alt="{{$img->alt}}"</span>
                                <p><strong>SMALL</strong> /img/{{ $img->name }}-small.jpg</p>
                                <p><strong>MEDIUM</strong> /img/{{ $img->name }}.jpg</p>
                                <p><strong>LARGE</strong> /img/{{ $img->name }}-large.jpg</p>
                            </div>
                            <form method="POST" action="/admin/images/{{ $img->name }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="categoryId" value="{{$category->id}}">
                                <input class="btn btn-danger btn-sm" type="submit" value="Удалить">
                                @if($img->main_img)
                                    <span>Главное</span>
                                @endif
                            </form>

                        </div>
                    @endforeach
                </div>
            @endif
            <form class="cat_edit_form" enctype="multipart/form-data" method="POST"
                  action="/admin/images/">
                {{ method_field('POST') }}
                {{ csrf_field() }}
                <input type="hidden" name="categoryId" value="{{$category->id}}">
                <input type="file" name="img">
                <input class="btn btn-primary btn-sm" type="submit" value="Добавить">
            </form>
        </div>

    </div>

    <h1>Теги: {{ $tagsCount }}</h1>

    @foreach($tagsCategory as $tagCategory)
        <form method="post" action="/admin/category/tag/{{ $category->cat_url }}">
            <div class="form-group">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <input name="tagId" type="hidden" value="{{ $tagCategory->id }}">
                <input class="btn btn-danger" type="submit" value="Удалить тег">
                <label><a href="{{ route('admin.getTag',[$tagCategory->url]) }}">{{ $tagCategory->name }}</a></label>
                <span>@if($tagCategory->display)Отображается@elseНЕ отображается@endif</span>
            </div>
        </form>
    @endforeach
    <form method="post" action="/admin/category/tag/{{ $category->cat_url }}">
        {{ method_field('POST') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="game_cat">Добавить тег</label>
            <select class="form-control" name="tagId">
                @foreach($tagsAll as $tagAll)
                    <option value="{{ $tagAll->id }}">{{ $tagAll->name }}</option>
                @endforeach
            </select>
        </div>
        <input class="btn btn-primary" type="submit" value="Добвать тег">
    </form>

    <article>
        <header class="article-header">
            <h1>Игры в категории: {{ $gamesCount }}</h1>
        </header>
        <header class="article-header">
            <h1>Опубликованые игры: {{ $gamesPublishCount }}</h1>
        </header>
        @if($gamesPublish->isNotEmpty())
            <div class="row">
                @include('admin.gameCard',['games'=>$gamesPublish])
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $gamesPublish->links('vendor.pagination.default') }}
                </div>
            </div>
        @endif
        <header class="article-header">
            <h1>Не опубликованые игры: {{ $gamesUnpublishCount }}</h1>
        </header>
        @if($gamesUnpublish->isNotEmpty())
            <div class="row">
                @include('admin.gameCard',['games'=>$gamesUnpublish])
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $gamesUnpublish->links('vendor.pagination.default') }}
                </div>
            </div>
        @endif
    </article>
    <form class="delete-form" method="POST" action="/admin/category/{{ $category->cat_url }}">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <input class="btn btn-danger" type="submit" value="Удалить категорию">
    </form>
@endsection
