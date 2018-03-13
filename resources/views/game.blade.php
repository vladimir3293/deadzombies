@extends('layouts.layout')

@section('title',$game->game_title)

@section('right_content')
    <div class="content">
        <h1>{{ $game->game_name }}</h1>
        <div class="breadcrumb">
            <span>BACK:</span>
            <a href="/">Главная</a>
            <a href="/{{ $game->cat_url }}">{{ $game->cat_name }}</a>
        </div>
        <div class="like">
            <img src="/img/like.png" alt="How many people like this game" title="like button">
            <span id="like_value">{{ $game->game_like }}</span>
            <button id="like" data-id="{{ $game->game_id }}">LIKE</button>
        </div>
        <div class="upr">
            <img src="/img/control.png" alt="Управление">
            <p>{{ $game->game_control }}</p>
        </div>
        <div class="flash">

            <iframe src="{{ $game->source }}" name="topFrame" scrolling="no" noresize>
            </iframe>
        </div>
        <div class="flash-opis">
            <img src="{{ $game->game_img }}">
            <p>{{ $game->game_desc }}</p>
            <div class="clr"></div>
        </div>
    </div>
    </div>
@endsection