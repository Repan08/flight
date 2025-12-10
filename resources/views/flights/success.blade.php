@extends('templates.app')

@section('content')
<div class="container mt-4">
    <h1>Pembayaran Berhasil!</h1>
    <p>Terima kasih atas pembayaran Anda untuk penerbangan ID: {{ $id }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($payment)
        <p><strong>Metode Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
        @if($payment->proof_of_payment)
            <p><strong>Bukti Pembayaran:</strong> <a href="{{ Storage::url($payment->proof_of_payment) }}" target="_blank">Lihat File</a></p>
        @endif
    @endif

    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection