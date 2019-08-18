@extends('layouts.adminLayout')

@section('title','Результат поиска')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Результат поиска:</h1>
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
