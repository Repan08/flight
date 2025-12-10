<?php

namespace App\Http\Controllers;

use App\Models\Airplane;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan ini jika ada gambar pesawat

class AirplaneController extends Controller
{

    public function index()
    {
        // Gunakan eager loading untuk memuat relasi Airline (walaupun CRUD Master tanpa relasi, ini praktik yang bagus)
        $airplanes = Airplane::with('airline')->withTrashed()->latest()->get();
        return view('admin.airplanes.index', compact('airplanes'));
    }

    public function create()
    {
        // Kirim data maskapai ke view agar bisa dipilih
        $airlines = Airline::all();
        return view('admin.airplanes.create', compact('airlines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id', // Relasi
            'model' => 'required|string|max:255|unique:airplanes,model',
            'seat_capacity' => 'required|integer|min:10',
        ]);

        Airplane::create([
            'airline_id' => $request->airline_id,
            'model' => $request->model,
            'seat_capacity' => $request->seat_capacity,
        ]);

        return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat baru berhasil ditambahkan!');
    }

    public function edit(Airplane $airplane)
    {
        $airlines = Airline::all();
        return view('admin.airplanes.edit', compact('airplane', 'airlines'));
    }

    public function update(Request $request, Airplane $airplane)
    {
        $request->validate([
            'airlane_id' => 'required|exists:airlines,id',
            'model' => 'required|string|max:255|unique:airplanes,model,' . $airplane->id,
            'seat_capacity' => 'required|integer|min:10',
        ]);

        $airplane->update($request->only(['airlane_id', 'model', 'seat_capacity']));

        return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat berhasil diperbarui!');
    }

    public function destroy(Airplane $airplane)
    {
        $airplane->delete();
        return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat berhasil dihapus (soft deleted)!');
    }

    public function restore($id)
    {
        Airplane::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat berhasil dikembalikan!');
    }

    public function forceDelete($id)
    {
        Airplane::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat berhasil dihapus PERMANEN!');
    }
}