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
        <x-link-button href="{{ route('books.index') }}" loaderId="go-back-button-loader" class="mb-5" iconName="fa-arrow-left">
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            let authCheck = !!{{ auth()->check() }}
            let authUserId = {{ auth()->id() }}
            let bookId = {{ $book->id }}

            const getBookReviews = () => {
                let loader = `
                <div class="my-3 d-flex justify-content-center align-items-center" id="review-section-loader">
                    <div class="custom-loader section-loader"></div>
                </div>
                `;

                $('#review-list').html(loader)

                $.ajax({
                    type: "GET",
                    url: "{{ route('review.index') }}",
                    data: {
                        'bookId': bookId
                    },
                    success: function(response) {
                        $('#total-reviews').html(response.reviews.length)
                        let output = '';
                        $.each(response.reviews, function(index, review) {
                            let user_id = review.user.id
                            let actionsHtml = '';

                            if (authCheck && authUserId == review.user_id) {
                                actionsHtml += `
                                <div class="actions">
                                    <button class="btn btn-sm btn-primary mx-3" id="edit-review-button"
                                        data-id="${review.id}" data-bs-toggle="modal"
                                        data-bs-target="#edit-review-modal">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-id="${review.id}"
                                        id="delete-review-button"><i class="fa fa-trash"></i></button>
                                </div>
                                `;
                            }

                            output += `
                            <div class="card review-card p-3 mb-3">
                                <div class="d-flex gap-3">
                                    <div class="user-img">
                                        <img src="https://ui-avatars.com/api/?name=${review.user.name}" alt="user-img"
                                            width="38" class="img-fluid rounded-circle" />
                                    </div>
                                    <div style="width: 100%;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="info">
                                                <p class="username">${review.user.name}</p>
                                                <p class="review-at">${moment(review.updated_at).fromNow()}</p>
                                            </div>
                                            ${actionsHtml}
                                        </div>
                                        <div class="review-content">
                                            <p>${review.content}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        });

                        $('#review-list').html(output);
                    }
                });
            }

            // Get All Book Reviews
            getBookReviews();

            // Add Book Review
            $('#add-review-form').submit(function(e) {
                e.preventDefault();

                $("#add-review-button-loader").removeClass('d-none').addClass('d-block');
                $("#add-review-button-icon").removeClass('d-block').addClass('d-none');
                $("#add-review-button").attr('disabled', true).css('cursor', 'not-allowed');

                let url = $(this).attr('action');
                let data = {
                    'bookId': bookId,
                    'content': $('#content-field').val()
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(data) {
                        console.log(data)
                        if (data.status == 201) {
                            $("#add-review-form")[0].reset();
                            getBookReviews();
                            toastr.success(data.response);
                        } else if (data.status == 400) {
                            $.each(data.response, function(key, value) {
                                $("." + key + "-error").text(value);
                                $("#" + key + "-field").css("border-color", "red")
                            });
                        }

                        $('#add-review-button-loader').removeClass('d-block').addClass('d-none')
                        $("#add-review-button-icon").removeClass('d-none').addClass('d-block');
                        $("#add-review-button").attr('disabled', false).css('cursor', 'pointer')
                    }
                });
            })

            // Delete Review
            $(document).on('click', '#delete-review-button', function() {
                let review_id = $(this).data('id');
                let url = `/reviews/destroy/${review_id}`

                swal.fire({
                    title: 'Are you sure?',
                    showCancelButton: true,
                    showCloseButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes',
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#556ee6',
                    width: 300,
                    allowOutsideClick: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {
                                console.log(response)
                                getBookReviews();
                                toastr.success("Review deleted successfully");
                            }
                        });
                    }
                });
            });

            // Open Review Edit Modal
            $(document).on('click', '#edit-review-button', function() {
                var review_id = $(this).data('id');
                $('#edit-form-loader').removeClass('d-none').addClass('d-block')
                $('#update-review-form').addClass('d-none');
                $.get(`/reviews/${review_id}`, function(data) {
                    $('#update-review-id').val(data.id);
                    $('#update-review-content').val(data.content);
                    $('#edit-form-loader').removeClass('d-block').addClass('d-none')
                    $('#update-review-form').removeClass('d-none');
                });
            });

            // Update Book Review Content
            $('#update-review-form').submit(function(e) {
                e.preventDefault();

                $("#update-review-button-loader").removeClass('d-none').addClass('d-block');
                $("#update-review-button-icon").removeClass('d-block').addClass('d-none');
                $("#update-review-button").attr('disabled', true).css('cursor', 'not-allowed');

                let reviewId = $('#update-review-id').val();
                let content = $('#update-review-content').val();

                let url = `/reviews/update/${reviewId}`;

                let data = {
                    'content': content
                };
                $.ajax({
                    type: "PUT",
                    url: url,
                    data: data,
                    success: function(data) {
                        if (data.status == 200) {
                            $("#update-review-form")[0].reset();
                            $("#edit-review-modal").modal("hide")
                            getBookReviews();
                            toastr.success(data.response);
                        } else if (data.status == 400) {
                            $.each(data.response, function(key, value) {
                                $(".update-" + key + "-error").text(value);
                                toastr.error(value)
                                setTimeout(() => {
                                    $(".update-" + key + "-error").text('');
                                }, 3000);
                            });
                        }
                        $('#update-review-button-loader').removeClass('d-block').addClass(
                            'd-none')
                        $("#update-review-button-icon").removeClass('d-none').addClass(
                            'd-block');
                        $("#update-review-button").attr('disabled', false).css('cursor',
                            'pointer');
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
