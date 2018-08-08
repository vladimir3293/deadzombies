@extends('layouts.layout')


@section('title','Тайтл индекс страницы')

@section('description','Мета писание первой страницы')

@section('keywords','Мета кейвердс первой страницы')


@section('right_content')
    <article>
        <header class="header-article">
            <h1>Лучшие игры</h1>
        </header>
        @if(isset($games))
            <div class="game-conainer">
                @include('gameCard')
            </div>
            {{ $games->links('vendor.pagination.simpleIndexPage') }}
        @endif
        <div class="text-block">
            <p>Описание главной страницыОписание главной страницы Описание главной страницы Описание главной страницы
                Описание главной страницы Описание главной страницы Описание главной страницы Описание главной
                страницы</p>
        </div>
    </article>
@endsection
