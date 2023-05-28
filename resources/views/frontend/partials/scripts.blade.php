<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('frontend/js/toastr.min.js') }}"></script>
<script src="{{ asset('frontend/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('frontend/js/script.js') }}"></script>

<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": 5000,
            "preventDuplicates": true
        }

        @if (Session::has('error'))
            toastr.error('{{ session('error') }}');
        @elseif (Session::has('success'))
            toastr.success('{{ session('success') }}');
        @endif
    });
</script>
