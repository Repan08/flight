@extends('templates.app')
@section('content')
    <div class="container">
        <h2>Edit Maskapai: {{ $airline->name }}</h2>
        @include('admin.airlines.edit', ['airline' => $airline])
    </div>
@endsection