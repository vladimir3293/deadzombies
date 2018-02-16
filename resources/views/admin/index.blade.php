@extends('layouts.adminLayout')

@section('title','Админка')

@section('sidebar')
    @include('admin.menu')
@endsection

@section('right_content')
    @if(isset($games))
        @include('gameCard')
    @endif
    {{ $games->links() }}
@endsection
