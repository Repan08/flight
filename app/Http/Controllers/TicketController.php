<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function showConfirmPayment($id)
    {
        $user = Auth::user();
        $booking = \App\Models\Booking::with('flight')->findOrFail($id);
        if ($booking->user_id !== $user->id) {
            abort(403);
        }

        return view('ticket.confirm-payment', compact('booking'));
    }

    public function confirmPayment(Request $request, $id)
    {
        $user = Auth::user();
        $booking = \App\Models\Booking::with('flight')->findOrFail($id);
        if ($booking->user_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            // Buat folder jika belum ada
            $paymentsDir = storage_path('app/public/payments');
            if (!file_exists($paymentsDir)) {
                mkdir($paymentsDir, 0755, true);
            }

            // Generate nama file yang unik
            $file = $request->file('proof');
            $fileName = 'proof_' . $booking->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke folder payments
            $file->move($paymentsDir, $fileName);
            
            // Not writing to DB per request; just show confirmation to user
            return view('ticket.payment-confirmed', [
                'booking' => $booking,
                'proof_path' => $fileName,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload file: ' . $e->getMessage());
        }
    }
}
