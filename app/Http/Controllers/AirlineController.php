<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AirlineController extends Controller
{
    // 1. INDEX: Menampilkan data aktif SAJA (tidak termasuk data sampah)
    public function index()
    {
        $airlines = Airline::latest()->paginate(10); 

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
            'name.required' => 'Nama maskapai wajib diisi.',
            'code.required' => 'Kode maskapai wajib diisi.',
            'logo.required' => 'Logo maskapai wajib diunggah.',
            'logo.image' => 'File yang diunggah harus berupa gambar.',
            'logo.mimes' => 'Format logo harus berupa jpeg, png, atau jpg.',
            'logo.max' => 'Ukuran logo tidak boleh lebih dari 2MB.',
        ]);

        $logo = $request->file('logo');
        $namaFile = time() . '-' . rand(1, 100) . '.' . $logo->getClientOriginalExtension();
        $path = $logo->storeAs('logos', $namaFile, 'public');
        
        $createData = Airline::create([
            'name' => $request->name,
            'code' => $request->code,
            'logo' => $path, 
        ]);

        if ($createData) {
            return redirect()->route('admin.airlines.index')->with('success', 'Berhasil membuat data');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan data!');
        }
    }

    public function show(Airline $airline)
    {
        return view('admin.airlines.show', compact('airline'));
    }

    public function edit(Airline $airline)
    {
        return view('admin.airlines.edit', compact('airline'));
    }

    public function update(Request $request, Airline $airline)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:airlines,name,' . $airline->id,
            'code' => 'required|string|max:10|unique:airlines,code,' . $airline->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'code']);

        if ($request->hasFile('logo')) {
            if ($airline->logo) {
                if (Storage::disk('public')->exists($airline->logo)) {
                    Storage::disk('public')->delete($airline->logo);
                }
            }
            
            $logo = $request->file('logo');
            $namaFile = time() . '-' . rand(1, 100) . '.' . $logo->getClientOriginalExtension();
            $path = $logo->storeAs('logos', $namaFile, 'public');
            $data['logo'] = $path; // Simpan path relatif baru
        }

        $airline->update($data);

        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai berhasil diperbarui!');
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();
        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai berhasil dinon-aktifkan (masuk tempat sampah)!');
    }

    public function trash()
    {
        $airlineTrash = Airline::onlyTrashed()->get();
        return view('admin.airlines.trash', compact('airlineTrash'));
    }

    public function restore($id)
    {
        $airline = Airline::withTrashed()->findOrFail($id); 
        $airline->restore(); // Restore
        
        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai berhasil dikembalikan!');
    }

    public function forceDelete($id)
    {
        $airline = Airline::withTrashed()->findOrFail($id);
        
        if ($airline->logo) {
            if (Storage::disk('public')->exists($airline->logo)) {
                Storage::disk('public')->delete($airline->logo);
            }
        }
        
        $airline->forceDelete(); // Menghapus permanen dari database

        return redirect()->route('admin.airlines.trash')->with('success', 'Maskapai berhasil dihapus permanen!');
    }
}