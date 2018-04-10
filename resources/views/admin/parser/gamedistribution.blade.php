@extends('layouts.adminLayout')

@section('title','Gamedistribution parser')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Gamedistribution parser</h1>
        </header>
        @if(isset($message))
            <p>Добавлено: {{ $message }} из {{ $countOfGames }} пропущено {{ $debug }}</p>
        @endif
        <form method="post" enctype="multipart/form-data" role="form">
            {{ method_field('POST') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="game_rename">Номер страницы из
                    "https://www.gamedistribution.com/gamelist/allcompanies/allcategories/html5?selectedPage=$page"</label>
                <input class="form-control" name="page_number" id="game_rename" type="number">
            </div>
            <input class="btn btn-primary" type="submit" value="Начать">
        </form>
    </article>
@endsection
