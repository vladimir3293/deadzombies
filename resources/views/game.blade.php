@extends('layouts.layout')

@section('title',$game->game_title)

@section('description', $game->game_desc_meta)

@section('keywords',$game->game_key_meta)

@section('content')
    <article class="game-wrap">
        <div class="game">
            <header class="game-header">
                <h1>{{ $game->game_name }}</h1>
            </header>
            <div class="game-block">
                @if($similarGames->isNotEmpty())
                    @include('gameCard',['games'=>$similarGames])
                @endif
                <div class="game-box">
                    <div class="game-box-img">
                        <img class="game-play-click" src="{{ $game->img }}">
                    </div>
                    <div class="game-box-play">
                        <span class="game-play-click">ИГРАТЬ</span>
                    </div>
                    <div class="game-box-source">
                        <iframe id="game-player"
                                data-src="{{ $game->source }}"
                                frameborder="0"
                                name="topFrame"
                                scrolling="no"
                                allowfullscreen="true"
                                allowtransparency="true"
                                {{--style="margin: 50px;"--}}
                                {{--height="100vh" ;--}}
                                {{--width="{{ $game->number }}vh"--}}
                                {{--height="{{ $game->gameHeight }}"--}}
                                {{--width="{{ $game->gameWidth }}"--}}
                        >
                        </iframe>

                    </div>
                    <div class="game-box-fullscreen">
                        <span class="test" onclick="toggleFull();">На весь экран</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="game-description">
            <h2>Описание игры</h2>
            <div class="game-breadcrumb">
                <a href="/">Игры</a>
                <a href="{{ $game->categoryUrl }}">{{ $game->category->cat_name }}</a>
                <span>{{ $game->game_name }}</span>
            </div>
            @if($game->tagsDisplayed->isNotEmpty())
                <div class="game-tags">
                    @foreach($game->tagsDisplayed as $tag)
                        <a href="{{ $tag->fullUrl }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
            @endif
            {!! $game->descWithP !!}
        </div>
        <div class="game-new-games">
            <h2>Новые игры:</h2>
            <div class="game-new-games-container">
                @if($newGames->isNotEmpty())
                    @include('gameCard',['games'=>$newGames])
                @endif
            </div>
        </div>
        <div class="game-related-tags-container">
            <h2>Похожие категории</h2>
            <div class="game-related-tags">
                @foreach($game->tagsDisplayed as $tag)
                    <div class="game-related-tags-item">
                        <a href="{!! $tag->fullUrl !!}"><img
                                    src="{{ $tag->img }}"><span>{!! $tag->name !!}</span></a>
                    </div>
                @endforeach
            </div>
        </div>
        {{--<div class="game-like">--}}
        {{--<img src="/img/site/like.png" alt="How many people like this game" title="like button">--}}
        {{--<span id="like_value">{{ $game->game_like }}</span>--}}
        {{--<button id="like" data-id="{{ $game->game_id }}">LIKE</button>--}}
        {{--</div>--}}
        {{--<div class="flash">--}}
        {{--<div class="fucking_css" style="max-width: {{ $game->maxWidth }}vh;">--}}
        {{--<div class="video" style="padding-bottom: {{ $game->maxHeight }}%;">--}}
        {{--max-height: {{ $game->gameHeight }}px;--}}
        {{--max-width: {{ $game->gameWidth }}px;--}}
        {{--width: {{ $game->number }}vh;--}}
        {{--height: 100vh"--}}
        {{--<div class="game-control">--}}
        {{--<div class="game-control-img">--}}
        {{--<img src="/img/site/control.png" alt="Управление">--}}
        {{--</div>--}}
        {{--<div class="game-control-text">--}}
        {{--<p>{!! $game->gameControlWithP !!}</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
    </article>
@endsection