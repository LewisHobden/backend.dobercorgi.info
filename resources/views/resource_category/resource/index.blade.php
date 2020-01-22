@extends('resource_category/resource/resource_template')
@section('title','Resources')

@section('other-content')
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
                    <td>{{ empty($resource->file_key) ? "No" : "Yes" }}</td>
                    <td class="d-flex">
                        <a href="{{ route("categories.resources.edit",[$category->id, $resource->id]) }}"
                           class="btn btn-outline-primary mr-2">Edit</a>

                        <form action="{{ route("categories.resources.destroy",[$category->id, $resource->id]) }}"
                              method="POST">
                            {{ csrf_field() }}
                            @method('DELETE')
                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
