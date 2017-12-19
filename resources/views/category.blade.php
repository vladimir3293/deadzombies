@extends('layouts.layout')
@section('right_content')
    <h1>{{ $category->cat_h1 }}</h1>
    <div class="box">
        <p>{{ $category->cat_desc }}</p>
    </div>
    @if(isset($games))
        @include('gameCard')
    @endif
@endsection

