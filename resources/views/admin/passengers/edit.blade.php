@extends('templates.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-4">
            <h5 class="m-0">✍️ Edit Detail Penumpang: **{{ $passenger->name }}**</h5>
            <a href="{{ route('admin.passenger.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4 p-4">
            <form action="{{ route('admin.passenger.update', $passenger->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $passenger->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_card_number" class="form-label">Nomor KTP/Paspor</label>
                        <input type="text" class="form-control @error('id_card_number') is-invalid @enderror" id="id_card_number" name="id_card_number" value="{{ old('id_card_number', $passenger->id_card_number) }}">
                        @error('id_card_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="birth_date" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $passenger->birth_date) }}" required>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="type" class="form-label">Jenis Penumpang</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="adult" {{ old('type', $passenger->type) == 'adult' ? 'selected' : '' }}>Dewasa (Adult)</option>
                            <option value="child" {{ old('type', $passenger->type) == 'child' ? 'selected' : '' }}>Anak (Child)</option>
                            <option value="infant" {{ old('type', $passenger->type) == 'infant' ? 'selected' : '' }}>Bayi (Infant)</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="ticket_id" class="form-label">Nomor Tiket (Seat)</label>
                        {{-- Implementasi sederhana: Anda mungkin perlu membuat dropdown tiket yang tersedia di flight yang bersangkutan --}}
                        <input type="text" class="form-control" id="ticket_id" value="{{ $passenger->ticket->seat_number ?? 'Belum Dialokasikan' }}" readonly disabled>
                        <small class="form-text text-muted">Perubahan alokasi tempat duduk/tiket dilakukan di halaman Booking/Tiket.</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Data Penumpang</button>
            </form>
        </div>
    </div>
@endsection