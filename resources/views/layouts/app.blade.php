<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <title>@yield('title', 'Life')</title>
    <script src="{{ asset('js/vendor/htmx.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
@yield('content')
@stack('scripts')
</body>
</html>
