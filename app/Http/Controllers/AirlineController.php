<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AirlineController extends Controller
{
    public function index()
    {
        $airlines = Airline::withTrashed()->latest()->paginate(10);

        return view('admin.airlines.index', compact('airlines'));
    }

    public function create()
    {
        return view('admin.airlines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:airlines,name',
            'code' => 'required|string|max:10|unique:airlines,code',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ], [
            'name' => 'Nama maskapai wajib diisi.',
            'logo' => 'Logo maskapai wajib diunggah.',
            'logo' => 'File yang diunggah harus berupa gambar.',
            'logo' => 'Format logo harus berupa jpeg, png, atau jpg.',
            'logo' => 'Ukuran logo tidak boleh lebih dari 2MB.',
        ]);

        $logo = $request->file('logo');
        $namaFile = rand(1, 10) . '-logo.' . $logo->getClientOriginalExtension();
        $path = $logo->storeAs('logos', $namaFile, 'public');

        Airline::create([
            'name' => $request->name,
            'code' => $request->code,
            'logo' => $path,
        ]);

        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai baru berhasil ditambahkan!');
    }

    public function show(Airline $airline)
    {
        return view('admin.airlines.show', compact('airline'));
    }
    
    public function edit(Airline $airline)
    {
        return view('admin.airlines.edit', compact('airline'));
    }

    // 5. UPDATE: Memperbarui data yang ada
    public function update(Request $request, Airline $airline)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:airlines,name,' . $airline->id,
            'code' => 'required|string|max:10|unique:airlines,code,' . $airline->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // nullable karena boleh tidak diubah
        ]);

        $data = $request->only(['name', 'code']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama (jika ada) sebelum upload baru
            if ($airline->logo) {
                // Konversi URL public ke path storage
                $oldPath = str_replace('/storage', 'public', $airline->logo);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
            $path = $request->file('logo')->store('public/logos');
            $data['logo'] = Storage::url($path);
        }

        $airline->update($data);

        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai berhasil diperbarui!');
    }

    // 6. DELETE (SoftDeletes): Menghapus sementara data (ke keranjang sampah)
    public function destroy(Airline $airline)
    {
        $airline->delete(); // Soft Delete
        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai berhasil dihapus (soft deleted)!');
    }

    // 7. RESTORE (SoftDeletes): Mengembalikan data yang sudah dihapus sementara
    public function restore($id)
    {
        $airline = Airline::withTrashed()->findOrFail($id);
        $airline->restore(); // Restore
        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai berhasil dikembalikan!');
    }

    // 8. FORCE DELETE (SoftDeletes): Menghapus permanen data
    public function forceDelete($id)
    {
        $airline = Airline::withTrashed()->findOrFail($id);

        // Hapus file logo dari storage
        if ($airline->logo) {
            $path = str_replace('/storage', 'public', $airline->logo);
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        $airline->forceDelete(); // Force Delete
        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai berhasil dihapus PERMANEN!');
    }
}
