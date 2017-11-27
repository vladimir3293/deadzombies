@extends('layouts.layout')

@section('title','Админка')

@section('sidebar')
    @include('sidebar')
@endsection

@section('right_content')
    @if(isset($games))
        @include('gameCard')
    @endif
@endsection
