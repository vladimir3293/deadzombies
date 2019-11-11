@extends('layouts.layout')

@section('title','cat_title')

@section('description', 'cat_desc_meta')

@section('keywords','cat_key_meta')
@section('content')
    <div class="error-container">
        <div class="error">
            <h1>Произошла ошибка, страница не найдена</h1>
        </div>
    </div>
@endsection
{{--<h2>{{ $exception->getMessage() }}</h2>--}}