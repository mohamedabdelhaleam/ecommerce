<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shop')</title>
    @include('website.components.styles')
</head>

<body class="font-display bg-white dark:bg-background-dark text-brand-charcoal dark:text-gray-200">
    <!-- Page Loader -->
    <div id="page-loader">
        <div class="loader-content">
            <div class="loader-dots">
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
            </div>
            <div class="loader-text">Loading...</div>
        </div>
    </div>

    <div class="px-4 sm:px-8 md:px-16 lg:px-24 flex flex-1 justify-center py-5">
        <div class="layout-content-container flex flex-col w-full max-w-8xl flex-1">
            @include('website.layout.header')

            @yield('contents')

            @include('website.layout.footer')
        </div>
    </div>
    @include('website.components.scripts')
    @stack('scripts')
</body>

</html>
