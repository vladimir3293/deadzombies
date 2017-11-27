@extends('layouts.layout')

@section('title','Админка')

@section('right_content')
    <h1>Zombie games for zombie</h1>
    <div class="box">
        <p>Диаграмма классов UML позволяет обозначать отношения между классами и их экземплярами. Для чего они нужны? Они нужны, например, для моделирования прикладной области. Но как отношения отражаются в программном коде? Данное небольшое исследование пытается ответить на этот вопрос — показать эти отношения в коде.</p>
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
