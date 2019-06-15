@extends('layouts.adminLayout')

@section('title',$tag->name)


@section('right_content')
    <article>
        <header class="article-header">
            <h1><a href="{{ route('getTag',[$tag->url])}}" target="_blank">{{ $tag->name }}</a></h1>
        </header>
        <form method="post" action="/admin/tag/{{ $tag->url }}" enctype="multipart/form-data" role="form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
                <div class="radio">
                    @if($tag->display)
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
                <label for="game_rename">Переименовать</label>
                <input class="form-control" name="tagRename" id="game_rename" type="text">
            </div>

            <div class="form-group">
                <label for="game_title">Тайтл:</label>
                <input class="form-control" id="game_title" name="tagTitle" type="text"
                       value="{{ $tag->title }}">
            </div>
            <div class="form-group">
                <label for="game_title">h1</label>
                <input class="form-control" id="game_title" name="tagH1" type="text"
                       value="{{ $tag->h1 }}">
            </div>
            <div class="form-group">
                <label for="game_desc_meta">Мета описание:</label>
                <input class="form-control" id="game_desc_meta" name="tagMetaDesc" type="text"
                       value="{{  $tag->meta_desc }}">
            </div>

            <div class="form-group">
                <label for="game_key_meta">Мета ключи:</label>
                <input class="form-control" id="game_key_meta" name="tagMetaKey" type="text"
                       value="{{ $tag->meta_key }}">
            </div>

            <div class="form-group">
                <label for="game_desc"> Описание: </label>
                <textarea class="form-control" id="summernote" name="tagDesc" class="game_desc"
                          rows="4">{{ $tag->description }}</textarea>
            </div>
            <div class="form-group">
                <p>Изображение:</p>
                @if(!empty($tag->mainImg))
                    <img src="/img/{{ $tag->mainImg->name }}.jpg">
                @else
                    <span>НЕТ</span>
                @endif
            </div>
            <input class="btn btn-primary" type="submit" value="Изменить тег">
        </form>


        <div class="rfow">
            <h4>Подтеги:</h4>
            @if(!empty($subTags))
                @foreach($subTags as $subTag)
                    <form method="post" action="/admin/tag/subtag/{{ $tag->url }}">
                        <div class="form-group">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}

                            <input name="tagId" type="hidden" value="{{ $subTag->id }}">
                            <input class="btn btn-danger" type="submit" value="Удалить подтег">
                            <label><a href="{{ route('admin.getTag',[$subTag->url]) }}">{{ $subTag->name }}</a></label>
                            <span>@if($subTag->display)Отображается@elseНЕ отображается@endif</span>
                        </div>
                    </form>
                @endforeach
            @endif
        </div>
        <form method="post" action="/admin/tag/subtag/{{ $tag->url }}">
            {{ method_field('POST') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="game_cat">Добавить подтег</label>
                <select class="form-control" name="tagId">
                    @foreach($tagsAll as $oneTag)
                        <option value="{{ $oneTag->id }}">{{ $oneTag->name }}</option>
                    @endforeach
                </select>
            </div>
            <input class="btn btn-primary" type="submit" value="Добвать подтег">
        </form>
        <div class="fdorm-group">
            <p>Доступные изображения:</p>
            @if(!empty($tag->imgExist))
                <div class="page-image-container">
                    @foreach($tag->imgExist as $img)
                        <div class="page-image">
                            <div class="page-image-leftside">
                                <a href="{{ route('admin.images.getImage',['image'=>$img->name]) }}">
                                    <img src="/img/{{ $img->name }}-large.jpg"></a>
                            </div>
                            <div class="page-image-rightside">
                                <p>title="{{$img->title}}" alt="{{$img->alt}}"</p>
                                <p><strong>SMALL</strong> /img/{{ $img->name }}-small.jpg</p>
                                <p><strong>MEDIUM</strong> /img/{{ $img->name }}.jpg</p>
                                <p><strong>LARGE</strong> /img/{{ $img->name }}-large.jpg</p>
                            </div>
                            <form method="POST" action="/admin/images/{{ $img->name }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="tagId" value="{{ $tag->id}}">
                                <input class="btn btn-danger btn-sm" type="submit" value="Удалить">
                                @if($img->main_img)
                                    <span>Главное</span>
                                @endif
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
            <input type="hidden" name="tagId" value="{{ $tag->id }}">
            <input type="file" name="img">
            <input class="btn btn-primary btn-sm" type="submit" value="Добавить изображение">
        </form>
        {{--            </div>--}}
        {{--        </div>--}}
        <h4>Принедлежит:</h4>
        <div class="col-md-4">
            <p>Игры:</p>
            @if(!empty($games))
                @foreach($games as $game)
                    <p><a href="{{ route('admin.getGame',[$game->id]) }}">{{ $game->game_name }}</a></p>
                @endforeach
            @endif
        </div>
        <div class="col-md-4">
            <p>Родительские теги:</p>
            @if(!empty($belongTags))
                @foreach($belongTags as $belongTag)
                    <p><a href="{{ route('admin.getTag',[$belongTag->url]) }}">{{ $belongTag->name }}</a></p>
                @endforeach
            @endif
        </div>
        <div class="col-md-4">
            <p>Категории:</p>
            @if(!empty($categories))
                @foreach($categories as $cat)
                    <p><a href="{{ route('admin.getCategory',[$cat->cat_url]) }}">{{ $cat->cat_name }}</a></p>
                @endforeach
            @endif
        </div>
        <form class="delete-form col-md-12 game-delete" method="POST" action="/admin/tag/{{ $tag->url }}">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <input class="btn btn-danger" type="submit" value="Удалить тег">
        </form>
    </article>
@endsection
