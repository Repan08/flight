@extends('templates.app') 

@section('content')
<div class="container">
    <h2 class="mt-3">Manajemen Maskapai Penerbangan</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.airlines.create') }}" class="btn btn-primary">Tambah Maskapai Baru</a>
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
                <td><img src="{{ $airline->logo }}" alt="{{ $airline->name }}" style="width: 50px; height: auto;"></td>
                <td>{{ $airline->name }}</td>
                <td>{{ $airline->code }}</td>
                <td>
                    {{ $airline->deleted_at ? '🗑️ Dihapus' : '✅ Aktif' }}
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
                        <form action="{{ route('admin.airlines.destroy', $airline->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini? Data akan dipindahkan ke keranjang sampah.');">
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