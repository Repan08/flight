@extends('templates.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h4 class="fw-bold text-center mb-2">Metode Pembayaran</h4>
                <p class="text-muted text-center mb-4">
                    Penerbangan ID: <span class="fw-semibold">{{ $id }}</span>
                </p>

                <form id="paymentForm" action="{{ route('flight.confirm', ['id' => $id]) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pilih Metode Pembayaran</label>
                        <select name="payment_method" class="form-select form-select-lg" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="transfer">🏦 Transfer Bank</option>
                            <option value="credit_card">💳 Kartu Kredit</option>
                            <option value="ewallet">📱 E-Wallet (GoPay, OVO, dll)</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            Lanjutkan Pembayaran
                        </button>
                        <a href="{{ route('flight.result') }}" class="btn btn-outline-secondary">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    if (!isLoggedIn) {
        e.preventDefault();
        window.location.href = "{{ route('login') }}";
    }
});
</script>
@endsection