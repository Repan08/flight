    @extends('templates.app')

@section('content')
    <div class="container w-75 d-block mx-auto my-5">
        <h2>Tambah Maskapai Baru</h2>
        <form action="{{ route('admin.airlines.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Maskapai</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name', $airline->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Kode Maskapai (e.g., GA, QZ)</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code"
                    value="{{ old('code', $airline->code ?? '') }}" required maxlength="10">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo Maskapai</label>
                <input type="file" id="logo" name="logo" class="form-control @error('logo') is-invalid @enderror">
                <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <button type="submit" class="btn btn-success mt-2">{{ isset($airline) ? 'Update' : 'Simpan' }} Maskapai</button>
            <a href="{{ route('admin.airlines.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection