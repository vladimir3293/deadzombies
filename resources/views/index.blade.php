@extends('layouts.layout')


@section('title', $indexPage->title)

@section('description', $indexPage->desc_meta)

@section('keywords', $indexPage->desc_key)

@section('content')
    <div class="header-container">
        <div class="header">
            <h1>{{ $indexPage->h1 }}</h1>
        </div>
    </div>
    @if($popularGames->isNotEmpty())
        <div class="popular-games-container">
            <div class="popular-games">
                <div class="header-article">
                    <h2>Популярные игры</h2>
                </div>

                <div class="game-container">
                    @include('gameCard',['games'=>$popularGames])
                </div>
                {{--{{ $popularGames->links('vendor.pagination.simpleIndexPage') }}--}}
            </div>
        </div>
    @endif
    @if($newGames->isNotEmpty())
        <div class="new-games-container">
            <div class="new-games">
                <div class="header-article">
                    <h2>Новые игры</h2>
                </div>

                <div class="game-container">
                    @include('gameCard',['games'=>$newGames])
                </div>
                {{--{{ $popularGames->links('vendor.pagination.simpleIndexPage') }}--}}
            </div>
        </div>
    @endif
    @if($bestGames->isNotEmpty())
        <div class="best-games-container">
            <div class="best-games">
                <div class="header-article">
                    <h2>Лучшие игры</h2>
                </div>

                <div class="game-container">
                    @include('gameCard',['games'=>$bestGames])
                </div>
                {{--{{ $popularGames->links('vendor.pagination.simpleIndexPage') }}--}}
            </div>
        </div>
    @endif
    @if($categories->isNotEmpty())
        <div class="categories-container">
            <div class="categories">
                <div class="header-article">
                    <h2>Категории</h2>
                </div>
                <ul class="categories-list">

                    @foreach($categories as $category)
                        <li class="categories-list-category">
                            <a href="{!! $category->url !!}"><img alt="{{ $category->imgAlt }}"
                                                                  title="{{ $category->imgTitle }}"
                                                                  src="{{ $category->img }}"><span>{!! $category->cat_name !!}</span></a>
                        </li>

                        {{--</div>--}}
                    @endforeach
                    @if($tags->isNotEmpty())
                        @foreach($tags as $tag)
                            <li class="categories-list-category">
                                <a href="{!! $tag->fullUrl !!}"><img alt="{{ $tag->imgAlt }}"
                                                                     title="{{ $tag->imgTitle }}"
                                                                     src="{{ $tag->img }}"><span>{!! $tag->name !!}</span></a>
                            </li>
                        @endforeach
                    @endif
                </ul>

            </div>
        </div>
    @endif

    <div class="description-container">
        <div class="description">
            {!! $indexPage->description !!}
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
