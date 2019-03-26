@extends('layouts.adminLayout')

@section('title','Все категории')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Страницы</h1>
        </header>
        @if(isset($pages))
            @foreach($pages as $page)
                <div class="row">
                    <a href="{{ $page->url }}">{{ $page->name }}</a>
                </div>
            @endforeach
        @endif

    </article>
@endsection
