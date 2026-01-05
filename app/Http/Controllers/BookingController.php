<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookingController extends Controller
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
        return redirect('flight.payment');
    }


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function bookingsHistory()
    {
        // Ambil semua pemesanan yang dimiliki oleh user yang sedang login
        $bookings = Auth::user()->bookings()
            ->with('flight', 'passengers') // Load relasi flight dan passengers
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10); // Gunakan paginasi

        return view('user.history', compact('bookings'));
    }

    public function confirm(Request $request, $id)
    {
        $payment_method = $request->input('payment_method')
            ?? $request->query('payment_method');

        if (!$request->isMethod('post')) {
            return view('flight.confirm', compact('id', 'payment_method'));
        }

        if ($payment_method === 'transfer') {

            if ($request->hasFile('proof')) {
                $path = $request->file('proof')->store('public/payments');
                $publicPath = str_replace('public/', 'storage/', $path);

                return view('flight.confirm', [
                    'id' => $id,
                    'payment_method' => 'transfer',
                    'payment_status' => 'success',
                ]);
            }

            return view('flight.confirm', compact('id', 'payment_method'));
        }

        if ($payment_method === 'credit_card') {

            // validasi sederhana (frontend sudah bagus)
            $request->validate([
                'card_name' => 'required',
                'card_number' => 'required',
                'expiry_date' => 'required',
                'cvc' => 'required',
            ]);

            return view('flight.confirm', [
                'id' => $id,
                'payment_method' => 'credit_card',
                'payment_status' => 'success',
            ]);
        }

        if ($payment_method === 'ewallet') {

            return view('flight.confirm', [
                'id' => $id,
                'payment_method' => 'ewallet',
                'payment_status' => 'success',
            ]);
        }

        return view('flight.confirm', compact('id'));
    }
}
