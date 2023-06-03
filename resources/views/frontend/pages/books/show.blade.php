@extends('frontend.layouts.app')

@section('title', $book->name)

@section('custom_style')
    <style>
        .book-section {
            font-family: bodyRegularFont;
        }

        .book-text .genres a {
            text-decoration: none;
        }

        .book-cover img {
            width: 100%;
            height: 300px;
            object-fit: contain;
        }

        .pdf-wrapper {
            width: 100%;
            margin: 100px auto;
            text-align: center;
        }

        .pdf-wrapper .link-title {
            width: 80%;
            margin: 8px auto;
            text-align: left;
        }

        .pdf-wrapper .link-title a {
            font-size: 1.5rem;
            color: gray;
        }

        .pdf-wrapper .link-title a:hover {
            color: rgb(90, 90, 90);
        }

        .pdf {
            width: 80%;
            height: 85vh;
            margin: 0 auto;
            border: 5px solid #000;
        }

        @media screen and (max-width: 768px) {

            .pdf-wrapper .link-title,
            .pdf {
                width: 100%
            }
        }


        /* Heart Btn */
        .heart-btn {
            display: inline-block;
        }

        .heart-btn .content {
            padding: 10px 15px;
            border: 2px solid gray;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
        }

        .likeBtn.heart-active {
            border-color: #E2264D;
        }

        .likeBtn.heart-active .text {
            color: #E2264D;
        }

        .heart-btn .heart {
            position: absolute;
            background: url('{{ asset('frontend/assets/images/heart-btn.png') }}') no-repeat;
            background-position: left;
            background-size: 2900%;
            height: 90px;
            width: 90px;
            top: 50%;
            left: 10%;
            transform: translate(-50%, -50%);
        }

        .heart-btn .text {
            color: #000;
            margin-left: 1.5rem;
        }

        .heart-btn .likeCount {
            margin-left: .2rem;
            color: #000;
        }

        .likeCount.heart-active,
        .text.heart-active {
            color: #E2264D;
        }

        .heart.heart-active {
            animation: animate .8s steps(28) 1;
            background-position: right;
        }

        @keyframes animate {
            0% {
                background-position: left;
            }

            100% {
                background-position: right;
            }
        }

        .username {
            font-family: titleRegularFont;
            font-size: 1.2rem;
            margin: 0;
        }

        .review-at {
            font-size: .8rem;
        }

        .actions {
            opacity: 0;
        }

        .review-card:hover .actions {
            opacity: 1;
            transition: all .2s;
        }

        .swal2-container {
            padding: 0;
        }

        body {
            padding: 0 !important;
        }
    </style>
@endsection

@section('content')
    <section class='book-section container'>
        <x-link-button href="{{ route('books.index') }}" loaderId="go-back-button-loader" class="mb-5"
            iconName="fa-arrow-left">
            To Library
        </x-link-button>

        <div class='book-detail'>
            <x-book-detail :book="$book" />

            <x-pdf-viewer :book="$book" />

            <hr>

            <x-recommend-book :book="$book" />

            <x-book-review-form :book="$book" />

            <div class="review-list" id="review-list">

            </div>

            <x-edit-review-modal />

        </div>
    </section>

@endsection


