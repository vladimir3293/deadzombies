@extends('layouts.adminLayout')
@section('right_content')
    <h1><a href="{{ route('getCategory',[$category->cat_url]) }}" target="_blank">{{ $category->cat_name }}</a></h1>
    <div class="cat_edit_other">
        <form class="cat_edit_form" method="POST" action="/admin/category/{{ $category->cat_url }}">
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
                <label for="cat_desc">Описание</label>
                <textarea id="cat_desc" class="form-control" rows="4" name="cat_desc"
                          class="cat_desc">{{ $category->cat_desc }}</textarea>
            </div>
            <input class="btn btn-primary" type="submit" value="Изменить">
        </form>
        <form class="delete-form" method="POST" action="/admin/category/{{ $category->cat_url }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input class="btn btn-danger" type="submit" value="Удалить">
        </form>
    </div>

    <h4>Теги: {{ $tagsCount }}</h4>

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
@endsection
