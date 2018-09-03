@extends('layouts.layout')


@section('title','Тайтл индекс страницы')

@section('description','Мета писание первой страницы')

@section('keywords','Мета кейвердс первой страницы')

@section('right_content')
    @if($popularGames->isNotEmpty())
        <div class="top-games-container">
            <div class="top-games">
                <div class="header-article">
                    <h1>Популярные игры</h1>
                </div>

                <div class="game-container">
                    @include('gameCard',['games'=>$popularGames])
                </div>
                {{--{{ $popularGames->links('vendor.pagination.simpleIndexPage') }}--}}
            </div>
        </div>
    @endif
    @if($bestGames->isNotEmpty())
        <div class="best-games-container">
            <div class="best-games">
                <div class="header-article">
                    <h1>Лучшие игры</h1>
                </div>

                <div class="game-container">
                    @include('gameCard',['games'=>$bestGames])
                </div>
                {{--{{ $popularGames->links('vendor.pagination.simpleIndexPage') }}--}}
            </div>
            </div>
        </div>
    @endif
    @if($newGames->isNotEmpty())
        <div class="popular-games-container">
            <div class="popular-games">
                <div class="header-article">
                    <h1>Новые игры</h1>
                </div>

                <div class="game-container">
                    @include('gameCard',['games'=>$newGames])
                </div>
                {{--{{ $popularGames->links('vendor.pagination.simpleIndexPage') }}--}}
            </div>
            </div>
        </div>
    @endif
    <div class="description">
        <div class="text-block">
            <p>Описание главной страницыОписание главной страницы Описание главной страницы Описание главной страницы
                Описание главной страницы Описание главной страницы Описание главной страницы Описание главной
                страницы</p>
        </div>
    </div>
@endsection
