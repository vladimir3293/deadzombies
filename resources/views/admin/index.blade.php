@extends('layouts.adminLayout')

@section('title','Админка')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Сделать какую-то статистику, пока все игры</h1>
        </header>
        @if(isset($games))
            <div class="row">
                @include('admin.gameCard')
            </div>
            <div class="row">
                <div class="col-md-12">
                {{ $games->links() }}
            </div>
        @endif
    </article>
@endsection
