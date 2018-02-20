@extends('layouts.adminLayout')

@section('title','Админка')


@section('right_content')
    <h1>{{ $page->h1 }}</h1>
    <div class="box">
        <p>{{ $page->desc1 }}</p>
    </div>
    @if(isset($games))
        @include('gameCard')
        {{ $games->links() }}
    @endif
@endsection
