@extends('layouts.layout')

@section('title',$category->cat_title)

@section('description', $category->cat_desc_meta)

@section('keywords',$category->cat_key_meta)
@section('canonical')
<link rel="canonical" href="{{ $category->url }}"/>
@endsection
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
                    {{ $category->gamesDisplayed->links('vendor.pagination.default') }}
                @endif
            </div>

            <div class="category-description">
                <h2>Описание категории</h2>
                {!! $category->cat_desc !!}
                <div class="clearfix"></div>
                @if($category->tagsDisplayed->isNotEmpty())
                    <div class="game-related-tags-container">
                        <h2>Похожие категории</h2>
                        <div class="game-related-tags">
                            @foreach($category->tagsDisplayed as $tag)
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
                    @if($category->bestGames->isNotEmpty())
                        <ul class="category-tags">
                            @foreach($category->bestGames as $game)
                                <li>
                                    <a href="{!! $game->url !!}" title="Игра {{ $game->game_title }}">
                                        <img alt="{{ $game->imgAlt }}" title="{{ $game->imgTitle }}"
                                             src="{{ $game->img }}"><span>{!! $game->game_name !!}</span></a>
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
                                        <a href="{!! $game->url !!}" title="Игра {{ $game->game_title }}">
                                            <img {{ $game->imgAlt }}" title="{{ $game->imgTitle }}"
                                            src="{{ $game->img }}">
                                            <span>{!! $game->game_name !!}</span></a>
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
@section('json-ld')
<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "WebPage",
  "name" : "{{ $category->cat_title }}",
  "description" : "{!! $category->microdataDesc !!}",
  "url" : "{{ route('getCategory',$category->cat_url,false) }}",
  "image" : "{{ $category->img }}",
  "aggregateRating" : {
    "@type" : "AggregateRating",
    "ratingValue" : "4.7",
    "bestRating" : "5",
    "worstRating" : "0",
    "ratingCount" : "1675"
  },
 "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement":
  {!! $category->microdataBreadcrumb !!}}
  }
  }
    </script>
@endsection

