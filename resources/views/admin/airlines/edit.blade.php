@extends('templates.app')

@section('content')
    <div class="container w-75 d-block mx-auto my-5">
        <h2>Edit Maskapai: {{ $airline->name }}</h2>

        <form action="{{ route('admin.airlines.update', $airline->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama Maskapai</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name', $airline->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Kode Maskapai (e.g., GA, QZ)</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code"
                    value="{{ old('code', $airline->code) }}" required maxlength="10">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo Maskapai</label>
                <input type="file" id="logo" name="logo" class="form-control @error('logo') is-invalid @enderror">
                <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB. (Biarkan kosong jika tidak ingin
                    mengubah)</small>
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                {{-- Tampilan logo saat ini (opsional) --}}
                @if ($airline->logo)
                    <div class="mt-2">
                        @if ($airline->logo)
                            <div class="mt-2">
                                Logo Saat Ini: <img src="{{ asset('storage/logos/' . $airline->logo) }}" alt="Logo Saat Ini"
                                    style="max-width: 100px; height: auto;">
                            </div>
                        @endif
                    </div>
                @endif

            </div>

            <button type="submit" class="btn btn-success mt-2">Update Maskapai</button>
            <a href="{{ route('admin.airlines.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection