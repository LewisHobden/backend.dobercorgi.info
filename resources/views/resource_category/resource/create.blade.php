@extends('resource_category/resource/resource_template')

@section('title','Add Resource')

@section('other-content')
    <h1>Add a new resource</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            There was a problem adding this resource.
        </div>
    @endif

    <form action="{{ route("categories.resources.store", $category->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control @error('title')is-invalid"@enderror" id="title"
            placeholder="" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="bannerImageFileInput">Banner Image</label>
            <input type="file" name="banner_image" class="form-control-file" id="bannerImageFileInput">
        </div>

        <div class="form-group">
            <label for="title">Action</label>
            <input type="text" name="action" class="form-control @error('action')is-invalid"@enderror" id="action"
            placeholder="" required>
            <small class="form-text text-muted">The full link to the resource (i.e. https://dobercorgi.info/).</small>
            @error('action')
            <div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-check-label" for="content">Content</label>
            <textarea class="form-control @error('content')is-invalid" @enderror rows="5" name="content"
                      id="content"></textarea>
            <small class="form-text text-muted">A description of what the resource is for.</small>
            @error('content')
            <div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
