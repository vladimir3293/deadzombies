@extends('layouts.adminLayout')

@section('title','Админка')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>{{ $page->h1 }}</h1>
        </header>
        <div class="box">
            <p>{{ $page->desc1 }}</p>
        </div>
        @if(isset($games))
            @include('gameCard')
            {{ $games->links() }}
        @endif
    </article>
@endsection
