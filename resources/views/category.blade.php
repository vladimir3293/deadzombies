@extends('layouts.layout')

@section('title',$category->cat_title)

@section('description', $category->cat_desc_meta)

@section('keywords',$category->cat_key_meta)

@section('right_content')
    <article>
        <header class="header-article">
            <h1>{{ $category->cat_name }}</h1>
        </header>
        @if(isset($games))
            <div class="game-container">
                @include('gameCard')
            </div>
            {{ $games->links('vendor.pagination.simpleIndexPage') }}
        @endif
        @if($category->tagsDisplayed->isNotEmpty())
            <div class="tags">
                <span>Подкатегории:</span>
                @foreach($category->tagsDisplayed as $tag)
                    <a href="{{ route('getTag',[$tag->url],false) }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <div class="text-block">
            <p>{!! $category->descWithP !!}</p>
        </div>
        <div class="go-top">
<a href="#">наверх</a>
        </div>
    </article>
@endsection

