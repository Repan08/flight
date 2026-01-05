@extends('templates.app')

@section('content')
    <div class="container">
        <h1 class="mt-3">Halaman Manajemen Penerbangan (Admin)</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.flight.create') }}" class="btn btn-primary mb-3">Tambah Data Penerbangan</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Penerbangan</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Waktu Keberangkatan</th>
                    <th>Waktu Kedatangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection