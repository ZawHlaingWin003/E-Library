@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    @include('frontend.pages.home.sections.home-section')

    @include('frontend.pages.home.sections.about-section')

    @include('frontend.pages.home.sections.books-section')

    @include('frontend.pages.home.sections.newsletter-section')
@endsection


@section('custom_script')
    <script>
        $(document).ready(function() {
            // Submit NewsLetter Subscribe Form
            $('#subscribe-form').submit(function(e) {
                e.preventDefault();
                $(".error").text('');
                $("#subscribe-button-loader").removeClass('d-none').addClass('d-block');
                $("#subscribe-button-icon").removeClass('d-block').addClass('d-none');
                $("#subscribe-button").attr('disabled', true).css('cursor', 'wait');

                let url = $(this).attr('action');

                var _token = $("input[name='_token']").val();
                var email = $("#email").val();

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: _token,
                        email: email
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('.error').text('');
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            let success = '<p class="alert alert-success">' + data.response +
                                '</p>';

                            $("#response").addClass('d-block').removeClass('d-none').html(
                                success);
                            $("#subscribe-form")[0].reset();

                        } else if (data.code == 400) {
                            $.each(data.response, function(key, value) {
                                $("." + key + "-error").text(value);
                            });
                        }

                        $('#subscribe-button-loader').removeClass('d-block').addClass('d-none')
                        $("#subscribe-button-icon").removeClass('d-none').addClass('d-block');
                        $("#subscribe-button").attr('disabled', false).css('cursor', 'pointer');

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr, status, error)
                        if (xhr.status == 401) {
                            Command: toastr["error"]("Unauthorized. Please Login First")
                        }

                        $('#subscribe-button-loader').removeClass('d-block').addClass('d-none')
                        $("#subscribe-button-icon").removeClass('d-none').addClass('d-block');
                        $("#subscribe-button").attr('disabled', false).css('cursor', 'pointer');

                    }
                });
            });

            // Auto Count Numbers
            let nCount = selector => {
                $(selector).each(function() {
                    $(this)
                        .animate({
                            Counter: $(this).text()
                        }, {
                            duration: 4000,
                            easing: "swing",
                            step: function(value) {
                                $(this).text(Math.ceil(value));
                            }
                        });
                });
            };

            let a = 0;
            $(window).scroll(function() {
                let oTop = $(".numbers").offset().top - window.innerHeight;
                if (a == 0 && $(window).scrollTop() >= oTop) {
                    a++;
                    nCount(".rect > h1");
                }
            });
        })
    </script>
@endsection
