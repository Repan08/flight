@extends('templates.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Riwayat Pemesanan Anda ✈️</h2>
        <p class="text-muted">Lihat semua status penerbangan dan pemesanan tiket Anda di sini.</p>

        @if (Session::get('success'))
            <div class="alert alert-success shadow-sm rounded-3">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4 p-4 mt-4">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID Booking</th>
                            <th>Rute</th>
                            <th>Tanggal Berangkat</th>
                            <th>Total Penumpang</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Looping Data Bookings --}}
                        @forelse ($bookings as $booking)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $booking->booking_code ?? $booking->id }}</span></td>
                                <td>
                                    {{ $booking->flight->origin }} <i class="fas fa-arrow-right mx-1"></i> {{ $booking->flight->destination }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('d M Y') }}</td>
                                <td>{{ $booking->passengers->count() }} Orang</td>
                                <td>**Rp {{ number_format($booking->total_price, 0, ',', '.') }}**</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'pending' => 'warning', 
                                            'paid' => 'success', 
                                            'failed' => 'danger',
                                            'cancelled' => 'secondary'
                                        ][$booking->status] ?? 'info';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('user.flights.details', $booking->id) }}" class="btn btn-sm btn-info text-white me-1" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if ($booking->status == 'pending')
                                        <a href="{{ route('user.payment.show', $booking->id) }}" class="btn btn-sm btn-primary" title="Lanjutkan Pembayaran">
                                            Bayar <i class="fas fa-money-bill-wave"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-4">Anda belum memiliki riwayat pemesanan tiket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection