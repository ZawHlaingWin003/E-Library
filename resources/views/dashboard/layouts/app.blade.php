<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>E-Library Dashboard | @yield('title')</title>

    @include('dashboard.partials.styles')

    @yield('custom_style')
</head>

<body>

    @include('dashboard.partials.sidebar')
    
    @include('dashboard.partials.header')

    <div class="main-content">
        <main>
            <h3 class="dash-title">@yield('title')</h3>

            @yield('content')
        </section>
        </main>
    </div>


    @include('dashboard.partials.scripts')

    @yield('custom_script')
</body>

</html>
