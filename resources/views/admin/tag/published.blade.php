@extends('layouts.adminLayout')

@section('title','Опубликованные теги')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Опубликованные теги
                @if(isset($tags)){{ $tagsCount }}@else()0
                @endif</h1>
        </header>
        @if(isset($tags))
            <div class="row">
                <ul>
                    @foreach($tags as $tag)
                        <li><a href="{{ $tag->url }}">{{ $tag->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                {{ $tags->links('vendor.pagination.simple-default') }}
            </div>
        </div>
    </article>
@endsection
