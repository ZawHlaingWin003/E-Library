@extends('frontend.layouts.app')

@section('title', 'Book Library')

@section('custom_style')
    <style>
        .home-img {
            max-height: 300px;
            object-fit: contain;
        }

        .author {
            font-family: bodyRegularFont;
            letter-spacing: 3px;
            text-transform: uppercase;
        }


        .filters {
            background: var(--light);
            padding: 1rem;
            margin-bottom: 1rem;
        }


        .side-bar>div {
            background-color: var(--light);
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }

        .genres-list .genre-item,
        .author-list .author-item {
            margin: 0;
            padding: .3rem .5rem;
            color: white;
            font-size: .8rem;
            border-radius: 5px;
            background: var(--dark-color);
            cursor: pointer;
        }

        .genres-list .genre-item:hover,
        .author-list .author-item:hover {
            background: #474747;
        }

        .genres-list .genre-item:active,
        .author-list .author-item:active {
            background: #212121;
        }

        .genre-item.active,
        .author-item.active {
            color: var(--light);
            background: var(--primary-color);
        }

        .genre-item.active:hover,
        .author-item.active:hover {
            background: blue;
        }

        .social-icons a {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            color: white;
            background: var(--primary-color);
            position: relative;
        }

        .social-icons a:hover {
            background: var(--light-dark);
        }

        .social-icons a i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endsection

@section('content')
    <section>
        <div class="container books-container">
            <div class="d-flex gap-5">
                <div class="w-75">
                    <div class="main-panel">
                        {{-- <div class="filters row">
                            <div class="order-by-filter col-md-4">
                                <select name="" id="" class="primary-input">
                                    <option value="" selected disabled>Order By</option>
                                    <option value="1">Latest Added</option>
                                    <option value="5">Most Popular</option>
                                    <option value="5">Best Selling</option>
                                    <option value="10">Alphabetically, A-Z</option>
                                    <option value="15">Alphabetically, Z-A</option>
                                    <option value="15">Price, Low To High</option>
                                    <option value="15">Price, High To Low</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="book-list row gy-4" id="book-list">
                            <!-- Render your books HTML here -->
                        </div>
                        <div class="my-4" id="pagination-container">
                            <!-- Display your paginated data here -->
                        </div>
                    </div>
                </div>
                <div class="w-25">
                    <div class="side-bar">
                        <div class="search">
                            <form id="search-book-form">
                                <x-form-input name="search" id="search-book" placeholder="Search Keyword" />
                                <x-main-button type="submit" buttonId="search-book-button"
                                    loaderId="search-book-button-loader" class="w-100 justify-content-center my-3">
                                    Search
                                </x-main-button>
                            </form>
                        </div>
                        <div class="genres">
                            <h4 class="title">
                                Genres
                            </h4>
                            <hr>
                            <div class="genres-list d-flex flex-wrap gap-2">
                                <p class="genre-item active" id="genre-item">
                                    All
                                    ({{ count($books) }})
                                </p>
                                @foreach ($genres as $genre)
                                    <p class="genre-item" id="genre-item" data-id="{{ $genre->id }}">
                                        {{ $genre->name }} ({{ count($genre->books) }})
                                    </p>
                                @endforeach
                            </div>
                        </div>
                        <div class="authors">
                            <h4 class="title">
                                Authors
                            </h4>
                            <hr>
                            <div class="author-list">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    @foreach ($groupedAuthors as $key => $value)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#author-{{ $key }}"
                                                    aria-expanded="false" aria-controls="author-{{ $key }}">
                                                    {{ $key }}
                                                </button>
                                            </h2>
                                            <div id="author-{{ $key }}" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body d-flex flex-wrap gap-2">
                                                    @foreach ($value as $author)
                                                        <p class="author-item" id="author-item"
                                                            data-id="{{ $author->id }}">
                                                            {{ $author->name }} ({{ count($author->books) }})
                                                        </p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="follow-us">
                            <h4 class="title">
                                Follow us
                            </h4>
                            <hr>
                            <p class="text-center">

                                Follow on Most Popular social community and receive NEW posts in your social line every day!
                            </p>
                            <div class="social-icons px-4 mt-3 d-flex justify-content-between">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram-square"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                        <div class="subscribe">
                            <h4 class="title">Newsletter</h4>
                            <hr>
                            <x-form action="{{ route('newsletter.subscribe') }}" method="POST" id="subscribe-form">
                                @csrf

                                <x-form-group class="mb-3" id="email-input-group">
                                    <x-form-input type="email" name="email" placeholder="Enter Email" id="email" />
                                </x-form-group>

                                <x-main-button type="submit" class="w-100 justify-content-center"
                                    buttonId="subscribe-button" iconName="fa-bell" iconId="subscribe-button-icon"
                                    loaderId="subscribe-button-loader">
                                    Subscribe
                                </x-main-button>
                            </x-form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('custom_script')
    <script src="{{ asset('frontend/js/fetch/subscribe-form.js') }}"></script>
    <script src="{{ asset('frontend/js/fetch/book-page.js') }}"></script>
@endsection
