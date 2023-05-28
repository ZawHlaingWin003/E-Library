@extends('frontend.layouts.app')

@section('title', 'Genre Books List')

@section('custom_style')

@endsection

@section('content')

<section>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="title">Related Book List</h3>
            <a href="{{ route('genres.index') }}" class="btn btn-primary primary-btn">Genre List</a>
        </div>
        <hr>
        <div class="books">
            <div class="row">
                @foreach ($genre->books as $book)
                    <x-book-card :book="$book" class="col-md-4" />
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
