<div class="row">
    <div class="col-md-5 border-top">
        <div class='image'>
            <div class='content'>
                <div class='book-cover p-3'>
                    <img alt='Card Image' src="{{ $book->cover }}" class="img-fluid">
                </div>
            </div>
            <div class="book-meta d-flex justify-content-center gap-5 mt-3 text-center">
                <div class="reads meta-item">
                    <small>
                        <i class="fa fa-eye"></i>
                        <span class='text'>
                            {{ $book->views }} reads
                        </span>
                    </small>
                </div>
                <div class="likes meta-item">
                    <small>
                        <i class='fa fa-thumbs-up'></i>
                        <span class='text'>
                            {{ $book->likes }} likes
                        </span>
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7 p-5 pe-2 border-top border-start">
        <div class='text book-text'>
            <p class="genres">
                @foreach ($book->genres as $genre)
                    <a href="{{ route('genres.show', $genre) }}" class="text-primary">
                        <span class="pe-2 @if (!$loop->first) px-2 @endif">
                            {{ $genre->name }}
                        </span>
                    </a>
                    @if (!$loop->last)
                        |
                    @endif
                @endforeach
            </p>
            <h1 class='title text-black opacity-75 my-2'>
                {{ $book->name }}
            </h1>
            <div class='d-flex gap-2'>
                <p>
                    <span class="text-secondary pe-1">by</span>
                    <a href="{{ route('authors.show', $book->author_id) }}" style="text-decoration: none">
                        {{ $book->author->name }}
                    </a>
                </p>

                <span> | </span>

                <p>
                    <span class="text-secondary pe-2"><i class="fa-regular fa-calendar"></i></span>
                    {{ $book->published_at->format('M d, Y') }}
                </p>
            </div>

            <article class='description my-3'>
                {{ $book->excerpt }}
            </article>

            <a href="{{ $book->pdf_file }}" download>Download</a>
        </div>
    </div>
</div>
