@extends('layouts/app')

@section('title','Home')

@section('content')
    <div class="title m-b-md">
        @auth
            <h1>Hey {{ auth()->user()->name }}</h1>
            <p>You've been logged in</p>
        @else
            <h1>Start Here</h1>
        @endauth
    </div>
@endsection
