@extends('layouts/app')

@section('title','Edit Resource')

@section('content')
    <h1>Editing a resource</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            There was a problem adding this category.
        </div>
    @endif

    <form action="{{ route("categories.update", $category->id) }}" method="POST">
        {{ csrf_field() }}
        @method("PATCH")

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
