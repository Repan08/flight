@extends('templates.app')

@section('content')
<div class="container mt-4">
    <h1>Metode Pembayaran</h1>
    <p>Pilih metode pembayaran untuk penerbangan ID: {{ $id }}</p>

    <form id="paymentForm" action="{{ route('flights.confirm', ['id' => $id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="payment_method" class="form-label">Pilih Metode Pembayaran:</label>
            <select name="payment_method" id="payment_method" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="transfer">Transfer Bank</option>
                <option value="credit_card">Kartu Kredit</option>
                <option value="ewallet">E-Wallet (GoPay, OVO, dll.)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Lanjutkan Pembayaran</button>
        <a href="{{ route('flights.results') }}" class="btn btn-secondary">Kembali</a>
    </form>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            // Check apakah user sudah login (cek dari session/cookie)
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            
            if (!isLoggedIn) {
                e.preventDefault();
                // Redirect ke halaman login
                window.location.href = "{{ route('login') }}";
            }
        });
    </script>
</div>
@endsection