@section('custom_script')
    <script>
        $(document).ready(function() {

            let authCheck = !!{{ auth()->check() }} // Is user authenticated or not
            let authUserId = {{ auth()->id() }}
            let bookId = {{ $book->id }}

            // HTML codes which we want to render in page after fetch data
            const renderBookReviewsHTML = (response) => {
                $('#total-reviews').html(response.data.length)

                let output = '';
                $.each(response.data, function(index, data) {
                    let userId = data.user.id
                    let actionsHtml = '';

                    if (authCheck && authUserId == userId) {
                        actionsHtml += `
                                <div class="actions">
                                    <button class="btn btn-sm btn-primary mx-3" id="edit-review-button"
                                        data-id="${data.id}" data-bs-toggle="modal"
                                        data-bs-target="#edit-review-modal">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-id="${data.id}"
                                        id="delete-review-button"><i class="fa fa-trash"></i></button>
                                </div>
                                `;
                    }

                    output += `
                            <div class="card review-card p-3 mb-3">
                                <div class="d-flex gap-3">
                                    <div class="user-img">
                                        <img src="https://ui-avatars.com/api/?name=${data.user.name}" alt="user-img"
                                            width="38" class="img-fluid rounded-circle" />
                                    </div>
                                    <div style="width: 100%;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="info">
                                                <p class="username">${data.user.name}</p>
                                                <p class="review-at">${moment(data.updated_at).fromNow()}</p>
                                            </div>
                                            ${actionsHtml}
                                        </div>
                                        <div class="review-content">
                                            <p>${data.content}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                });

                return output;
            }

            // data that we want to pass to request server
            let data = {};

            // Get All Books
            const getBookReviews = () => {
                const loaderHTML = `
                            <div class="my-3 d-flex justify-content-center align-items-center" id="review-section-loader">
                                <div class="custom-loader section-loader"></div>
                            </div>
                            `;

                const elementContainer = $('#review-list');
                const url = "{{ route('reviews.index') }}";

                data = {
                    'bookId': bookId
                };

                fetchData(elementContainer, loaderHTML, url, data)
                    .then((response) => {
                        elementContainer.html(renderBookReviewsHTML(response))
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            };

            // Get All Validation Error Messages
            const getValidationErrorMessages = (errors, update = false) => {
                $.each(errors, function(field, messages) {
                    if (update) {
                        var input = $('#update' + '-' + field);
                    } else {
                        var input = $('#' + field);
                    }
                    var errorMessage = `<span class="error-message">${messages[0]}</span>`;
                    input.addClass('error');
                    input.after(errorMessage);
                });
            }

            // Get All Book Reviews
            getBookReviews();

            // Add Book Review
            $('#add-review-form').submit(function(e) {
                e.preventDefault();

                $('#add-review-button-loader').show();
                $('#add-review-button-icon').hide();
                $("#add-review-button").attr('disabled', true);

                $('.error').removeClass('error');
                $('.error-message').remove();

                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        $('#add-review-form')[0].reset();
                        toastr.success(response.message);
                        getBookReviews();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            getValidationErrorMessages(errors)
                        } else {
                            alert(xhr.status)
                        }
                    },
                    complete: function() {
                        $('#add-review-button-loader').hide();
                        $('#add-review-button-icon').show();
                        $("#add-review-button").attr('disabled', false);
                    }
                });
            })

            // Delete Review
            $(document).on('click', '#delete-review-button', function() {
                let reviewId = $(this).data('id');
                let url = `/reviews/${reviewId}`

                swal.fire({
                    title: 'Are you sure?',
                    showCancelButton: true,
                    showCloseButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes',
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#0b5ed7',
                    width: 300,
                    allowOutsideClick: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {
                                getBookReviews();
                                toastr.success("Review deleted successfully");
                            }
                        });
                    }
                });
            });

            // Get Clicked Review Data and Open Review Edit Modal
            $(document).on('click', '#edit-review-button', function() {
                var reviewId = $(this).data('id');

                $('.error').removeClass('error');
                $('.error-message').remove();

                $('#edit-form-loader').removeClass('d-none').addClass('d-block')
                $('#update-review-form').hide();

                $.get(`/reviews/${reviewId}`, function(data) {
                    $('#update-review-id').val(data.id);
                    $('#update-content').val(data.content);

                    $('#edit-form-loader').removeClass('d-block').addClass('d-none')
                    $('#update-review-form').show();
                });
            });

            // Update Book Review Content
            $('#update-review-form').submit(function(e) {
                e.preventDefault();

                $("#update-review-button-loader").show();
                $("#update-review-button-icon").hide();
                $("#update-review-button").attr('disabled', true);

                let reviewId = $('#update-review-id').val();
                let content = $('#update-content').val();

                let url = `/reviews/${reviewId}`;

                let data = {
                    'content': content
                };

                $.ajax({
                    type: "PUT",
                    url: url,
                    data: data,
                    success: function(data) {
                        $("#update-review-form")[0].reset();
                        $("#edit-review-modal").modal("hide")

                        getBookReviews();
                        toastr.success(data.message);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            getValidationErrorMessages(errors, true)
                        } else {
                            alert(xhr)
                        }
                    },
                    complete: function() {
                        $('#update-review-button-loader').hide();
                        $('#update-review-button-icon').show();
                        $("#update-review-button").attr('disabled', false);
                    }
                });
            })

        });


        const likeBtn = document.querySelector(".likeBtn");
        const likeCount = document.querySelector(".likeCount");
        const text = document.querySelector(".likeBtn .text");
        const heart = document.querySelector(".heart");

        let clicked = false;

        likeBtn.addEventListener("click", function() {
            if (!clicked) {
                clicked = true;
                likeCount.textContent++;
                this.classList.add("heart-active");
                text.classList.add("heart-active");
                heart.classList.add("heart-active");
                likeCount.classList.add("heart-active");
            } else {
                clicked = false;
                this.classList.remove("heart-active");
                text.classList.remove("heart-active");
                heart.classList.remove("heart-active");
                likeCount.classList.remove("heart-active");
                likeCount.textContent--;
            }
        });
    </script>
@endsection
