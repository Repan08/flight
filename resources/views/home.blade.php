@extends('templates.app')

@section('content')
    <div class="hero-section container">
        <div class="all-flight container text-center text-white py-5">
            <h2 class="fw-bold mb-3">Perjalanan Anda Dimulai Dari Sini</h2>
            <p>
                <i class="fas fa-shield-alt"></i> Transaksi Aman |
                <i class="fas fa-headset ms-2"></i> Bantuan global 30 detik
            </p>

            <!-- Form Card -->
            <div class="flight-card bg-white p-4 shadow-3 rounded-6 mx-auto mt-">
                <form>
                    <!-- Tipe perjalanan -->
                    <div class="col-12 mb-3 text-start trip-type">
                        <input type="radio" name="trip" id="pp" checked />
                        <label for="pp">Pulang-Pergi</label>
                        <input type="radio" name="trip" id="sj" />
                        <label for="sj">Sekali Jalan</label>
                        <input type="radio" name="trip" id="mk" />
                        <label for="mk">Multi-Kota</label>
                        <input type="checkbox" id="lg" />
                        <label for="lg">Langsung</label>
                    </div>

                    <div class="row g-3 align-items-end">
                        <!-- Dari -->
                        <div class="col-md-2">
                            <label class="form-label text-muted">Berangkat dari</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Lokasi" />
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
                                <input type="text" class="form-control" placeholder="Lokasi" />
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="col-md-2">
                            <label class="form-label text-muted">Berangkat</label>
                            <input type="date" class="form-control" value="2025-11-08" />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted">Pulang</label>
                            <input type="date" class="form-control" value="2025-11-10" />
                        </div>

                        <!-- Penumpang -->
                        <div class="col-md-3">
                            <label class="form-label text-muted">Penumpang</label>
                            <select class="form-select">
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
@endsection