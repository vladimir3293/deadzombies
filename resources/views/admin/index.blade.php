@extends('layouts.adminLayout')

@section('title','Админка')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>{{ $page->h1 }}</h1>
        </header>
        <div class="box">
            <p>{{ $page->desc1 }}</p>
        </div>
        @if(isset($games))
            <div class="row">
                @include('admin.gameCard')
            </div>
            <div class="row">
                <div class="col-md-24">
                {{ $games->links('vendor.pagination.simple-default') }}
            </div>
        @endif
    </article>
@endsection
