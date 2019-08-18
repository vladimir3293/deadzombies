@extends('layouts.adminLayout')

@section('title','Все категории')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Все категории: {{ $categoriesCount }}</h1>
        </header>
        @if(isset($categories))
            <div class="row">
                <ul>
                    @foreach($categories as $category)
                        <li><a href="{{ $category->url }}">{{ $category->cat_name }}</a>
                            <span>({{ $category->game_count }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>

        @endif
        <div class="row">
            <div class="col-md-12">
                {{ $categories->links() }}
            </div>
        </div>
    </article>
@endsection
