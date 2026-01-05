@extends('templates.app')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.airlines.index')}}" class="btn btn-secondary">Kembali</a>
        </div>

        <h3 class="my-3">Data Sampah Maskapai</h3>
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        
        @if ($airlineTrash->isEmpty())
            <div class="alert alert-info">Tidak ada data maskapai di tempat sampah saat ini.</div>
        @endif
        
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Nama Maskapai</th>
                <th>Kode</th>
                <th>Dihapus Pada</th>
                <th>Aksi</th>
            </tr>
            @foreach ($airlineTrash as $key => $airline)
                <tr>
                    <td>{{ $airline->id }}</td>
                    <td>
                        {{-- Pastikan path logo sudah benar. Jika di controller store Anda simpan 'logos/namafile.ext', ini sudah benar. --}}
                        <img src="{{ asset('storage/' . $airline->logo) }}" alt="{{ $airline->name }}" style="width: 50px; height: auto;">
                    </td>
                    <td>{{ $airline->name }}</td>
                    <td>{{ $airline->code }}</td>
                    <td>{{ $airline->deleted_at->format('d M Y H:i') }}</td>
                    <td class="d-flex">
                        
                        {{-- PERBAIKAN: HAPUS @method('PATCH') karena route didefinisikan sebagai POST --}}
                        <form action="{{ route('admin.airlines.restore', $airline->id ) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm me-2">Kembalikan</button>
                        </form>
                        
                        <form action="{{ route('admin.airlines.forceDelete', $airline->id ) }}" method="POST" onsubmit="return confirm('ANDA YAKIN INGIN MENGHAPUS PERMANEN DATA INI? TIDAK BISA DIKEMBALIKAN!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm me-2">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection