@extends('layouts.layout')

@section('title', $tag->title)

@section('description', $tag->meta_desc)

@section('keywords', $tag->meta_key)

@section('right_content')
    <article>
        <header class="header-article">
            <h1>{{ $tag->name }}</h1>
        </header>
        <div class="box">
            <p>{!! $tag->descWithP !!}</p>
        </div>
        <div class="tags">
            <span>Подкатегории:</span>
            @if($tag->tagsDisplayed->isNotEmpty())
                @foreach($tag->tagsDisplayed as $tag)
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