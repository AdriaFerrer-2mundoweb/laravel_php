<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Com')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    @yield('style')
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    @yield('content')
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    @yield('script')
</body>

</html>
