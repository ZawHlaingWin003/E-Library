@extends('frontend.layouts.app')

@section('title', $author->name)

@section('custom_style')
<style>
.profile img{
    width: 100%;
    height: 300px;
    object-fit: contain;
}
.author-name{
    font-family: titleBoldFont;
}
.biography-title{
    font-family: titleRegularFont;
    width: max-content;
    border-bottom: 1px dashed #000;
}
.biography{
    text-indent: 80px;
}
</style>
@endsection

@section('content')
<section>
    <div class="container">
        <a href="{{ route('authors.index') }}" class="btn btn-primary primary-btn mb-5"><i class="fa fa-arrow-left"></i> Author List</a>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile">
                    <img src="{{ $author->profile }}" alt="" class="img-fluid rounded">
                </div>
                <h4 class="bg-dark text-white mt-4 mb-5 p-2 text-center author-name">{{ $author->name }}</h4>
                <h3 class="biography-title mb-3 p-2">Biography</h3>
                <p class="biography">{{ $author->biography }}</p>
            </div>
        </div>
        <hr>
        <div class="published-books">
            <div class="published-book-list">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="title">Published Book List</h3>
                    <a href="{{ route('books.index') }}" class="btn btn-primary primary-btn">Go to Library</a>
                </div>
                <hr>
                <div class="container books">
                    <div class="row">
                        @foreach ($author->books as $book)
                            <x-book-card :book="$book" class="col-md-4" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

