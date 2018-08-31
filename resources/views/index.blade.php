@extends('layouts.layout')


@section('title','Тайтл индекс страницы')

@section('description','Мета писание первой страницы')

@section('keywords','Мета кейвердс первой страницы')

@section('right_content')
    <div class="top-games">
        <header class="header-article">
            <h1>Лучшие игры</h1>
        </header>
        @if(isset($games))
            <div class="game-container">
                @include('gameCard')
            </div>
            {{ $games->links('vendor.pagination.simpleIndexPage') }}
        @endif

    </div>
    <div class="best-games">

    </div>
    <div class="popular-games">

    </div>
    <div class="description">
        <div class="text-block">
            <p>Описание главной страницыОписание главной страницы Описание главной страницы Описание главной страницы
                Описание главной страницы Описание главной страницы Описание главной страницы Описание главной
                страницы</p>
        </div>
    </div>
@endsection
