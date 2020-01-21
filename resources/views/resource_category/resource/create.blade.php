@extends('layouts/app')

@section('title','Add Resource')

@section('content')
    <h1>Add a new resource</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            There was a problem adding this resource.
        </div>
    @endif

    <form action="{{ route("categories.resources.store") }}" method="POST">
        {{ csrf_field() }}

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
