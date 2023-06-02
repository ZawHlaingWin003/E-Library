<!-- Books -->
<section class="popular-books">
    <div class="container">
        <h1 class="heading my-5"> <span>let's read books</span> </h1>

        <div class="recent-book-list">
            <div class="d-md-flex justify-content-between align-items-center">
                <h3 class="title mb-2 mb-md-0">Popular Book List</h3>
                <a href="{{ route('books.index') }}" class="btn btn-primary primary-btn">View All</a>
            </div>
            <hr>
            <div class="container swiper books-slider">
                <div class="book-list swiper-wrapper">
                    @foreach ($books as $book)
                        <x-book-card :book="$book" class="swiper-slide" />
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</section>
