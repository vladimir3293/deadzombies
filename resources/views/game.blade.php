@extends('layouts.layout')

@section('title',$game->game_title)

@section('right_content')
    <article>
        <div class="content">
            <header class="header-article">
                <h1>{{ $game->game_name }}</h1>
            </header>
            <div class="breadcrumb">
                <span>ВЕРНУТЬСЯ:</span>
                <a href="/">Главная</a>
                @if(isset($game->cat_url))
                    <a href="/{{ $game->cat_url }}">{{ $game->cat_name }}</a>
                @endif
            </div>
            <div class="like">
                <img src="/img/site/like.png" alt="How many people like this game" title="like button">
                <span id="like_value">{{ $game->game_like }}</span>
                <button id="like" data-id="{{ $game->game_id }}">LIKE</button>
            </div>
            <div class="clr"></div>
            <div class="upr">
                <div class="upr-img">
                    <img src="/img/site/control.png" alt="Управление">
                </div>
                <div class="upr-text">
                    <p>{{ $game->game_control }}</p>

                </div>
            </div>
            <div class="flash">


                <iframe src="{{ $game->source }}"
                        name="topFrame"
                        scrolling="no"
                        height="{{ $game->gameHeight }}"
                        width="100%">
                </iframe>

            </div>
            <div class="flash-opis">
                <img src="/img/{{ $game->game_url }}.jpg">
                <p>{{ $game->game_desc }}</p>
                <div class="clr"></div>
            </div>
        </div>
    </article>
@endsection