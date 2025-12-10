<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PassengerController extends Controller
{
    /**
     * Menampilkan daftar semua data penumpang aktif (INDEX).
     */
    // Contoh di App\Http\Controllers\Admin\DashboardController.php

    public function index()
    {
        // --- Langkah 1: Ambil Data Penjualan Tiket ---
        // Contoh query: Menghitung jumlah tiket terjual per bulan

        $salesData = \App\Models\Booking::query()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->selectRaw('COUNT(id) as total_sales')
            ->where('status', 'paid') // Hanya hitung booking yang sudah dibayar
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // --- Langkah 2: Pisahkan menjadi Labels dan Data ---
        $labels = $salesData->pluck('month')->toArray(); // Contoh: ['2025-10', '2025-11', '2025-12']
        $data = $salesData->pluck('total_sales')->toArray(); // Contoh: [50, 75, 120]

        // --- Langkah 3: Kirim ke View ---
        return view('admin.dashboard', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * Menampilkan form untuk membuat data penumpang baru (CREATE).
     *
     * Catatan: Dalam skenario nyata pemesanan tiket, data penumpang
     * umumnya dibuat melalui proses Booking, bukan langsung di Admin.
     * Halaman ini mungkin hanya berisi form dasar jika memang diperlukan.
     */
    public function create()
    {
        // Karena penumpang sangat erat kaitannya dengan booking/tiket,
        // halaman create ini mungkin hanya digunakan untuk debugging/manual entry
        return view('admin.passengers.create');
    }

    /**
     * Menyimpan data penumpang baru ke database (STORE).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'ticket_id' => 'nullable|unique:passengers,ticket_id|exists:tickets,id',
            'name' => 'required|string|max:255',
            'id_card_number' => 'nullable|string|max:50',
            'birth_date' => 'required|date',
            'type' => 'required|in:adult,child,infant',
        ]);

        Passenger::create($validated);

        return redirect()->route('admin.passenger.index')->with('success', 'Data penumpang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data penumpang tertentu (EDIT).
     */
    public function edit(Passenger $passenger)
    {
        return view('admin.passengers.edit', compact('passenger'));
    }

    /**
     * Memperbarui data penumpang tertentu di database (UPDATE).
     */
    public function update(Request $request, Passenger $passenger)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_card_number' => 'nullable|string|max:50',
            'birth_date' => 'required|date',
            'type' => 'required|in:adult,child,infant',
            // ticket_id dan booking_id biasanya tidak diubah disini
        ]);

        $passenger->update($validated);

        return redirect()->route('admin.passenger.index')->with('success', 'Data penumpang ' . $passenger->name . ' berhasil diperbarui.');
    }

    /**
     * Melakukan Soft Delete pada data penumpang tertentu (DESTROY).
     */
    public function destroy(Passenger $passenger)
    {
        $passenger->delete();

        return redirect()->route('admin.passenger.index')->with('success', 'Data penumpang ' . $passenger->name . ' berhasil dihapus (soft delete).');
    }

    // --- SoftDeletes Management ---

    /**
     * Menampilkan daftar data penumpang yang terhapus (TRASH).
     */
    public function trash()
    {
        // Hanya ambil data yang sudah di-soft delete
        $passengers = Passenger::onlyTrashed()->paginate(15);

        return view('admin.passengers.trash', compact('passengers'));
    }

    /**
     * Mengembalikan (Restore) data penumpang dari trash.
     */
    public function restore($id)
    {
        $passenger = Passenger::onlyTrashed()->findOrFail($id);
        $passenger->restore();

        return redirect()->route('admin.passenger.trash')->with('success', 'Data penumpang ' . $passenger->name . ' berhasil dipulihkan.');
    }

    /**
     * Menghapus data penumpang secara permanen (FORCE DELETE).
     */
    public function deletePermanen($id)
    {
        $passenger = Passenger::onlyTrashed()->findOrFail($id);
        $passenger->forceDelete();

        return redirect()->route('admin.passenger.trash')->with('success', 'Data penumpang berhasil dihapus permanen.');
    }
}
