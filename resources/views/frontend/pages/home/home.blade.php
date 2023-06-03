@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    @include('frontend.pages.home.sections.home-section')

    @include('frontend.pages.home.sections.about-section')

    @include('frontend.pages.home.sections.books-section')

    @include('frontend.pages.home.sections.newsletter-section')
@endsection


@section('custom_script')
    <script src="{{ asset('frontend/js/fetch/subscribe-form.js') }}"></script>
    <script>
        $(document).ready(function() {
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
