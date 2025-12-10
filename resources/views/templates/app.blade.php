<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flynetic</title>
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand me-4" href="{{ route('home') }}">
                <i class="fa-solid fa-plane"></i> <span class="fw-bold">Flynetic</span>
            </a>

            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    {{-- Navigasi untuk ADMIN --}}
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>

                        {{-- Data Master --}}
                        <li class="nav-item dropdown">
                            <a data-mdb-dropdown-init class="nav-link dropdown-toggle" href="#"
                                id="navbarDropdownDataMaster" role="button" aria-expanded="false">
                                Data Master
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownDataMaster">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.airlines.index') }}">Kelola Maskapai</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">Jadwal Penerbangan</a>
                                    {{-- Menggunakan movies.index sebagai placeholder untuk flights/schedules --}}
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">Data Petugas</a>
                                </li>
                            </ul>
                        </li>

                        {{-- Navigasi untuk USER (Authenticated Non-Admin) --}}
                    @elseif (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}"><b>Beranda</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.bookings.history') }}"><b>Riwayat Pemesanan</b></a>
                        </li>
                    @endif
                </ul>
                <div class="d-flex align-items-center">
                    @if (Auth::check())
                        <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                    @else
                        <a href="{{ route('login') }}" type="button" class="btn btn-link px-3 me-2">Login</a>
                        <a href="{{ route('signup') }}" type="button" class="btn btn-primary me-3">Sign up</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous">
        </script>

    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
    {{-- datatables --}}
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    {{-- chartJS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('script')
</body>

</html>