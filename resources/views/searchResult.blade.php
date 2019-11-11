@extends('layouts.layout')


@section('title', 'Результат поиска')

@section('description', 'Найденые игры')

@section('keywords', 'игры')

@section('content')
    <div class="search-container">
        <div class="header-container">
            <div class="header">
                @if($games->isNotEmpty())
                    <h1>Найденые игры:</h1>
                @else
                    <h1>Игр по вашему запросу не найдено:</h1>
                @endif
            </div>
        </div>
        <div class="search">
            @if($games->isNotEmpty())
                @include('gameCard',['games'=>$games])
            @endif
        </div>
        {{ $games->appends($params)->links('vendor.pagination.default') }}

    </div>
    {{--    <div class="category-games">--}}
    {{--        @if($category->gamesDisplayed->isNotEmpty())--}}
    {{--            <div class="category-game-container">--}}
    {{--                @include('gameCard',['games'=>$category->gamesDisplayed])--}}
    {{--            </div>--}}
    {{--            {{ $category->gamesDisplayed->links('vendor.pagination.default') }}--}}
    {{--        @endif--}}
    {{--    </div>--}}

@endsection