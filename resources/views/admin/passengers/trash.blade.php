@extends('templates.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-4">
            <h5 class="m-0">🗑️ Data Penumpang Terhapus (Trash)</h5>
            <a href="{{ route('admin.passenger.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        @if (Session::get('success'))
            <div class="alert alert-success shadow-sm rounded-3">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Penumpang</th>
                            <th>Jenis</th>
                            <th>Booking ID</th>
                            <th>Dihapus Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Looping Data Penumpang Terhapus --}}
                        @forelse ($passengers as $passenger)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $passenger->name }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($passenger->type) }}</span></td>
                                <td>{{ $passenger->booking_id }}</td>
                                <td>{{ $passenger->deleted_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    {{-- Tombol Restore --}}
                                    <form action="{{ route('admin.passenger.restore', $passenger->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm me-1" title="Pulihkan">
                                            <i class="bi bi-arrow-repeat"></i> Pulihkan
                                        </button>
                                    </form>

                                    {{-- Tombol Hapus Permanen --}}
                                    <form action="{{ route('admin.passenger.delete-permanen', $passenger->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Permanen" onclick="return confirm('PERINGATAN! Tindakan ini akan menghapus data secara permanen. Lanjutkan?')">
                                            <i class="bi bi-x-octagon"></i> Permanen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data penumpang yang terhapus.</td>
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