@extends('layouts.layout')

@section('title',$game->game_title)

@section('right_content')
    <article>
        <div class="game">
            <header class="header-article">
                <h1>{{ $game->game_name }}</h1>
            </header>
            <div class="like">
                <img src="/img/site/like.png" alt="How many people like this game" title="like button">
                <span id="like_value">{{ $game->game_like }}</span>
                <button id="like" data-id="{{ $game->game_id }}">LIKE</button>
            </div>
            <div class="game-img">
                <img src="/img/{{ $game->game_url }}.jpg">
            </div>
            <div class="game-play-button">
                <a href="#">ИГРАТЬ</a>
            </div>
            <div class="text-block">
                {!! $game->descWithP !!}
            </div>

            <div class="breadcrumb">
                <span>ВЕРНУТЬСЯ:</span>
                <a href="/">Главная</a>
                @if(isset($game->categoryUrl))
                    <a href="{{ $game->categoryUrl }}">{{ $game->cat_name }}</a>
                @endif
            </div>



            {{--<div class="flash">--}}
            {{--<div class="fucking_css" style="max-width: {{ $game->maxWidth }}vh;">--}}
            {{--<div class="video" style="padding-bottom: {{ $game->maxHeight }}%;">--}}

            {{--max-height: {{ $game->gameHeight }}px;--}}
            {{--max-width: {{ $game->gameWidth }}px;--}}
            {{--width: {{ $game->number }}vh;--}}
            {{--height: 100vh"--}}


            {{--<iframe src="{{ $game->source }}"--}}
            {{--name="topFrame"--}}
            {{--scrolling="yes"--}}
            {{--allowfullscreen--}}
            {{--style="margin: 50px;"--}}
            {{--height="100vh" ;--}}
            {{--width="{{ $game->number }}vh"--}}
            {{--height="{{ $game->gameHeight }}"--}}
            {{--width="{{ $game->gameWidth }}"--}}
            {{-->--}}
            {{--</iframe>--}}
            {{--</div>--}}
            {{--</div>--}}
            @if($game->tagsDisplayed->isNotEmpty())
                {{--@php(dd(empty($game->tagsDisplayed)))--}}
                <div class="tags">
                    <span>ТЕГИ:</span>
                    @foreach($game->tagsDisplayed as $tag)
                        <a href="{{ route('getTag',[$tag->url],false) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
            @endif
            <div class="game-control">
                <div class="game-control-img">
                    <img src="/img/site/control.png" alt="Управление">
                </div>
                <div class="game-control-text">
                    <p>{!! $game->gameControlWithP !!}</p>
                </div>
            </div>
            {{--</div>--}}

        </div>
    </article>
@endsection