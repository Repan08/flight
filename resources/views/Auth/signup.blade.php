<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pesawat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <!-- Kolom Form -->
        <div class="row g-3 align-items-end">
            <div class="card-body p-4">
                <h4 class="text-center text-primary mb-4">
                    <i class="bi bi-airplane-fill me-2"></i>Sign Up Flight
                </h4>

                <div class="row g-3 align-items-end">
                    <form class="w-50 d-block mx-auto my-5" method="POST" action="{{ route('signup.send_data') }}">
                        @if (Session::get('failed'))
                            <div class="alert alert-danger my-3">{{ Session::get('failed') }}</div>
                        @endif
                        @csrf
                        <div class="row mb-4">
                            <div class="col">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <div class="form-outline" class="row g-3 align-items-end">
                                    <label for="text" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        placeholder="Nama Lengkap" value="{{ old('namaLengkap') }}"/>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" id="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                    placeholder="Nomor Telepon" value="{{ old('nomorTelepon') }}">
                                @error('phone_number')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password" value="{{ old('password') }}">
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <button data-mdb-input-init type="submit" class="btn btn-primary btn-block">Sign Up</button>
                            <div class="text-center mt-3">
                                <a href="{{ route('home') }}">Kembali</a>
                            </div>
                        </div>
                    </form>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                        crossorigin="anonymous">
                        </script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
                        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
                        crossorigin="anonymous">
                        </script>
                    <!-- MDB -->
                    <script type="text/javascript"
                        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>

                    <!-- MDB -->
                    <script type="text/javascript"
                        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
                </div>
            </div>
        </div>
</body>

</html>