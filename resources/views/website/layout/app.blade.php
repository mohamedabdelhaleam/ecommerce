<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Shop')</title>
    @include('website.components.styles')
</head>

<body class="font-display bg-brand-offwhite dark:bg-background-dark text-brand-charcoal dark:text-gray-200">
    <div class="px-4 sm:px-8 md:px-16 lg:px-24 flex flex-1 justify-center py-5">
        <div class="layout-content-container flex flex-col w-full max-w-8xl flex-1">
            @include('website.layout.header')

            @yield('contents')

            @include('website.layout.footer')
        </div>
    </div>
    @include('website.components.scripts')
</body>

</html>
