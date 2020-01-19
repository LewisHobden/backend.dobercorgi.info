@extends('layouts/app')

@section('title','Add Category')

@section('content')
    <h1>Add a new category</h1>


    @if ($errors->any())
        <div class="alert alert-danger">
            There was a problem adding this category.
        </div>
    @endif

    <form action="{{ route("categories.store") }}" method="POST">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control @error('title')is-invalid"@enderror" id="title"
            placeholder="" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" name="icon" class="form-control @error('icon')is-invalid"@enderror" id="icon"
            placeholder="loading" required>
            @error('icon')
            <div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-check-label" for="description">Description</label>
            <textarea class="form-control @error('description')is-invalid" @enderror rows="5" name="description"
                      id="description"></textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
