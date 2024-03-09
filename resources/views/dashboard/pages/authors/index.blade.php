@extends('dashboard.layouts.app')

@section('title', 'Author List')

@section('custom_style')
    <style>
        .author-img img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="{{ route('admin.authors.create') }}"><i class="fa fa-plus"></i> Add New Author</a>
        <div class="table-responsive">
            @if (Session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            <table class="no-wrap table border">
                <thead>
                    <tr>
                        <th class="border-top-0">#</th>
                        <th class="border-top-0">Profile</th>
                        <th class="border-top-0">Name</th>
                        <th class="border-top-0">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($authors as $author)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td class="author-img"><img alt="" class="img-fluid" src="{{ $author->profile }}"></td>
                            <td class="txt-oflo">{{ $author->name }}</td>
                            <td class="txt-ofo">
                                <a class="btn btn-sm btn-info" href="{{ route('authors.show', $author->id) }}">Detail <i class="fa fa-user-cog"></i></a>
                                <a class="btn btn-sm btn-success" href="{{ route('admin.authors.edit', $author->id) }}">Edit <i
                                        class="fa fa-user-pen"></i></a>
                                <form action="{{ route('admin.authors.destroy', $author->id) }}" class="d-inline" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to want to delete?')">Delete <i
                                            class="fa fa-user-xmark pr-3"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $authors->links() }}
        </div>
    </div>

@endsection
