<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Library | @yield('title')</title>

    @include('frontend.partials.styles')

    @yield('custom_style')
</head>

<body>
    
    @include('frontend.partials.loader')

    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')

    @include('frontend.partials.scripts')
    
    @yield('custom_script')
</body>

</html>
