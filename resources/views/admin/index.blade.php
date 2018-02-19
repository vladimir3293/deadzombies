@extends('layouts.adminLayout')

@section('title','Админка')


@section('right_content')
    @if(isset($games))
        @include('gameCard')
        {{ $games->links() }}
    @endif
@endsection
