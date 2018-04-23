@extends('layouts.layout')


@section('title','Тайтл индекс страницы')

@section('description','Мета писание первой страницы')

@section('keywords','Мета кейвердс первой страницы')


@section('right_content')
    <article>
        <header class="header-article">
            <h1>{{ $page->h1 }}</h1>
        </header>
        <div class="box">
            <p>{{ $page->desc1 }}</p>
        </div>
        @if(isset($games))
            <div class="row">
                @include('gameCard')
            </div>
            <div class="row">
                <div class="col-md-24">
                    {{ $games->links('vendor.pagination.simple-default') }}
                </div>
        @endif
    </article>
@endsection
