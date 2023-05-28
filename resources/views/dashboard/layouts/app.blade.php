<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>Dashboard | @yield('title')</title>
    
    @include('dashboard.partials.styles')

    @yield('custom_style')
</head>

<body>
    
    @include('dashboard.partials.loader')

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5">
        
        @include('dashboard.partials.header')

        @include('dashboard.partials.left-sidebar')

        <div class="page-wrapper">
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">@yield('title')</h4>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                @yield('content')
            </div>

            <footer class="footer text-center">
            {{ date('Y') }} © David Zaw. You can download admin dashboard at
            <a href="https://www.wrappixel.com/">wrappixel.com</a>
            </footer>
        </div>

    </div>

    @include('dashboard.partials.scripts')

    @yield('custom_script')
</body>
</html>
