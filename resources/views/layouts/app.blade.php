<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}"> {{-- <- bootstrap css --}}
    <script src="{{asset('js/app.js')}}"></script> {{-- <- bootstrap and jquery --}}

    <title>@yield('title','Laravel 5.8 Basics')</title>
</head>
<body>

    {{-- That's how you write a comment in blade --}}

    @include('include.navbar')

    <main class="container mt-4">
        @yield('content')
    </main>

    {{--@include('include.footer') --}}

    
</body>
</html>