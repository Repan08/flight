@extends('templates.app')

@section('content')
<div class="container-fluid py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold text-primary mb-0">✈️ Dashboard Penerbangan</h1>
        <div>
            <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#createAircraftModal">
                <i class="fas fa-plane me-1"></i>Pesawat
            </button>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createFlightModal">
                <i class="fas fa-calendar-plus me-1"></i>Jadwal
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
        <div class="col">
            <div class="card border-start border-primary border-3 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted small mb-1">Pesawat</h6>
                        <h4 class="mb-0">0</h4>
                    </div>
                    <i class="fas fa-plane text-primary mt-1"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-start border-success border-3 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted small mb-1">Jadwal</h6>
                        <h4 class="mb-0">0</h4>
                    </div>
                    <i class="fas fa-calendar-alt text-success mt-1"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-start border-info border-3 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted small mb-1">Kapasitas</h6>
                        <h4 class="mb-0">0%</h4>
                    </div>
                    <i class="fas fa-users text-info mt-1"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-start border-warning border-3 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted small mb-1">Aktif</h6>
                        <h4 class="mb-0">0</h4>
                    </div>
                    <i class="fas fa-check-circle text-warning mt-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesawat Table -->
    <div class="card mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold"><i class="fas fa-plane me-2"></i>Daftar Pesawat</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan muncul di sini -->
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-plane-slash me-2"></i>Belum ada data pesawat
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Jadwal Table -->
    <div class="card">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold"><i class="fas fa-calendar-alt me-2"></i>Jadwal Penerbangan</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Rute</th>
                        <th>Waktu</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan muncul di sini -->
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times me-2"></i>Belum ada jadwal penerbangan
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Pesawat -->
<div class="modal fade" id="createAircraftModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title mb-0"><i class="fas fa-plane me-2"></i>Tambah Pesawat</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            {{-- <form action="{{ route('aircrafts.store') }}" method="POST"> --}}
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small">Kode Pesawat</label>
                            <input type="text" name="code" class="form-control form-control-sm" placeholder="AC-001" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Nama Pesawat</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Boeing 737" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Tipe</label>
                            <select name="type" class="form-select form-select-sm" required>
                                <option value="Narrow-body">Narrow-body</option>
                                <option value="Wide-body">Wide-body</option>
                                <option value="Regional Jet">Regional Jet</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Kapasitas</label>
                            <input type="number" name="capacity" class="form-control form-control-sm" placeholder="180" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Jadwal -->
<div class="modal fade" id="createFlightModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h6 class="modal-title mb-0"><i class="fas fa-calendar-plus me-2"></i>Tambah Jadwal</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            {{-- <form action="{{ route('flights.store') }}" method="POST"> --}}
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small">Kode Penerbangan</label>
                            <input type="text" name="code" class="form-control form-control-sm" placeholder="GA-201" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Pesawat</label>
                            <select name="aircraft_id" class="form-select form-select-sm" required>
                                <option value="">Pilih Pesawat</option>
                                <!-- Options akan diisi dari database -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Asal</label>
                            <input type="text" name="origin" class="form-control form-control-sm" placeholder="CGK" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Tujuan</label>
                            <input type="text" name="destination" class="form-control form-control-sm" placeholder="SUB" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Waktu Keberangkatan</label>
                            <input type="datetime-local" name="departure_time" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Harga</label>
                            <input type="number" name="price" class="form-control form-control-sm" placeholder="1500000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection