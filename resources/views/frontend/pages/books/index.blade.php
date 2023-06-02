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
            padding: 2rem;
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

        .social-icons a {
            width: 40px;
            height: 40px;
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

    <!-- Home -->
    <section class="home text-center">
        <div class="container text-center">
            <h1 class="display-2 mb-4">
                <i class="fa fa-running"></i> coming soon <i class="fa fa-running"></i>
            </h1>
            <p class="text-danger">This page is under construction!</p>
        </div>
    </section>

    <hr>

    <section>
        <div class="container books-container">
            <div class="row gx-4">
                <div class="col-md-8">
                    <div class="main-panel">
                        <div class="filters row">
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
                        </div>
                        <div class="book-list row gy-4" id="book-list">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="side-bar">
                        <div class="search">
                            <form action="">
                                <x-form-input name="search" placeholder="Search Keyword" />
                                <x-main-button type="submit" buttonId="subscribe-button" loaderId="subscribe-button-loader"
                                    class="w-100 justify-content-center my-3">
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
                                <p class="genre-item">
                                    All
                                    ({{ count($books) }})
                                </p>
                                @foreach ($genres as $genre)
                                    <p class="genre-item">
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
                                                        <p class="author-item">
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
                            <p>

                                Follow on Most Popular social community and receive NEW posts in your social line every day!
                            </p>
                            <div class="social-icons mt-3 d-flex justify-content-between">
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

                                <div id="response" class="d-none"></div>

                                <x-form-group class="mb-3">
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
    <script>
        $(document).ready(function() {

            const renderBooksHTML = (response) => {
                let output = '';
                $.each(response.data, function(index, data) {
                    output += `
                    <div class="col-md-6">
                        <div class="book-card border">
                            <div class="card p-3 border-0">
                                <img src="${data.cover}" alt="Book-Cover" class="book-cover">
                                <hr>
                                <h3 class="book-title text-center"><a href="books/${data.slug}">${data.name}</a></h3>
                                <p class="book-author text-center mt-3">
                                    By : 
                                    <a href="/authors/${data.author}">
                                        ${data.author.name}
                                    </a>
                                </p>
                                <a href="books/${data.slug}" class="btn btn-primary primary-btn">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                    `
                });

                return output;
            }

            // Get All Books
            const getBooks = () => {
                const loaderHTML = `<div class="my-5 d-flex justify-content-center align-items-center" id="book-section-loader">
                    <div class="custom-loader section-loader"></div>
                </div>
                `;

                const elementContainer = $('#book-list');
                const url = "{{ route('books.getBooks') }}";
                console.log(elementContainer)

                fetchData(elementContainer, loaderHTML, url)
                    .then((response) => {
                        console.log(response)
                        elementContainer.html(renderBooksHTML(response))
                        // elementContainer.html('Heyy')
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            };
            // const getBooks = () => {

            //     $.ajax({
            //         type: "GET",
            //         url: "{{ route('books.getBooks') }}",
            //         beforeSend: function() {
            //             // Show the Loading Spinner
            //             const loaderHTML = `<div class="my-5 d-flex justify-content-center align-items-center" id="book-section-loader">
        //         <div class="custom-loader section-loader"></div>
        //     </div>
        //     `;
            //             $('#book-list').html(loaderHTML)
            //         },
            //         success: function(response) {
            //             console.log(response)
            //             let output = '';
            //             if (response.data.length == 0) {
            //                 output +=
            //                     `<h3 class="text-danger text-center my-5">No Data Here ...</h3>`;
            //             } else {
            //                 $.each(response.authors, function(index, value) {
            //                     output += `
        //                     `;
            //                 });
            //             }

            //             $('#book-list').html(output)
            //         }
            //     });
            // }

            $('#search-author').keypress(function(e) {
                // user must fill input with some text (except spaces)
                // if ($.trim($(this).val()) && e.keyCode == 13) {
                //     getAuthors($(this).val())
                // }

                if (e.keyCode == 13) {
                    getAuthors($(this).val())
                }
            })

            getBooks();
        })
    </script>
@endsection
