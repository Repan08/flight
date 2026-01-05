@extends('templates.app') 

@section('content')
<div class="container">
    <h2 class="mt-3">Manajemen Maskapai Penerbangan</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        <div class="d-flex justify-content-end">
            {{-- <a href="{{ route('admin.airlines.export') }}" class="btn btn-secondary me-2">Export (.xlsx)</a> --}}
            <a href="{{ route('admin.airlines.trash') }}" class="btn btn-secondary me-2 mb-3">Data Sampah</a>
            <a href="{{ route('admin.airlines.create') }}" class="btn btn-primary mb-3">Tambah Data Maskapai</a>
        </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Nama Maskapai</th>
                <th>Kode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($airlines as $airline)
            <tr>
                <td>{{ $airline->id }}</td>
                <td>
                    <img src="{{ asset('storage/' . $airline->logo) }}" alt="{{ $airline->name }}" style="width: 50px; height: auto;">
                </td>
                <td>{{ $airline->name }}</td>
                <td>{{ $airline->code }}</td>
                <td>
                    {{ $airline->deleted_at ? '🚫 Non-Aktif' : '✅ Aktif' }}
                </td>
                <td>
                    @if ($airline->deleted_at)
                        {{-- SoftDeletes Restore --}}
                        <form action="{{ route('admin.airlines.restore', $airline->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Restore</button>
                        </form>
                        {{-- SoftDeletes Force Delete --}}
                        <form action="{{ route('admin.airlines.forceDelete', $airline->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus permanen data ini? TIDAK BISA DIKEMBALIKAN!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus Permanen</button>
                        </form>
                    @else
                        {{-- CRUD Edit --}}
                        <a href="{{ route('admin.airlines.edit', $airline->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        {{-- CRUD Delete (Soft Delete) --}}
                        <form action="{{ route('admin.airlines.delete', $airline->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection