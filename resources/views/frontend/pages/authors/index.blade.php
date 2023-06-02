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
                <a href="" class="btn btn-primary">Add Author</a>
            @endauth
            <div class="form-group my-4">
                <h1 class="title mb-4">Search with Author Name</h1>
                <x-form-input type="text" name="search" id="search-author" autocomplete="off"
                    placeholder="Search Author..." />
                <strong>
                    <small>
                        <span class="text-danger opacity-75 float-end">
                            Don't forget to press enter
                        </span>
                    </small>
                </strong>
            </div>
            <div id="result">
                <div class="row author-list gx-2 gx-md-4" id="author-list">

                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_script')
    <script>
        $(document).ready(function() {

            // Get All Authors
            const getAuthors = (query) => {
                let loader = `
                <div class="col-md-6 offset-md-3" id="authors-page-loader">
                    <div class="custom-loader section-loader my-5 mx-auto"></div>
                </div>
                `;

                $('#author-list').html(loader)

                $.ajax({
                    type: "GET",
                    url: "{{ route('authors.getAuthors') }}",
                    data: {
                        'search': query
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)

                        let output = '';
                        if (response.authors.length == 0) {
                            output +=
                                `<h3 class="text-danger text-center my-5">No Data Here ...</h3>`;
                        } else {
                            $.each(response.authors, function(index, value) {
                                output += `
                                <div class="col-6 col-md-3 my-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="profile">
                                                <img src="${value.profile}" alt="Author Profile" class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <p class="my-2"><a href="/authors/${value.id}">${value.name}</a></p>
                                        </div>
                                    </div>
                                </div>
                                `;
                            });
                        }

                        $('#author-list').html(output)
                    }
                });
            }

            $('#search-author').keypress(function(e) {
                // user must fill input with some text (except spaces)
                // if ($.trim($(this).val()) && e.keyCode == 13) {
                //     getAuthors($(this).val())
                // }

                if (e.keyCode == 13) {
                    getAuthors($(this).val())
                }
            })

            getAuthors();
        })
    </script>
@endsection
