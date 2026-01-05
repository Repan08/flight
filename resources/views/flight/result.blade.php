@extends('templates.app')

@section('content')
    <div class="container mt-4">
        @csrf
        <h1 class="mb-4">Tiket Keberangkatan</h1>

        @if(isset($searchParams))
            <div class="alert alert-info mb-4">
                <strong>Pencarian Anda:</strong> Dari {{ $searchParams['departure'] ?? 'N/A' }} ke
                {{ $searchParams['arrival'] ?? 'N/A' }} pada {{ $searchParams['departure_date'] ?? 'N/A' }}
                @if(isset($searchParams['return_date']) && $searchParams['return_date']) - Pulang:
                {{ $searchParams['return_date'] }} @endif
                ({{ $searchParams['passengers'] ?? 'N/A' }}, {{ $searchParams['trip'] ?? 'N/A' }})
            </div>
        @endif

        {{-- Ini akan filter data $flights secara client-side tanpa mengubah controller --}}
        <div class="filter-controls mb-4" style="display: none;" id="filterControls">
            <div class="row">
                <div class="col-md-4">
                    <label for="priceFilter">Filter Harga Maksimal:</label>
                    <input type="number" id="priceFilter" class="form-control" placeholder="Rp 3.000.000">
                </div>
                <div class="col-md-4">
                    <label for="timeFilter">Filter Waktu Keberangkatan (HH:MM):</label>
                    <input type="time" id="timeFilter" class="form-control">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary w-100" onclick="applyFilters()">Terapkan Filter</button>
                    <button class="btn btn-outline-secondary w-100 mt-2" onclick="resetFilters()">Reset</button>
                </div>
            </div>
        </div>
        <button class="btn btn-info mb-3" onclick="toggleFilters()">Tampilkan/Sembunyikan Filter Lanjutan</button>

        {{-- Tambah loading indicator untuk filter --}}
        <div id="loading" style="display: none;" class="text-center mb-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Memuat...</span>
            </div> Memproses filter...
        </div>

        <!-- Flight List -->
        <div class="flight-list" id="flightList">
            @if(isset($flights) && count($flights) > 0)
                @foreach($flights as $index => $flight)
                    <div class="flight-card mb-3 flight-item" data-price="{{ str_replace(['Rp', '.'], '', $flight['price']) }}"
                        data-time="{{ $flight['departure_time'] }}" style="{{ $index >= 10 ? 'display: none;' : '' }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="airline-info">
                                            <div class="airline-name">{{ $flight['airline'] }}</div>
                                            <div class="flight-type">
                                                {{-- Kode asli: <span
                                                    class="badge bg-{{ $flight['badge'] == 'Termurah' ? 'success' : 'info' }}">{{
                                                    $flight['badge'] }}</span> --}}
                                                {{-- Upgrade: Badge lebih dinamis, tambah warna untuk 'Rekomendasi' --}}
                                                <span
                                                    class="badge bg-{{ $flight['badge'] == 'Termurah' ? 'success' : ($flight['badge'] == 'Rekomendasi' ? 'primary' : 'info') }}">{{ $flight['badge'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="flight-time">
                                            <div class="departure-time">{{ $flight['departure_time'] }}</div>
                                            <div class="airport-code">{{ $flight['departure_airport'] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="flight-duration">
                                            <div class="duration">{{ $flight['duration'] }}</div>
                                            <div class="flight-path">
                                                <div class="path-line"></div>
                                                <div class="path-dot start"></div>
                                                <div class="path-dot end"></div>
                                            </div>
                                            <div class="flight-type-text">Langsung</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="flight-time">
                                            <div class="arrival-time">{{ $flight['arrival_time'] }}</div>
                                            <div class="airport-code">{{ $flight['arrival_airport'] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="flight-price">
                                            <div class="price">{{ $flight['price'] }}</div>
                                            <div class="trip-type">{{ $flight['trip_type'] }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        {{-- Upgrade: Tombol "Pilih" dengan fungsi redirect ke halaman booking --}}
                                        <form action="{{ route('flight.payment', ['id' => $index]) }}" method="GET"
                                            style="display: inline;">
                                            <button type="submit" class="btn btn-primary w-100">Pilih</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Tidak ada penerbangan ditemukan untuk kriteria pencarian Anda.</p>
            @endif
        </div>

        {{-- Upgrade: Tambah pagination sederhana --}}
        <nav aria-label="Flight Pagination" class="mt-4">
            <ul class="pagination justify-content-center" id="pagination">
                <li class="page-item"><a class="page-link" href="#" onclick="changePage(1)">1</a></li>
                <li class="page-item"><a class="page-link" href="#" onclick="changePage(2)">2</a></li>
                {{-- Tambah lebih jika perlu --}}
            </ul>
        </nav>

        <!-- Login Banner -->
        {{-- Kode asli tetap ada --}}
        <div class="login-banner mt-5">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h5 class="card-title">Login & hemat pemesanan Anda berikutnya</h5>
                    <p class="card-text">Dapatkan minimal <strong>24</strong> Trip Coins senilai <strong>Rp4.011</strong>
                        untuk pemesanan ini dan gunakan untuk menghemat pemesanan berikutnya!</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Upgrade: Tambah JavaScript untuk filter, pagination, dan toggle --}}
    <script>
        let currentPage = 1;
        const itemsPerPage = 10;

        function toggleFilters() {
            const controls = document.getElementById('filterControls');
            controls.style.display = controls.style.display === 'none' ? 'block' : 'none';
        }

        function applyFilters() {
            document.getElementById('loading').style.display = 'block';
            const priceFilter = parseInt(document.getElementById('priceFilter').value.replace(/\D/g, '')) || Infinity;
            const timeFilter = document.getElementById('timeFilter').value || '';
            const items = document.querySelectorAll('.flight-item');

            items.forEach(item => {
                const price = parseInt(item.dataset.price);
                const time = item.dataset.time;
                const show = price <= priceFilter && (!timeFilter || time >= timeFilter);
                item.style.display = show ? 'block' : 'none';
            });

            setTimeout(() => document.getElementById('loading').style.display = 'none', 500); // Simulasi loading
        }

        function resetFilters() {
            document.getElementById('priceFilter').value = '';
            document.getElementById('timeFilter').value = '';
            applyFilters();
        }

        function changePage(page) {
            currentPage = page;
            const items = document.querySelectorAll('.flight-item');
            items.forEach((item, index) => {
                item.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'block' : 'none';
            });
        }

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', () => changePage(1));
    </script>
@endsection