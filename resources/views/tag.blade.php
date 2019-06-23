@extends('layouts.layout')

@section('title', $tag->title)

@section('description', $tag->meta_desc)

@section('keywords', $tag->meta_key)

@section('content')
    <div class="category-container">
        <article class="category">
            <div class="category-breadcrumbs">
                <a href="/">Игры</a>
                <span>{{ $tag->name }}</span>
            </div>
            <header class="category-header">
                <h1>{{ $tag->h1 }}</h1>
            </header>
            <div class="category-games">
                @if($tag->gamesDisplayed->isNotEmpty())
                    <div class="category-game-container">
                        @include('gameCard',['games'=>$tag->gamesDisplayed])
                    </div>
                    {{ $tag->gamesDisplayed->links('vendor.pagination.simpleIndexPage') }}
                @endif
            </div>

            <div class="category-description">
                <h2>Описание подкатегории</h2>
                {!! $tag->description !!}
                <div class="clearfix"></div>
                @if($tag->tagsDisplayed->isNotEmpty())
                    <div class="game-related-tags-container">
                        <h2>Похожие категории</h2>
                        <div class="game-related-tags">
                            @foreach($tag->tagsDisplayed as $tag)
                                <div class="game-related-tags-item">
                                    <a href="{!! $tag->fullUrl !!}"><img
                                                src="{{ $tag->img }}"><span>{!! $tag->name !!}</span></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="category-sidebar">
                <div class="category-relation">
                    <span>Лучшие игры:</span>
                    @if($tag->bestGames->isNotEmpty())
                        <ul class="category-tags">
                            @foreach($tag->bestGames as $game)
                                <li>
                                    <a href="{!! $game->url !!}"><img
                                                src="{{ $game->img }}"><span>{!! $game->game_name !!}</span></a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @if($tag->newGames->isNotEmpty())
                    <div class="category-new-games">
                        <span>Новые игры:</span>
                        @if($tag->newGames->isNotEmpty())
                            <ul>
                                @foreach($tag->newGames as $game)
                                    <li>
                                        <a href="{!! $game->url !!}"><img
                                                    src="{{ $game->img }}"><span>{!! $game->game_name !!}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
            </div>
        </article>
    </div>
@endsection