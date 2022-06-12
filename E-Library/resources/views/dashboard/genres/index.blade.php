@extends('dashboard.layouts.app')

@section('title', 'Genres List')

@section('content')
<div class="container">
    <a href="{{ route('genres.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New Genres</a>
    <div class="table-responsive">
        @if (Session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        <table class="table no-wrap">
            <thead>
                <tr>
                    <th class="border-top-0">#</th>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="txt-oflo">{{ $genre->name }}</td>
                    <td class="txt-ofo">
                        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-sm btn-success">Edit <i class="fa fa-edit"></i></a>
                        <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Are you sure to want to delete?')" class="btn btn-sm btn-danger">Delete <i class="fa fa-trash pr-3"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $genres->links() }}
    </div>
</div>
@endsection
