@extends('layouts.layout')

@section('title',$category->cat_title)

@section('description', $category->cat_desc_meta)

@section('keywords',$category->cat_key_meta)

@section('right_content')
    <article>
        <header class="header-article">
            <h1>{{ $category->cat_name }}</h1>
        </header>
        <div class="box">
            <p>{!! $category->descWithP !!}</p>
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
            <div class="row">
                @include('gameCard')
            </div>
            <div class="row">
                <div class="col-md-24">
                    {{ $games->links('vendor.pagination.simple-default') }}
                </div>
            </div>
        @endif
    </article>
@endsection

