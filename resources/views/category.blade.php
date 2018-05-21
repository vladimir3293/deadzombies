@extends('layouts.layout')

@section('title','Тайтл индекс страницы')

@section('description','Мета писание первой страницы')

@section('keywords','Мета кейвердс первой страницы')

@section('right_content')
    <article>
        <header class="header-article">
            <h1>{{ $category->cat_name }}</h1>
        </header>
        <div class="box">
            <p>{{ $category->cat_desc }}</p>
        </div>
        <div class="tags">
            <span>Подкатегории:</span>
            @if(isset($category->tagsDisplayed))
                @foreach($category->tagsDisplayed as $tag)
                    <a href="{{ route('getTag',[$tag->url],false) }}">{{ $tag->name }}</a>
                @endforeach
            @endif
        </div>
        <div class="clr"></div>
        @if(isset($games))
            @include('gameCard')
        @endif
    </article>
@endsection

