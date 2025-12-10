<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airplane;
use App\Models\Airline;
use App\Models\Booking; // <<< DITAMBAHKAN
use App\Models\Passenger; // <<< DITAMBAHKAN (Untuk resolving relasi 'passengers')
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FlightController extends Controller
{

    private $kota = [
        'Jakarta',
        'Bandung',
        'Surabaya',
        'Bali',
        'Yogyakarta',
        'Medan'
    ];

    // Mapping jarak perkiraan (dalam km) antara kota untuk harga
    private $jarakKota = [
        'Jakarta-Bandung' => 150,
        'Jakarta-Surabaya' => 700,
        'Jakarta-Bali' => 1000,
        'Jakarta-Yogyakarta' => 450,
        'Jakarta-Medan' => 1400,
        'Bandung-Surabaya' => 600,
        'Bandung-Bali' => 900,
        'Bandung-Yogyakarta' => 350,
        'Bandung-Medan' => 1300,
        'Surabaya-Bali' => 400,
        'Surabaya-Yogyakarta' => 300,
        'Surabaya-Medan' => 1800,
        'Bali-Yogyakarta' => 600,
        'Bali-Medan' => 2200,
        'Yogyakarta-Medan' => 1700,
        // Tambahkan reverse jika perlu (misalnya, Bandung-Jakarta sama dengan Jakarta-Bandung)
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flights = Flight::with(['airplane.airline'])->withTrashed()->latest()->get();
        return view('admin.flights.index', compact('flights'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data pesawat (Airplanes) dan maskapai (Airlines)
        $airplanes = Airplane::with('airline')->get();
        // $this->kota sudah didefinisikan di controller ini
        return view('admin.flights.create', [
            'airplanes' => $airplanes,
            'kota' => $this->kota, // Mengambil properti kota yang sudah ada
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'airplane_id' => 'required|exists:airplanes,id',
            'origin' => 'required|string',
            'destination' => 'required|string|different:origin',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|integer|min:10000',
        ]);

        Flight::create($request->all());

        return redirect()->route('admin.flights.index')->with('success', 'Penerbangan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $airplanes = Airplane::with('airline')->get();
        return view('admin.flights.edit', [
            'flight' => $flight,
            'airplanes' => $airplanes,
            'kota' => $this->kota,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        //
    }

    /**
     * Handle flight search request.
     */
    public function search(Request $request)
    {
        // Validasi input sesuai form (tambahkan direct dan trip options)
        $request->validate([
            'departure' => 'required|string',
            'arrival' => 'required|string',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date|after:departure_date', // Pastikan return setelah departure
            'passengers' => 'required|string',
            'trip' => 'required|in:pp,sj,mk',  // Hanya pp, sj, mk sesuai radio button
            'direct' => 'nullable|boolean',  // Checkbox optional
        ]);

        // Parse passengers dari string select (misalnya "2 Dewasa - Ekonomi" -> 2)
        $passengers = $this->parsePassengers($request->passengers);

        // Ambil parameter lainnya
        $departure = $request->departure;
        $arrival = $request->arrival;
        $trip = $request->trip;
        $direct = $request->has('direct'); // True jika checkbox dicentang

        // Simulasi data penerbangan dengan harga dinamis
        $flights = [];
        $airlines = ['PT Sriwijaya Air', 'Lion Air', 'Garuda Indonesia', 'Citilink'];
        $badges = ['Termurah', 'Rekomendasi'];

        for ($i = 0; $i < 20; $i++) { // Buat 20 penerbangan dummy
            $airline = $airlines[array_rand($airlines)];
            $badge = $badges[array_rand($badges)];
            $departureTime = sprintf('%02d:%02d', rand(4, 18), rand(0, 59));
            $durationHours = rand(1, 4);
            $durationMinutes = rand(0, 59);
            $duration = $durationHours . 'j ' . $durationMinutes . 'm';
            $arrivalTime = sprintf('%02d:%02d', (intval(substr($departureTime, 0, 2)) + $durationHours) % 24, rand(0, 59)); // Estimasi arrival
            $departureAirport = $departure . ' (CGK)'; // Dummy, sesuaikan
            $arrivalAirport = $arrival . ' (DPS)'; // Dummy, sesuaikan

            // Tandai jika langsung (langsung = true jika direct dicentang dan random)
            $isDirect = $direct && rand(0, 1); // Simulasi: 50% langsung jika direct dicentang
            $flightTypeText = $isDirect ? 'Langsung' : 'Transit';

            // Hitung harga dinamis berdasarkan kota
            $harga = $this->hitungHarga($departure, $arrival, $trip, $passengers);
            $priceFormatted = 'Rp' . number_format($harga, 0, ',', '.');

            $tripType = $trip == 'pp' ? 'Pulang-pergi' : ($trip == 'sj' ? 'Sekali Jalan' : 'Multi-Kota');

            $flights[] = [
                'airline' => $airline,
                'badge' => $badge,
                'departure_time' => $departureTime,
                'departure_airport' => $departureAirport,
                'duration' => $duration,
                'arrival_time' => $arrivalTime,
                'arrival_airport' => $arrivalAirport,
                'price' => $priceFormatted,
                'trip_type' => $tripType,
                'flight_type' => $flightTypeText, // Tambahan untuk view hasil (filter langsung)
            ];
        }

        // Simpan ke session untuk results() jika perlu
        session(['flights' => $flights, 'searchParams' => $request->all()]);

        // Kirim data ke view hasil pencarian
        return view('flights.result', compact('flights') + [
            'departure' => $departure,
            'arrival' => $arrival,
            'searchParams' => $request->all(),
        ]);
    }

    /**
     * Fungsi helper untuk parse jumlah penumpang dari string select.
     */
    private function parsePassengers($passengersString)
    {
        // Ekstrak angka pertama dari string (misalnya "2 Dewasa - Ekonomi" -> 2)
        preg_match('/(\d+)/', $passengersString, $matches);
        return $matches[1] ?? 1; // Default 1 jika tidak ada angka
    }

    /**
     * Fungsi untuk menghitung harga berdasarkan jarak kota.
     */
    private function hitungHarga($departure, $arrival, $trip, $passengers)
    {
        $hargaDasar = 1000000; // Rp 1.000.000 dasar

        // Cari jarak dari array
        $key = $departure . '-' . $arrival;
        $reverseKey = $arrival . '-' . $departure;
        $jarak = $this->jarakKota[$key] ?? $this->jarakKota[$reverseKey] ?? 500; // Default 500km

        // Biaya per km (Rp 1.000 per km)
        $biayaJarak = $jarak * 1000;

        // Tambah untuk round-trip (2x harga)
        if ($trip == 'pp') {
            $biayaJarak *= 2;
        }

        // Tambah untuk penumpang (harga per orang)
        $totalHarga = ($hargaDasar + $biayaJarak) * $passengers;

        // Variasi acak ±10% untuk realisme
        $variasi = rand(-10, 10) / 100;
        $totalHarga += $totalHarga * $variasi;

        return round($totalHarga);
    }

    public function results()
    {
        // Ambil data dari session (dari search)
        $flights = session('flights', []);
        $searchParams = session('searchParams', []);
        return view('flights.result', compact('flights', 'searchParams'));
    }

    public function payment($id)
    {
        // Kirim data $id ke view (misalnya, untuk menampilkan detail penerbangan)
        return view('flights.payment', compact('id'));
    }

    // FlightController.php (ASUMSI PERBAIKAN)

// ... (sebelumnya)

public function confirm(Request $request, $id)
{
    // Ambil data dari form (metode pembayaran)
    $payment_method = $request->input('payment_method');
    $amount = $request->input('amount') ?? 0;
    if ($payment_method == 'transfer') {
        // ... (logic upload bukti transfer, sudah benar)
        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('public/payments');
            $publicPath = str_replace('public/', 'storage/', $path);

            return view('flights.transfer-confirmed', [
                'booking_id' => $id,
                'amount' => $amount,
                'proof_path' => $publicPath,
            ]);
        }

        return view('flights.confirm', compact('id', 'payment_method'));
    }

    // Kasus 2: Kartu kredit atau e-wallet (Pembayaran Sukses)
    if ($payment_method == 'credit_card' || $payment_method == 'e-wallet') {
        return redirect()->route('flights.confirm', ['id' => $id, 'payment_status' => 'success']);
    }

    // Kasus fallback (untuk menampilkan form CC/E-Wallet jika belum disubmit)
    return view('flights.confirm', compact('id', 'payment_method'));
}

// ... (setelahnya)
    public function bookingsHistory()
    {
        // Ambil semua pemesanan yang dimiliki oleh user yang sedang login
        $bookings = Auth::user()->bookings()
                     ->with('flight', 'passengers') // Load relasi flight dan passengers
                     ->latest() // Urutkan dari yang terbaru
                     ->paginate(10); // Gunakan paginasi

        return view('user.history', compact('bookings'));
    }
}