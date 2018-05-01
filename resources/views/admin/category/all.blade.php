@extends('layouts.adminLayout')

@section('title','Все категории')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Все категории: {{ $categoriesCount }}</h1>
        </header>
        @if(isset($categories))
            @foreach($categories as $category)
                <div class="row">
                    <a href="{{ $category->url }}">{{ $category->cat_name }}</a>
                </div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-md-12">
                {{ $categories->links() }}
            </div>
        </div>
    </article>
@endsection
