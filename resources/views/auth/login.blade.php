<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Flight</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body { font-family: 'Roboto', sans-serif; background: linear-gradient(135deg,#f8fbff 0%, #f2f6ff 100%); }
        .login-card { max-width: 520px; margin-top: 6vh; }
        .brand { font-weight: 700; letter-spacing: .5px; }
        .form-control { font-size: 1.02rem; padding: .65rem .75rem; }
        .btn-lg { font-size: 1.03rem; }
        .card { border-radius: .8rem; }
        .muted-link { color: #6c757d; }
        .divider { height: 1px; background: #e9ecef; margin: 1.5rem 0; }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 login-card">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-plane-departure fa-2x text-primary"></i>
                            </div>
                            <div>
                                <div class="brand h5 mb-0">Flight</div>
                                <small class="text-muted">Masuk untuk melanjutkan pemesanan</small>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('auth') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="nama@contoh.com" required aria-required="true">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan kata sandi" required aria-required="true">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Tampilkan kata sandi" aria-pressed="false">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Ingat saya</label>
                                </div>
                                <div>
                                    <a href="#" class="small muted-link">Lupa kata sandi?</a>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-right-to-bracket me-2"></i>Masuk
                                </button>
                            </div>

                            <div class="divider" role="presentation"></div>

                            <div class="text-center">
                                <small class="text-muted">Belum punya akun? <a href="{{ route ('signup') }}">Daftar</a> • <a href="{{ route('home') }}">Kembali</a></small>
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
        // Toggle show/hide password
        (function(){
            const toggle = document.getElementById('togglePassword');
            const pwd = document.getElementById('password');
            if(toggle && pwd){
                toggle.addEventListener('click', function(){
                    const type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
                    pwd.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    if(icon){
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    }
                    this.setAttribute('aria-pressed', type === 'text');
                });
            }
        })();
    </script>
</body>

</html>