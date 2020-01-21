@extends('layouts/app')
@section('title','Resources')

@section('content')
    <h1><span style="font-family: 'Material Icons';">{{ $category->icon }}</span> Category: {{ $category->title }}</h1>
    <p>Description: {{ $category->description }}</p>
    <hr/>

    <h1>Resources</h1>
    @if(session("success"))
        <p class="alert alert-success">{{ session("success") }} <a href="#" class="close" data-dismiss="alert"
                                                                   aria-label="close">&times;</a></p>
    @endif

    <a href="{{ route("categories.resources.create",$category->id) }}" class="btn btn-primary mb-3">Add Resource</a>
    <div class="table-responsive">
        <table class="table">
            <tr class="thead-light">
                <th>Title</th>
                <th>Content</th>
                <th>Action</th>
                <th>Image?</th>
                <th>Actions</th>
            </tr>

            @foreach($resources as $resource)
                <tr>
                    <td>{{ $resource->title }}</td>
                    <td>{{ $resource->content }}</td>
                    <td><a href="{{ $resource->action }}">{{ $resource->action }}</a></td>
                    <td>{{ empty($resource->file_key) ? "Yes" : "No" }}</td>
                    <a href="{{ route("categories.resources.edit",$resource->id) }}"
                       class="btn btn-outline-primary mr-2">Edit</a>

                    <form action="{{ route("categories.resources.destroy",$resource->id) }}" method="POST">
                        {{ csrf_field() }}
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                    </form>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
