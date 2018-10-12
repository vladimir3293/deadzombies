@extends('layouts.layout')

@section('title',$category->cat_title)

@section('description', $category->cat_desc_meta)

@section('keywords',$category->cat_key_meta)

@section('content')
    <article class="category">
        <header class="header-article">
            <h1>{{ $category->cat_name }}</h1>
        </header>
        @if(isset($games))
            <div class="category-game-container">
                @include('gameCard')
            </div>
            {{ $games->links('vendor.pagination.simpleIndexPage') }}
        @endif
        @if($category->tagsDisplayed->isNotEmpty())
            <div class="category-tags">
                <span>Подкатегории:</span>
                @foreach($category->tagsDisplayed as $tag)
                    <a href="{{ route('getTag',[$tag->url],false) }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <div class="category-text-block">
            <p>{!! $category->descWithP !!}</p>
        </div>
    </article>
@endsection

