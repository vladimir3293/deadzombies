@extends('layouts.layout')

@section('title',$category->cat_title)

@section('description', $category->cat_desc_meta)

@section('keywords',$category->cat_key_meta)

@section('content')
    <div class="category-container">
        <article class="category">
            <div class="category-breadcrumbs">
                <a href="/">Игры</a>
                <span>{{ $category->cat_name }}</span>
            </div>
            <header class="category-header">
                <h1>{{ $category->h1 }}</h1>
            </header>
            <div class="category-games">
                @if($category->gamesDisplayed->isNotEmpty())
                    <div class="category-game-container">
                        @include('gameCard',['games'=>$category->gamesDisplayed])
                    </div>
                    {{ $category->gamesDisplayed->links('vendor.pagination.simpleIndexPage') }}
                @endif
            </div>

            <div class="category-description">
                {!! $category->descWithP !!}
                <div class="clearfix"></div>
            </div>
            <div class="category-sidebar">
                <div class="category-relation">
                    <span>Похожие категории:</span>
                    @if($category->tagsDisplayed->isNotEmpty())
                        <ul class="category-tags">

                            @foreach($category->tagsDisplayed as $tag)
                                <li>
                                    <a href="{!! $tag->fullUrl !!}"><img
                                                src="{{ $tag->img }}"><span>{!! $tag->name !!}</span></a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @if($category->newGames->isNotEmpty())
                    <div class="category-new-games">
                        <span>Новые игры:</span>
                        @if($category->newGames->isNotEmpty())
                            <ul>
                                @foreach($category->newGames as $game)
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

