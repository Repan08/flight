@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- Success Card -->
            <div class="card border-0 shadow">
                <!-- Header with Success Icon -->
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x text-success"></i>
                    </div>
                    
                    <h2 class="fw-bold text-dark mb-2">Pembayaran Dikonfirmasi!</h2>
                    <p class="text-muted mb-4">Bukti pembayaran Anda telah berhasil diterima dan sedang diverifikasi.</p>

                    <!-- Booking Details -->
                    <div class="bg-light p-4 rounded-3 mb-4">
                        <div class="row mb-3">
                            <div class="col-6 text-start">
                                <span class="text-muted d-block">ID Pemesanan</span>
                                <strong class="fs-5">#BK{{ $booking->id }}</strong>
                            </div>
                            <div class="col-6 text-start">
                                <span class="text-muted d-block">Total Pembayaran</span>
                                <strong class="fs-5" style="color: var(--brand);">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 text-start">
                                <span class="text-muted d-block">Penerbangan</span>
                                <strong class="fs-6">{{ $booking->flight->origin ?? '-' }} → {{ $booking->flight->destination ?? '-' }}</strong>
                            </div>
                            <div class="col-6 text-start">
                                <span class="text-muted d-block">Status</span>
                                <span class="badge bg-warning">Diverifikasi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Proof Preview -->
                    @if(isset($proof_path))
                        <div class="mb-4">
                            <p class="text-muted mb-2">Bukti Pembayaran:</p>
                            <a href="{{ route('user.payment.proof', ['fileName' => $proof_path]) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-file-pdf"></i> Lihat Bukti
                            </a>
                        </div>
                    @endif

                    <!-- Verification Info -->
                    <div class="alert alert-info mb-4" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi Penting:</strong> Tim akan memverifikasi bukti pembayaran Anda dalam <strong>1-2 jam kerja</strong>. Anda akan menerima notifikasi melalui email setelah verifikasi selesai.
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="card border-0 shadow mt-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Langkah Selanjutnya</h5>
                    <ol class="mb-0">
                        <li class="mb-2">Tim kami akan memverifikasi bukti pembayaran Anda</li>
                        <li class="mb-2">Status pemesanan akan berubah menjadi "Terkonfirmasi"</li>
                        <li class="mb-2">Anda akan menerima email konfirmasi dengan detail tiket</li>
                        <li>Siap untuk penerbangan Anda!</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
