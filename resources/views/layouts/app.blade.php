<!DOCTYPE html>
<html>

<head>
    @include('includes.head')
</head>

<body>

    @include('includes.header')

@yield('content')

    @include('includes.footer')

    @stack('styles')
    @stack('scripts')
</body>

</html>
