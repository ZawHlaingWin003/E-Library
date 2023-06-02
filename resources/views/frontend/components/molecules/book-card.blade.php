@props([
    'book'
])

<div {{ $attributes->merge(['class' => 'book-card']) }}>
    <div class="card p-3 border-0">
        <img src="{{ $book->cover }}" alt="" class="book-cover">
        <hr>
        <h3 class="book-title text-center"><a href="{{ route('books.show', $book) }}">{{ $book->name }}</a></h3>
        <p class="book-author text-center mt-3">By : <a
                href="{{ route('authors.show', $book->author->id) }}">{{ $book->author->name }}</a>
        </p>
        <a href="{{ route('books.show', $book) }}" class="btn btn-primary primary-btn">Read
            More</a>
    </div>
</div>
