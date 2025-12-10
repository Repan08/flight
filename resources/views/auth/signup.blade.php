<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Flight</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        :root {
            --brand: #0b5ed7;
            --brand-dark: #0a58c7;
            --brand-light-bg: #e7f0ff;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f8fbff 0%, #f2f6ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-card {
            max-width: 520px;
            border: none;
            border-radius: 0.8rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header-brand {
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            color: white;
            border-radius: 0.8rem 0.8rem 0 0;
            text-align: center;
            padding: 2rem 1.5rem;
        }

        .brand-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .btn-primary-brand {
            background-color: var(--brand);
            border-color: var(--brand);
            font-size: 1.02rem;
            padding: 0.65rem 1rem;
        }

        .btn-primary-brand:hover {
            background-color: var(--brand-dark);
            border-color: var(--brand-dark);
        }

        .form-control {
            font-size: 1.02rem;
            padding: 0.65rem 0.75rem;
            border-radius: 0.5rem;
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 0.2rem rgba(11, 94, 215, 0.15);
        }

        .input-group-text {
            background-color: transparent;
            border: 1px solid #dee2e6;
            color: #6c757d;
        }

        .input-group .form-control:focus ~ .input-group-text,
        .input-group .form-control:focus + .input-group-text {
            border-color: var(--brand);
            color: var(--brand);
        }

        .invalid-feedback {
            display: block;
            font-size: 0.9rem;
        }

        .alert {
            border-radius: 0.5rem;
        }

        .text-brand {
            color: var(--brand);
        }

        a {
            color: var(--brand);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 signup-card">
                <div class="card signup-card">
                    <div class="card-header-brand">
                        <div class="brand-icon">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <h4 class="mb-1">Daftar Akun Flight</h4>
                        <p class="mb-0 small">Mulai perjalanan penerbangan Anda dengan kami</p>
                    </div>

                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('signup.register') }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                        value="{{ old('email') }}" placeholder="nama@contoh.com" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" id="phone_number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" 
                                        value="{{ old('phone_number') }}" placeholder="08123456789" required>
                                </div>
                                @error('phone_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                        placeholder="Minimal 8 karakter" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Tampilkan kata sandi">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-brand btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a> • <a href="{{ route('home') }}">Kembali</a></small>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted small">© {{ date('Y') }} Flight — Semua hak dilindungi</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script>
        // Toggle password visibility
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePassword');
        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                }
            });
        }
    </script>
</body>

</html>