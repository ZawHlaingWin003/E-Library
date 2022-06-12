@extends('dashboard.layouts.app')

@section('title', 'Book List')

@section('content')
<div class="container">
    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New Book</a>
    @if (session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <div class="table-responsive">
        <table class="table no-wrap">
            <thead>
                <tr>
                    <th class="border-top-0">#</th>
                    <th class="border-top-0">Name</th>
                    <th class="border-top-0">Author</th>
                    <th class="border-top-0">Published Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="txt-oflo">{{ $book->name }}</td>
                    <td class="txt-oflo">{{ $book->author->name }}</td>
                    <td class="txt-oflo">{{ $book->published_at->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
