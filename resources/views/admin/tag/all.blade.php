@extends('layouts.adminLayout')

@section('title','Все теги')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Теги: {{ $tagsCount }}</h1>
        </header>
        @foreach($tags as $tag)
            <form action="/admin/tag/{{ $tag->url }}" class="form-inline" method="post" enctype="multipart/form-data"
                  role="form">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <input class="btn btn-danger" type="submit" value="Удалить тег">
                    <a href="{{ route('admin.getTag',[$tag->url]) }}">{{ $tag->name }}</a>
                </div>
            </form>
        @endforeach
        <div class="row">
            <div class="col-md-12">
                {{ $tags->links('vendor.pagination.simple-default') }}
            </div>
        </div>
    </article>
@endsection