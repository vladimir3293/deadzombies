@extends('layouts.layout')


@section('title','Тайтл индекс страницы')

@section('description','Мета писание первой страницы')

@section('keywords','Мета кейвердс первой страницы')

@section('content')
    @if($popularGames->isNotEmpty())
        <div class="popular-games-container">
            <div class="popular-games">
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
    @if($newGames->isNotEmpty())
        <div class="new-games-container">
            <div class="new-games">
                <div class="header-article">
                    <h1>Новые игры</h1>
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
                    <h1>Лучшие игры</h1>
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
                    <h1>Категории</h1>
                </div>

                @foreach($categories as $category)
                    {{--<div class="category-list">--}}
                    <ul class="categories-list">
                        <li class="categories-list-category">
                            <a href="{!! $category->url !!}"><img
                                        src="{{ $category->img }}"><span>{!! $category->cat_name !!}</span></a>
                        </li>
                        @foreach($category->tags as $tag)
                            <li class="categories-list-subcategory">
                                <a href="{!! $tag->fullUrl !!}"><img
                                            src="{{ $tag->img }}"><span>{!! $tag->name !!}</span></a>
                            </li>
                        @endforeach
                    </ul>
                    {{--</div>--}}
                @endforeach

            </div>
        </div>
    @endif

    <div class="description-container">
        <div class="description">
            <h1>Free online games</h1>
            <p>deadzombies.com is a personalized discovery platform for free online games. We will hand-pick new games
                for you every day, so you’re guaranteed the best titles and the most fun! You’ll never be bored, because
                we give you personalized recommendations based on what games you like. Clever algorithms will make sure
                that you never miss the latest IO games, if you love online multiplayer games, and you’ll always see the
                best racing games, if you are into cars. Our games are cross-device playable, so you can enjoy them
                everywhere!</p>


            <p>Using the Poki platform, you can play thousands of games for free! We offer you the best free games that
                are playable on all devices. Every day, you can find the newest games at Poki to play on your computer,
                smartphone, or tablet. Use your keyboard, mouse, or touch screen to control puzzles, heroes, and
                racecars! Feel the adrenaline while playing 2 player games, use your brain for clever puzzles, and use
                your fashion sense to dress up girls! We bring awesome games to all screens – games that are published
                by Poki or others.</p>


            <p>Poki Games offers you all of the best online games and most popular categories, like .io games, two
                player games, and papa's games, stickman games, girl games, as well as games based on your favorite
                movies or TV shows. In our large collection of fun games, you can also find classic titles, including
                Mahjong, Bubble Shooter, and Bejeweled, as well as cool games, such as Slither.io, Color Switch, and
                Happy Wheels. You can play games in 3D, super-fun shooting games, and all of the popular puzzle games!
                No matter your taste in games, we have great ones for you.</p>
        </div>
    </div>
@endsection
