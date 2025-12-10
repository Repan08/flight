@extends('templates.app')

@section('content')
<div class="min-vh-100 py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                {{-- E-Ticket Card --}}
                <div class="card border-0 shadow-lg overflow-hidden">
                    {{-- Header --}}
                    <div class="card-header py-4 bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <div class="bg-white rounded p-3 me-3">
                                <i class="fas fa-plane fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h2 class="mb-1 fw-bold">Sriwijaya Air</h2>
                                <p class="mb-0 opacity-75">E-tiket • Penerbangan Pergi</p>
                            </div>
                        </div>
                    </div>

                    {{-- Flight 1 --}}
                    <div class="card-body p-4 p-md-5">
                        <div class="border-2 border-dashed border-light-subtle rounded-3 p-4 mb-5">
                            <div class="d-flex flex-column flex-md-row justify-content-between mb-4">
                                <div class="mb-3 mb-md-0">
                                    <h4 class="fw-bold text-primary mb-2">Sriwijaya Air SJ-232</h4>
                                    <span class="badge bg-primary px-3 py-2">Subclass S (Economy)</span>
                                </div>
                                <div class="text-muted d-flex align-items-center">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    <span>Jumat, 7 Agustus 2015</span>
                                </div>
                            </div>

                            <div class="row align-items-center g-4">
                                <div class="col-md-4">
                                    <div class="position-relative ps-4">
                                        <div class="position-absolute start-0 top-50 translate-middle-y bg-success rounded-circle border-3 border-white" style="width: 16px; height: 16px;"></div>
                                        <div class="time-display">15:00</div>
                                        <div class="fw-bold fs-5">Surabaya (SUB)</div>
                                        <div class="text-muted">Juanda - Terminal 1</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="badge bg-info bg-opacity-10 text-info px-3 py-2 mb-3">
                                            <i class="fas fa-clock me-1"></i>2j 25m
                                        </div>
                                        <div class="position-relative">
                                            <hr class="my-0">
                                            <div class="position-absolute top-50 start-50 translate-middle bg-white border border-primary rounded-circle p-2">
                                                <i class="fas fa-plane text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="position-relative pe-4 text-end">
                                        <div class="position-absolute end-0 top-50 translate-middle-y bg-warning rounded-circle border-3 border-white" style="width: 16px; height: 16px;"></div>
                                        <div class="time-display">17:25</div>
                                        <div class="fw-bold fs-5">Balikpapan (BPN)</div>
                                        <div class="text-muted">Sepinggan</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Transit --}}
                        <div class="bg-warning bg-opacity-10 border-start border-4 border-warning rounded p-3 mb-5">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-25 rounded-circle p-3 me-3">
                                    <i class="fas fa-exchange-alt fa-lg text-warning"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-warning mb-1">Transit di Balikpapan</h5>
                                    <p class="mb-0"><strong>55 menit</strong> • 17:25 - 18:20</p>
                                </div>
                            </div>
                        </div>

                        {{-- Flight 2 --}}
                        <div class="border rounded-3 p-4 mb-5 bg-light">
                            <div class="mb-4">
                                <h4 class="fw-bold text-primary mb-2">Sriwijaya Air SJ-230</h4>
                                <span class="badge bg-secondary px-3 py-2">Subclass X (Economy)</span>
                            </div>

                            <div class="row align-items-center g-4">
                                <div class="col-md-4">
                                    <div class="position-relative ps-4">
                                        <div class="position-absolute start-0 top-50 translate-middle-y bg-warning rounded-circle border-3 border-white" style="width: 16px; height: 16px;"></div>
                                        <div class="time-display">18:20</div>
                                        <div class="fw-bold fs-5">Balikpapan (BPN)</div>
                                        <div class="text-muted">Sepinggan</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="badge bg-info bg-opacity-10 text-info px-3 py-2 mb-3">
                                            <i class="fas fa-clock me-1"></i>1j 00m
                                        </div>
                                        <div class="position-relative">
                                            <hr class="my-0">
                                            <div class="position-absolute top-50 start-50 translate-middle bg-white border border-primary rounded-circle p-2">
                                                <i class="fas fa-plane text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="position-relative pe-4 text-end">
                                        <div class="position-absolute end-0 top-50 translate-middle-y bg-danger rounded-circle border-3 border-white" style="width: 16px; height: 16px;"></div>
                                        <div class="time-display">19:20</div>
                                        <div class="fw-bold fs-5">Tarakan (TRK)</div>
                                        <div class="text-muted">Juwata</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Important Info --}}
                        <div class="bg-info bg-opacity-10 border-start border-4 border-info rounded p-4 mb-4">
                            <h5 class="fw-bold text-info mb-4">
                                <i class="fas fa-info-circle me-2"></i>Informasi Penting
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <i class="fas fa-id-card text-info mt-1 me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Identitas Penumpang</h6>
                                            <p class="small mb-0">Tunjukkan e-tiket dan identitas para penumpang saat check-in</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <i class="fas fa-hourglass-end text-warning mt-1 me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Waktu Check-in</h6>
                                            <p class="small mb-0">Check-in paling lambat 90 menit sebelum keberangkatan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <i class="fas fa-clock text-success mt-1 me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Perhatian</h6>
                                            <p class="small mb-0">Waktu tertera adalah waktu bandara setempat</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="card-footer py-4 bg-body-tertiary">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="mb-3 mb-md-0 text-center text-md-start">
                                <div class="text-primary fw-bold mb-1 fs-5">traveloka®</div>
                                <div class="fw-bold mb-1">Kode Booking (PNR)</div>
                                <div class="border-2 border-dashed border-danger rounded p-2 d-inline-block">
                                    <code class="fs-4 fw-bold text-danger">WAKXCJ</code>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-print me-2"></i>Cetak
                                </button>
                                <button class="btn btn-success">
                                    <i class="fas fa-download me-2"></i>Unduh PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.time-display {
    font-size: 1.5rem;
    font-weight: bold;
    color: #1a237e;
    margin-bottom: 0.25rem;
}

.border-dashed {
    border-style: dashed !important;
}

@media (max-width: 768px) {
    .position-relative.ps-4,
    .position-relative.pe-4 {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    
    .position-absolute.start-0,
    .position-absolute.end-0 {
        display: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.btn-outline-primary').addEventListener('click', () => window.print());
    document.querySelector('.btn-success').addEventListener('click', () => alert('Mengunduh PDF e-tiket...'));
});
</script>
@endpush