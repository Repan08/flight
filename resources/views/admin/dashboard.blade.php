@extends('templates.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 fw-bold text-primary">✈️ Dashboard Admin Penerbangan</h1>
        </div>
    </div>

    {{-- Pesawat Management --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-plane me-2"></i>Kelola Pesawat</h5>
                        {{-- <span class="badge bg-light text-primary">{{ $aircrafts->count() ?? 0 }} Pesawat</span> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Pesawat</th>
                                    <th>Nama Pesawat</th>
                                    <th>Tipe</th>
                                    <th>Kapasitas</th>
                                    <th>Maskapai</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aircrafts ?? [] as $aircraft)
                                <tr>
                                    <td><strong>{{ $aircraft->code ?? 'AC-001' }}</strong></td>
                                    <td>{{ $aircraft->name ?? 'Boeing 737' }}</td>
                                    <td><span class="badge bg-info">{{ $aircraft->type ?? 'Narrow-body' }}</span></td>
                                    <td>{{ $aircraft->capacity ?? 180 }} penumpang</td>
                                    <td>{{ $aircraft->airline ?? 'Garuda Indonesia' }}</td>
                                    <td>
                                        <span class="badge {{ ($aircraft->status ?? 'active') == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $aircraft->status ?? 'Active' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createAircraftModal">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                {{-- Placeholder jika tidak ada data --}}
                                @if(empty($aircrafts) || count($aircrafts) == 0)
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-plane-slash fa-2x mb-3"></i>
                                        <p class="mb-0">Belum ada data pesawat</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAircraftModal">
                                <i class="fas fa-plus me-2"></i>Tambah Pesawat Baru
                            </button>
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Jadwal Penerbangan --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-success text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-alt me-2"></i>Jadwal Penerbangan</h5>
                        {{-- <span class="badge bg-light text-success">{{ $flights->count() ?? 0 }} Jadwal</span> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Penerbangan</th>
                                    <th>Rute</th>
                                    <th>Pesawat</th>
                                    <th>Waktu</th>
                                    <th>Harga</th>
                                    <th>Kursi Tersedia</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($flights ?? [] as $flight)
                                <tr>
                                    <td><strong>{{ $flight->code ?? 'GA-201' }}</strong></td>
                                    <td>
                                        <div class="small">{{ $flight->origin ?? 'CGK' }} → {{ $flight->destination ?? 'SUB' }}</div>
                                        <div class="text-muted">{{ $flight->origin_name ?? 'Jakarta' }} → {{ $flight->destination_name ?? 'Surabaya' }}</div>
                                    </td>
                                    <td>{{ $flight->aircraft ?? 'Boeing 737' }}</td>
                                    <td>
                                        <div class="small">{{ $flight->departure_time ?? '08:00' }}</div>
                                        <div class="text-muted">{{ $flight->arrival_time ?? '10:00' }}</div>
                                    </td>
                                    <td>Rp {{ number_format($flight->price ?? 1500000, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-info" style="width: {{ ($flight->available_seats ?? 120) / ($flight->total_seats ?? 180) * 100 }}%"></div>
                                        </div>
                                        <small>{{ $flight->available_seats ?? 120 }} / {{ $flight->total_seats ?? 180 }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ ($flight->status ?? 'scheduled') == 'scheduled' ? 'bg-primary' : 'bg-warning' }}">
                                            {{ $flight->status ?? 'Scheduled' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createFlightModal">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if(empty($flights) || count($flights) == 0)
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-calendar-times fa-2x mb-3"></i>
                                        <p class="mb-0">Belum ada jadwal penerbangan</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createFlightModal">
                                <i class="fas fa-plus me-2"></i>Tambah Jadwal Baru
                            </button>
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Create Aircraft --}}
<div class="modal fade" id="createAircraftModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plane me-2"></i>Tambah Pesawat Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Pesawat</label>
                        <input type="text" class="form-control" placeholder="AC-001" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pesawat</label>
                        <input type="text" class="form-control" placeholder="Boeing 737-800" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe</label>
                            <select class="form-select">
                                <option>Narrow-body</option>
                                <option>Wide-body</option>
                                <option>Regional Jet</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" placeholder="180" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal: Create Flight --}}
<div class="modal fade" id="createFlightModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-calendar-plus me-2"></i>Tambah Jadwal Penerbangan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Penerbangan</label>
                            <input type="text" class="form-control" placeholder="GA-201" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pesawat</label>
                            <select class="form-select">
                                <option>Boeing 737-800</option>
                                <option>Airbus A320</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bandara Asal</label>
                            <input type="text" class="form-control" placeholder="CGK - Jakarta" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bandara Tujuan</label>
                            <input type="text" class="form-control" placeholder="SUB - Surabaya" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Waktu Keberangkatan</label>
                            <input type="datetime-local" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Waktu Kedatangan</label>
                            <input type="datetime-local" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" class="form-control" placeholder="1500000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option value="scheduled">Scheduled</option>
                                <option value="delayed">Delayed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border: none;
}
.table th {
    border-bottom: 2px solid #dee2e6;
}
.progress {
    width: 100px;
    display: inline-block;
    margin-right: 10px;
}
.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endpush