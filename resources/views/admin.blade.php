@extends('layouts.layout')

@section('title','Админка')

@section('sidebar')
    @include('menu')
@endsection

@section('right_content')
    @if(isset($games))
        @include('gameCard')
    @endif
@endsection
