@extends('layouts/app')
@section('title','Categories')

@section('content')
    <h1>Categories</h1>
    <hr/>

    @if(session("success"))
        <p class="alert alert-success">{{ session("success") }} <a href="#" class="close" data-dismiss="alert"
                                                                   aria-label="close">&times;</a></p>
    @endif

    <a href="{{ route("categories.create") }}" class="btn btn-primary mb-3">Add Category</a>
    <div class="table-responsive">
        <table class="table">
            <tr class="thead-light">
                <th>Title</th>
                <th>Icon</th>
                <th>Description</th>
                <th>Options</th>
            </tr>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->title }}</td>
                    <td style="font-family: 'Material Icons',serif;">{{ $category->icon }}</td>
                    <td>{{ $category->description }}</td>
                    <td class="d-flex">
                        <a href="{{ route("categories.resources.index",$category->id) }}"
                           class="btn btn-outline-primary mr-2">Resources</a>

                        <a href="{{ route("categories.edit",$category->id) }}"
                           class="btn btn-outline-primary mr-2">Edit</a>

                        <form action="{{ route("categories.destroy",$category->id) }}" method="POST">
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
