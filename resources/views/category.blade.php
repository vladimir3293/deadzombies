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

@section('footer')
    <div class="copy">
        <img src="/img/footer.png">
        <p class="descr">Все права на публикацию, принадлежат их владельцам. Весь материал расположенный на сайте, взят из открытых источников.</p>
        <div class="clr"></div>
    </div>
@endsection