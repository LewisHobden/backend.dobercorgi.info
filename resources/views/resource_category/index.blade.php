@extends('layouts/app')
@section('title','Categories')

@section('content')
    <p>Categories</p>

    <table class="table">
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->title }}</td>
                <td>{{ $category->icon }}</td>
                <td>{{ $category->description }}</td>
            </tr>
        @endforeach
    </table>
@endsection
