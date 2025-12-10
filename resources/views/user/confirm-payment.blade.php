@extends('templates.app')

@section('content')
    <style>
        .alert {
            margin-bottom: 20px;
        }

        .btn {
            margin-top: 10px;
        }
    </style>
    <div class="container mt-4">
        <h1> 💳 Konfirmasi Pembayaran</h1>
        <p>Penerbangan ID: {{ $id }}</p>
        <p>Metode Pembayaran: {{ ucfirst(str_replace('_', ' ', $payment_method)) }}</p>

        {{-- 1. TAMPILAN SUKSES (setelah redirect dari Kartu Kredit/E-Wallet) --}}
        @if (request()->has('payment_status') && request('payment_status') == 'success')
            <div class="alert alert-success text-center py-5">
                <h2 class="display-4">✅ Pembayaran Berhasil!</h2>
                <p class="lead">Pesanan Anda telah berhasil dikonfirmasi.</p>
                <hr>
                <p>Terima kasih telah melakukan pemesanan. Detail e-tiket akan segera dikirimkan ke email Anda.</p>
                <a href="{{ route('user.flights.details', ['id' => $id]) }}" class="btn btn-primary mt-3">Lihat Detail Pesanan</a>
            </div>

        {{-- 2. TAMPILAN TRANSFER BANK (Perlu Upload Bukti) --}}
        @elseif($payment_method == 'transfer')
            {{-- Bagian ini tidak diubah karena sudah mengarahkan ke flights.confirm (backend) --}}
            <div class="alert alert-info">
                <h4>Transfer Bank</h4>
                <p>Silakan transfer ke rekening berikut:</p>
                <ul>
                    <li>Bank: BCA</li>
                    <li>No. Rekening: 1234567890</li>
                    <li>Atas Nama: PT. Travel Company</li>
                    <li>Jumlah: Rp 1.459.840</li>
                </ul>
                <form id="transferForm" action="{{ route('flights.confirm', ['id' => $id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- Tambahkan input amount agar bisa dicatat di confirm() controller --}}
                    <input type="hidden" name="amount" value="1459840">
                    <input type="hidden" name="payment_method" value="transfer">
                    <div class="mb-3">
                        <label>Upload Bukti Transfer:</label>
                        <input type="file" name="proof" class="form-control" accept=".jpg,.png,.pdf" required>
                    </div>
                    <button type="submit" class="btn btn-success">Konfirmasi Transfer</button>
                </form>
            </div>

        {{-- 3. TAMPILAN KARTU KREDIT --}}
        @elseif($payment_method == 'credit_card')
            <div class="alert alert-primary">
                <h4>Pembayaran Kartu Kredit</h4>
                <p>Silakan masukkan detail kartu kredit Anda untuk menyelesaikan pembayaran sebesar <strong> Rp 1.459.840</strong></p>
                
                <form id="creditCardForm" action="{{ route('flights.confirm', ['id' => $id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="credit_card">
                    <input type="hidden" name="amount" value="1459840"> {{-- Tambahkan amount --}}
                    
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Nomor Kartu Kredit:</label>
                        <input type="text" id="card_number" name="card_number" class="form-control" placeholder="XXXX XXXX XXXX XXXX" required maxlength="19">
                    </div>

                    <div class="mb-3">
                        <label for="card_name" class="form-label">Nama pada Kartu:</label>
                        <input type="text" id="card_name" name="card_name" class="form-control" placeholder="Nama Lengkap sesuai Kartu" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="expiry_date" class="form-label">Tanggal Kedaluwarsa (MM/YY):</label>
                            <input type="text" id="expiry_date" name="expiry_date" class="form-control" placeholder="MM/YY" required maxlength="5">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cvc" class="form-label">CVV:</label>
                            <input type="text" id="cvc" name="cvc" class="form-control" placeholder="XXX" required maxlength="3">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" id="creditCardSubmit">Bayar dengan Kartu Kredit</button>
                    <small class="d-block mt-2 text-muted">Pembayaran diproses oleh Payment Gateway aman.</small>
                </form>
            </div>

        {{-- 4. TAMPILAN E-WALLET --}}
        @elseif($payment_method == 'ewallet')
            <div class="alert alert-success">
                <h4>Pembayaran E-Wallet</h4>
                <p>Pilih e-wallet yang Anda gunakan, lalu scan QR code atau tekan **Bayar Sekarang** untuk melanjutkan pembayaran.</p>

                <label for="ewallet-select" class="form-label">Pilih E-Wallet:</label>
                <select id="ewallet-select" class="form-select mb-3">
                    <option value="gopay" selected>GoPay</option>
                    <option value="ovo">OVO</option>
                    <option value="dana">Dana</option>
                </select>

                <div id="ewallet-info" class="text-center p-3 border rounded bg-light mb-3">
                    <h5 id="qr-title">GoPay QR Code</h5>
                    <img id="qr-code-img" src="https://via.placeholder.com/200x200?text=GoPay+QR" alt="QR Code" class="img-fluid">
                    <p class="text-muted small mt-2">Pastikan jumlah pembayaran sesuai: Rp 1.459.840</p>
                </div>

                <form id="eWalletForm" action="{{ route('flights.confirm', ['id' => $id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="e-wallet">
                    <input type="hidden" name="amount" value="1459840"> {{-- Tambahkan amount --}}
                    <input type="hidden" id="selected_ewallet" name="selected_ewallet" value="gopay">
                    <button type="submit" class="btn btn-success" id="eWalletSubmit">Bayar Sekarang</button>
                </form>
            </div>

        {{-- 5. JIKA METODE TIDAK DIKENAL --}}
        @else
            <div class="alert alert-danger">
                <p>Metode pembayaran tidak valid. Silakan kembali.</p>
            </div>
        @endif

        <a href="{{ route('flights.payment', ['id' => $id]) }}" class="btn btn-secondary">Kembali ke Metode Pembayaran</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- LOGIC DINAMIS E-WALLET ---
            const ewalletSelect = document.getElementById('ewallet-select');
            const qrCodeImg = document.getElementById('qr-code-img');
            const qrTitle = document.getElementById('qr-title');
            const selectedEwalletInput = document.getElementById('selected_ewallet');
            const eWalletForm = document.getElementById('eWalletForm');
            const creditCardForm = document.getElementById('creditCardForm');

            // Logic untuk E-Wallet
            if (ewalletSelect) {
                ewalletSelect.addEventListener('change', function() {
                    const selectedValue = this.value;
                    const selectedText = this.options[this.selectedIndex].text;
                    
                    qrTitle.textContent = selectedText + ' QR Code';
                    qrCodeImg.src = `https://via.placeholder.com/200x200?text=${selectedText}+QR`;
                    
                    if (selectedEwalletInput) {
                        selectedEwalletInput.value = selectedValue;
                    }
                });
            }

            // SIMULASI SUKSES pada klik "Bayar Sekarang" E-Wallet
            if (eWalletForm) {
                eWalletForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    
                    alert('Simulasi: Sedang memproses pembayaran via E-Wallet. Akan mengirim data ke backend.');
                    // Lanjutkan dengan mengirim form (memanggil backend)
                    eWalletForm.submit(); 
                    
                    // Catatan: Di realita, ini akan digantikan dengan integrasi ke Payment Gateway (Midtrans/Xendit/etc) 
                    // yang akan me-redirect kembali ke halaman ini dengan parameter payment_status=success
                });
            }
            
            // SIMULASI SUKSES pada klik "Bayar dengan Kartu Kredit"
            if (creditCardForm) {
                creditCardForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    
                    // Tambahkan validasi dasar (jika diperlukan)
                    if (this.checkValidity() === false) {
                        e.stopPropagation();
                    } else {
                        alert('Simulasi: Sedang memproses pembayaran via Kartu Kredit. Akan mengirim data ke backend.');
                        // Lanjutkan dengan mengirim form (memanggil backend)
                        creditCardForm.submit();
                    }
                    // Catatan: Di realita, ini akan digantikan dengan integrasi ke Payment Gateway 
                    // yang akan me-redirect kembali ke halaman ini dengan parameter payment_status=success
                });
            }

            // --- FORMATTING KARTU KREDIT (Tidak Diubah) ---
            const cardNumberInput = document.getElementById('card_number');
            const expiryDateInput = document.getElementById('expiry_date');

            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s/g, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || '';
                    e.target.value = formattedValue;
                });
            }
            
            if (expiryDateInput) {
                expiryDateInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\//g, '');
                    
                    if (value.length > 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }
        });
    </script>
@endsection