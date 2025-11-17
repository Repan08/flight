@extends('templates.app')

@section('content')
<div class="container my-5">
    <h3 class="fw-bold mb-4">Dashboard Admin</h3>

    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 bg-primary text-white">
                <h5>Total Pesawat</h5>
                <h2></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 bg-success text-white">
                <h5>Total Pengguna</h5>
                <h2></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 bg-warning text-dark">
                <h5>Total Pemesanan</h5>
                <h2></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 bg-danger text-white">
                <h5>Total Pendapatan</h5>
                <h2></h2>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="fw-bold mb-3">Menu Kelola Data</h4>
        <div class="list-group">
            <a href="" class="list-group-item list-group-item-action">Kelola Pesawat</a>
            <a href="" class="list-group-item list-group-item-action">Kelola Jadwal Penerbangan</a>
            <a href="" class="list-group-item list-group-item-action">Kelola Pembayaran</a>
            <a href="" class="list-group-item list-group-item-action">Kelola Petugas</a>
        </div>
    </div>
</div>
@endsection
