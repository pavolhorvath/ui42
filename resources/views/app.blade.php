<!DOCTYPE html>
<html lang="sk-SK">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ui42</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="min-vh-100 d-flex flex-column">
        @include('header')

        <div class="content flex-grow-1 d-flex align-items-center">
            <div class="container">
                @yield('content')
            </div>
        </div>

        @include('footer')
    </div>
</body>
</html>
