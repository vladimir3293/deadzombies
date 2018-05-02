@extends('layouts.adminLayout')

@section('title','Не опубликованные теги')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Не опубликованные теги
                @if(isset($tags)){{ $tagsCount }}@else()0
                @endif</h1>
        </header>
        @if(isset($tags))
            @foreach($tags as $tag)
                <div class="row">
                    <a href="{{ $tag->url }}">{{ $tag->name }}</a>
                </div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-md-12">
                {{ $tags->links('vendor.pagination.simple-default') }}
            </div>
        </div>
    </article>
@endsection
