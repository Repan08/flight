<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesawat</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>

<body>
    <div class="navbar navbar-light bg-light">
        <nav class="container">
            <a class="navbar-brand" href="#">
                {{-- <img src="" alt="" width="30" height="24" class="d-inline-block align-text-top"> --}}
                Flight.com
            </a>
            <div class="d-flex align-items-center">
                <!-- Auth::check() -> ngecek uda login/belum -->
                @if (Auth::check())
                    <a href="{{ route('logout') }}" type="button" class="btn btn-danger">Logout</a>
                @else
                <a href="{{ route('login') }}" type="button" class="btn btn-link px-3 me-2">Login</a>
                <a href="{{ route('signup') }}" type="button" class="btn btn-primary me-3">Sign up</a>
                @endif
            </div>
        </nav>
    </div>
    @yield('content')
</body>

</html>