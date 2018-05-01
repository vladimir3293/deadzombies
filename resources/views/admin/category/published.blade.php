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
            @foreach($categories as $category)
                <div class="row">
                    <a href="{{ $category->url }}">{{ $category->cat_name }}</a>
                </div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-md-12">
                {{ $categories->links('vendor.pagination.simple-default') }}
            </div>
        </div>

    </article>
@endsection
