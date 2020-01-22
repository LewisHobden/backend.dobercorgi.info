@extends('layouts/app')
@section('title','Resources')

@section('content')
    <h1><span style="font-family: 'Material Icons';">{{ $category->icon }}</span> Category: {{ $category->title }}</h1>
    <p>Description: {{ $category->description }}</p>
    <hr/>

    @yield('other-content')
@endsection
