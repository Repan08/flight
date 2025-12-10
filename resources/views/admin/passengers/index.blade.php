@extends('templates.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-4">
            <h5 class="m-0">🧑‍🤝‍🧑 Kelola Data Penumpang</h5>
            <div>
                {{-- Admin biasanya tidak menambahkan penumpang langsung, tapi melalui booking, namun tombol trash tetap berguna --}}
                <a href="{{ route('admin.passenger.trash') }}" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash"></i> Data Terhapus
                </a>
            </div>
        </div>

        @if (Session::get('success'))
            <div class="alert alert-success shadow-sm rounded-3">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4 p-4">
            <div class="mb-3">
                <h6>Filter dan Pencarian (Jika diperlukan)</h6>
                {{-- Di sini tempat untuk form pencarian nama, nomor KTP, atau filter berdasarkan jenis/booking_id --}}
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Penumpang</th>
                            <th>No. KTP/Paspor</th>
                            <th>Tgl. Lahir</th>
                            <th>Jenis</th>
                            <th>Booking ID</th>
                            <th>No. Tiket/Seat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Looping Data Penumpang --}}
                        @forelse ($passengers as $passenger)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $passenger->name }}</td>
                                <td>{{ $passenger->id_card_number ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($passenger->birth_date)->format('d-m-Y') }}</td>
                                <td><span class="badge bg-{{ $passenger->type == 'adult' ? 'primary' : ($passenger->type == 'child' ? 'warning' : 'secondary') }}">{{ ucfirst($passenger->type) }}</span></td>
                                <td><a href="{{ route('admin.booking.show', $passenger->booking_id) }}">{{ $passenger->booking_id }}</a></td>
                                <td>{{ $passenger->ticket->seat_number ?? 'Belum Dialokasikan' }}</td>
                                <td>
                                    <a href="{{ route('admin.passenger.edit', $passenger->id) }}" class="btn btn-warning btn-sm me-1" title="Edit Detail">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.passenger.destroy', $passenger->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus (Soft Delete)" onclick="return confirm('Yakin ingin menghapus (soft delete) data penumpang ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data penumpang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $passengers->links() }}
            </div>
        </div>
    </div>
@endsection