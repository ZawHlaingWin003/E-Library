<!-- Home -->
<section class="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-sm-12">
                <p class="intro">Welcome to our</p>
                <h1 class="title display-4 mb-2">public <span class="text-primary">E</span>-library</h1>
                <p class="description mb-4">
                    You can learn anything in our library for free.<br />
                    Remember! For Free, For Everyone.
                </p>
                <a href="{{ route('books.index') }}" class="btn btn-primary primary-btn">
                    Go To Library
                </a>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="swiper stand-books-slider">
                    <div class="swiper-wrapper">
                        <a href="" class="swiper-slide"><img
                                src="{{ asset('frontend/assets/images/books/book-1.png') }}" alt=""></a>
                        <a href="" class="swiper-slide"><img
                                src="{{ asset('frontend/assets/images/books/book-2.png') }}" alt=""></a>
                        <a href="" class="swiper-slide"><img
                                src="{{ asset('frontend/assets/images/books/book-3.png') }}" alt=""></a>
                        <a href="" class="swiper-slide"><img
                                src="{{ asset('frontend/assets/images/books/book-4.png') }}" alt=""></a>
                        <a href="" class="swiper-slide"><img
                                src="{{ asset('frontend/assets/images/books/book-5.png') }}" alt=""></a>
                        <a href="" class="swiper-slide"><img
                                src="{{ asset('frontend/assets/images/books/book-6.png') }}" alt=""></a>

                    </div>
                    <img src="{{ asset('frontend/assets/images/stand.png') }}" class="stand" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
