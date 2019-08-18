@extends('layouts.adminLayout')

@section('title','Опубликованные категории')


@section('right_content')
    <article>
        <header class="article-header">
            <h1>Опубликованные категории
                @if(isset($categories)){{ $categoriesCount }}@else()0
                @endif</h1>
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
                {{ $categories->links('vendor.pagination.simple-default') }}
            </div>
        </div>

    </article>
@endsection
