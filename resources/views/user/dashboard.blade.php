@extends('templates.app')

@section('content')
    <!-- Hero Section dengan Search Form (seperti home) -->
    <div class="hero-section container mb-10">
        <div class="all-flight container text-center text-white py-5">
            <h2 class="fw-bold mb-3">Halo, {{ Auth::user()->name ?? 'Pengguna' }}! 👋</h2>
            <p>
                <i class="fas fa-shield-alt"></i> Kelola Pemesanan Anda |
                <i class="fas fa-headset ms-2"></i> Cari Penerbangan Baru
            </p>

            <!-- Form Card (Search) -->
            <div class="flight-card bg-white p-4 shadow-3 rounded-6 mx-auto mt-">
                <form action="{{ route('flights.search') }}" method="POST">
                    @csrf
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
                                <input type="text" name="departure" class="form-control" placeholder="Lokasi" required />
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
                                <input type="text" name="arrival" class="form-control" placeholder="Lokasi" required />
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="col-md-2">
                            <label class="form-label text-muted">Berangkat</label>
                            <input type="date" name="departure_date" class="form-control" value="2025-11-08" required />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted">Pulang</label>
                            <input type="date" name="return_date" class="form-control" value="2025-11-10" />
                        </div>

                        <!-- Penumpang -->
                        <div class="col-md-3">
                            <label class="form-label text-muted">Penumpang</label>
                            <select name="passengers" class="form-select" required>
                                <option>1 Dewasa - Ekonomi</option>
                                <option>2 Dewasa - Ekonomi</option>
                                <option>1 Dewasa - Bisnis</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary search-btn">
                            <i class="fas fa-search"></i> Cari Penerbangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection