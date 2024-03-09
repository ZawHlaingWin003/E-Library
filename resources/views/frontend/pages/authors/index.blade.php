@extends('frontend.layouts.app')

@section('title', 'Author List')

@section('custom_style')
    <style>
        .author-list .profile {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border: 1px solid gray;
            border-radius: 50%;
            margin: 0 auto;
        }

        .author-list .profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
    <section class="authors">
        <div class="container">
            @auth('admin_user')
                <a class="btn btn-primary" href="{{ route('admin.authors.create') }}">Add Author</a>
            @endauth
            <div class="form-group my-4">
                <h1 class="title mb-4">Search with Author Name</h1>
                <x-form-input autocomplete="off" id="search-author" name="search" placeholder="Search Author..." type="text" />
                <strong>
                    <small>
                        <span class="text-danger float-end opacity-75">
                            Don't forget to press enter
                        </span>
                    </small>
                </strong>
            </div>
            <div id="result">
                <div class="row author-list gx-2 gx-md-4" id="author-list">
                    {{-- Render the author list HTML --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_script')
    <script>
        $(document).ready(function() {
            // HTML codes which we want to render in page after fetch data
            const renderAuthorsHTML = (response) => {
                let output = '';
                if (response.data.length == 0) {
                    output += `
                    <div class="w-100">
                        <img src="/frontend/assets/images/404-page.png" class="w-50 d-flex mx-auto" alt="404 Page">
                        <h3 class="text-danger text-center"><strong>Sorry 🙁, No Data Here ...</strong></h3>
                    </div>
                    `;
                } else {
                    $.each(response.data, function(index, data) {
                        output += `
                                <div class="col-6 col-md-3 my-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="profile">
                                                <img src="${data.profile}" alt="Author Profile" class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <p class="my-2"><a href="/authors/${data.id}">${data.name}</a></p>
                                        </div>
                                    </div>
                                </div>
                                `;
                    });
                }

                return output;
            }

            let data = {};

            // Get All Authors
            const getAuthors = () => {
                const loaderHTML = `
                <div class="col-md-6 offset-md-3" id="authors-page-loader">
                    <div class="custom-loader section-loader my-5 mx-auto"></div>
                </div>
                `;

                const elementContainer = $('#author-list');
                const url = "{{ route('authors.getAuthors') }}";

                fetchData(elementContainer, loaderHTML, url, data)
                    .then((response) => {
                        elementContainer.html(renderAuthorsHTML(response))
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            };

            // Filter Authors By Search
            $('#search-author').keypress(function(e) {
                // user must fill input with some text (except spaces)
                // if ($.trim($(this).val()) && e.keyCode == 13) {
                //     getAuthors($(this).val())
                // }
                data.search = $(this).val()

                if (e.keyCode == 13) {
                    getAuthors()
                }
            })

            getAuthors();
        })
    </script>
@endsection
