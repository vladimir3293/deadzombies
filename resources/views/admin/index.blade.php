@extends('layouts.adminLayout')

@section('title','Админка')


{{-- TODO wtf check layout --}}
@section('sidebar')
    @include('admin.menu')
@endsection

@section('right_content')
    @if(isset($games))
        @include('gameCard')
    @endif
@endsection
