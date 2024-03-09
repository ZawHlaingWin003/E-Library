@extends('dashboard.layouts.app')

@section('title', 'Genres List')

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="{{ route('admin.genres.create') }}"><i class="fa fa-plus"></i> Add New Genres</a>
        <div class="genres">
            @if (Session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            <div class="genre-list">
                <div class="row">
                    @foreach ($genres as $genre)
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">{{ $genre->name }}</div>
                                <div class="card-footer">
                                    <a class="btn btn-sm btn-success text-white" href="{{ route('admin.genres.edit', $genre->id) }}">Edit <i
                                            class="fa fa-edit"></i></a>
                                    <form action="{{ route('admin.genres.destroy', $genre->id) }}" class="d-inline" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to want to delete?')">Delete <i
                                                class="fa fa-trash pr-3"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{ $genres->links() }}
        </div>
    </div>
@endsection
