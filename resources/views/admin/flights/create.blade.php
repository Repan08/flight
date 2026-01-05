@extends('templates.app')

@section('content')
    <div class="container">
        <h1 class="mt-3">✈️ Halaman Tambah Penerbangan (Admin)</h1>

        <form action="{{ route('admin.flight.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="airplane_id" class="form-label">Pesawat</label>
                <input type="text" class="form-control" id="airplane_id" name="airplane_id" required>
            </div>

            <div class="mb-3">
                <label for="departure_city" class="form-label">Asal</label>
                <input type="text" class="form-control" id="departure_city" name="departure_city" required>
            </div>

            <div class="mb-3">
                <label for="arrival_city" class="form-label">Tujuan</label>
                <input type="text" class="form-control" id="arrival_city" name="arrival_city" required>
            </div>

            <div class="mb-3">
                <label for="departure_time" class="form-label">Waktu Keberangkatan</label>
                <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" required>
            </div>

            <div class="mb-3">
                <label for="arrival_time" class="form-label">Waktu Kedatangan</label>
                <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Harga Tiket</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

    </div>
@endsection