@extends('templates.app')

@section('content')
    <style>
        /* --- STICKY FOOTER SETUP CSS --- */
        html,
        body {
            height: 100%;
        }

        body {
            /* Pastikan body adalah flex container */
            display: flex;
            flex-direction: column;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8fafc;
            /* Asumsi warna latar belakang */
        }

        footer {
            /* Mendorong footer ke bawah dan mencegahnya menyusut */
            margin-top: auto;
            flex-shrink: 0;

            /* --- ENHANCED FOOTER STYLING --- */
            background-color: #ffffff;
            /* Latar belakang putih bersih */
            border-top: 1px solid #e2e8f0;
            padding: 2.5rem 0;
            /* Padding yang lebih baik */
        }

        .footer-link {
            display: block;
            color: #64748b;
            text-decoration: none;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: #3b82f6;
            /* Hover effect biru */
        }

        .footer-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .social-icon {
            font-size: 1.5rem;
            color: #64748b;
            margin-right: 1rem;
            transition: color 0.2s;
        }

        .social-icon:hover {
            color: #3b82f6;
        }

        .trip-type label {
            padding: 6px 15px;
            background: #f1f5f9;
            border-radius: 50px;
            font-size: 0.9rem;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .trip-type input[type="radio"],
        .trip-type input[type="checkbox"] {
            display: none;
        }

        .trip-type input:checked+label {
            background: #3b82f6;
            color: white;
        }

        .swap-icon i {
            color: #64748b;
            font-size: 1.1rem;
            display: block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border: 1px solid #e2e8f0;
            border-radius: 50%;
            margin: 0 auto;
            cursor: pointer;
            transition: all 0.3s;
        }

        .search-btn {
            background: #1d4ed8 !important;
            /* solid blue */
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 2rem;
            font-size: 1.05rem;
        }
    </style>

    <div class="hero-section container mb-10">
        <div class="all-flight container text-center text-white py-5">
            <h2 class="fw-bold mb-3">Perjalanan Anda Dimulai Dari Sini</h2>
            <p>
                <i class="fas fa-shield-alt"></i> Transaksi Aman |
                <i class="fas fa-headset ms-2"></i> Bantuan global 30 detik
            </p>

            <!-- Form Card -->
            <div class="flight-card bg-white p-4 shadow-3 rounded-6 mx-auto mt-">
                <form action="{{ route('flights.search') }}" method="POST">
                    @csrf  <!-- Tambahan: CSRF token untuk keamanan Laravel -->
                    <!-- Tipe perjalanan -->
                    <div class="col-12 mb-3 text-start trip-type">
                        <input type="radio" name="trip" id="pp" value="pp" checked />
                        <label for="pp">Pulang-Pergi</label>
                        <input type="radio" name="trip" id="sj" value="sj" />
                        <label for="sj">Sekali Jalan</label>
                        <input type="radio" name="trip" id="mk" value="mk" />
                        <label for="mk">Multi-Kota</label>
                        <input type="checkbox" id="lg" name="direct" value="1" />
                        <label for="lg">Langsung</label>
                    </div>

                    <div class="row g-3 align-items-end">
                        <!-- Dari -->
                        <div class="col-md-2">
                            <label class="form-label text-muted">Berangkat dari</label>
                            <div class="input-group">
                                <input type="text" name="departure" class="form-control" placeholder="Lokasi" required />  <!-- Tambahan: name dan required -->
                            </div>
                        </div>

                        <!-- Tukar ikon -->
                        <div class="col-md-1 text-center align-self-center swap-icon mt-5">
                            <i class="fas fa-exchange-alt"></i>
                        </div>

                        <!-- Ke -->
                        <div class="col-md-2">
                            <label class="form-label text-muted">Pergi ke</label>
                            <div class="input-group">
                                <input type="text" name="arrival" class="form-control" placeholder="Lokasi" required />  <!-- Tambahan: name dan required -->
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="col-md-2">
                            <label class="form-label text-muted">Berangkat</label>
                            <input type="date" name="departure_date" class="form-control" value="2025-11-08" required />  <!-- Tambahan: name dan required -->
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted">Pulang</label>
                            <input type="date" name="return_date" class="form-control" value="2025-11-10" />  <!-- Tambahan: name -->
                        </div>

                        <!-- Penumpang -->
                        <div class="col-md-3">
                            <label class="form-label text-muted">Penumpang</label>
                            <select name="passengers" class="form-select" required>  <!-- Tambahan: name dan required -->
                                <option>1 Dewasa - Ekonomi</option>
                                <option>2 Dewasa - Ekonomi</option>
                                <option>1 Dewasa - Bisnis</option>
                            </select>
                        </div>

                    </div>
                    <!-- Tombol -->
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary search-btn">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="footer-title" style="color: #1d4ed8;">✈️ Flynetic</div>
                    <p class="small text-muted">Solusi terbaik untuk pemesanan tiket pesawat yang cepat, aman, dan mudah.
                        Terbang dengan nyaman bersama kami.</p>
                    <div class="mt-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="col-6 col-md-2">
                    <div class="footer-title">Layanan Kami</div>
                    <a href="#" class="footer-link">Penerbangan untuk anda</a>
                </div>

                <div class="col-6 col-md-2">
                    <div class="footer-title">Bantuan</div>
                    <a href="#" class="footer-link">Hubungi Kami</a>
                    <a href="#" class="footer-link">Kebijakan Privasi</a>
                    <a href="#" class="footer-link">Syarat & Ketentuan</a>
                </div>

                <div class="col-md-3">
                    <div class="footer-title">Kantor Pusat</div>
                    <p class="small text-muted mb-1">Jl. Tenjoayu No. 21, Sukabumi  </p>
                    <p class="small text-muted mb-1"><i class="fas fa-phone-alt me-2"></i>+62 812 xxxx xxxx</p>
                    <p class="small text-muted"><i class="fas fa-envelope me-2"></i>flynetic@flynetic.com</p>
                </div>
            </div>

            <hr class="my-4">

            <div class="text-center text-muted small">
                © 2025 Flynetic. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>
@endsection