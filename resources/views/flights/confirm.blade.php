@extends('templates.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-4">
                    <h1 class="h4 mb-0"><i class="fas fa-credit-card me-2"></i>Konfirmasi Pembayaran</h1>
                    <p class="mb-0 small opacity-75">Penerbangan ID: {{ $id }} • {{ ucfirst(str_replace('_', ' ', $payment_method)) }}</p>
                </div>
                
                <div class="card-body p-4">
                    @if (request('payment_status') == 'success')
                    <div class="text-center py-5">
                        <div class="rounded-circle bg-success bg-gradient d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-check fa-2x text-white"></i>
                        </div>
                        <h3 class="fw-bold text-success mb-3">✅ Pembayaran Berhasil!</h3>
                        <p class="text-muted mb-4">Pesanan Anda telah dikonfirmasi. E-tiket akan dikirim ke email.</p>
                        <a href="{{ route('user.flights.details', ['id' => $id]) }}" class="btn btn-success px-4">
                            <i class="fas fa-ticket-alt me-2"></i>Lihat Detail Pesanan
                        </a>
                    </div>
                    
                    @elseif($payment_method == 'transfer')
                    <div class="p-3">
                        <h4 class="fw-bold text-info mb-3"><i class="fas fa-university me-2"></i>Transfer Bank</h4>
                        <div class="card border border-info mb-4">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-6"><small class="text-muted">Bank:</small><div class="fw-bold">BCA</div></div>
                                    <div class="col-6"><small class="text-muted">No Rek:</small><div class="fw-bold">1234567890</div></div>
                                    <div class="col-6"><small class="text-muted">A/N:</small><div class="fw-bold">PT Travel Company</div></div>
                                    <div class="col-6"><small class="text-muted">Jumlah:</small><div class="fw-bold text-danger">Rp 1.459.840</div></div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('flights.confirm', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="payment_method" value="transfer">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload Bukti Transfer</label>
                                <input type="file" name="proof" class="form-control" accept=".jpg,.png,.pdf" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-2"></i>Konfirmasi Transfer
                            </button>
                        </form>
                    </div>
                    
                    @elseif($payment_method == 'credit_card')
                    <div class="p-3">
                        <!-- Credit Card Preview -->
                        <div class="card bg-primary text-white mb-4 border-0 shadow" 
                             style="background: linear-gradient(135deg, #0062cc, #0084ff);">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <i class="fas fa-credit-card fa-2x opacity-75"></i>
                                    <div class="bg-warning rounded" style="width: 50px; height: 40px; position: relative; overflow: hidden;">
                                        <div class="position-absolute top-50 start-0 w-100" style="height: 1px; background: rgba(0,0,0,0.1);"></div>
                                        <div class="position-absolute top-0 start-50" style="width: 1px; height: 100%; background: rgba(0,0,0,0.1);"></div>
                                        <div class="position-absolute bottom-50 start-0 w-100" style="height: 1px; background: rgba(0,0,0,0.1);"></div>
                                    </div>
                                </div>
                                <div id="cardNumberDisplay" class="fs-3 fw-bold mb-3 font-monospace">XXXX XXXX XXXX XXXX</div>
                                <div class="row">
                                    <div class="col-8">
                                        <small class="opacity-75">Nama Pemegang Kartu</small>
                                        <div id="cardNameDisplay" class="fw-bold text-uppercase">NAMA LENGKAP</div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <small class="opacity-75">Kadaluarsa</small>
                                        <div id="expiryDisplay" class="fw-bold">MM/YY</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="fw-bold text-primary mb-3">Detail Pembayaran</h5>
                        <p class="text-muted mb-4">Total: <span class="fw-bold text-danger fs-5">Rp 1.459.840</span></p>
                        
                        <form action="{{ route('flights.confirm', ['id' => $id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" value="credit_card">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Kartu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    <input type="text" id="cardNumber" name="card_number" class="form-control" 
                                           placeholder="1234 5678 9012 3456" maxlength="19" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Pemegang Kartu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="cardName" name="card_name" class="form-control" 
                                           placeholder="NAMA LENGKAP SESUAI KARTU" required>
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Kadaluarsa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="text" id="expiryDate" name="expiry_date" class="form-control" 
                                               placeholder="MM/YY" maxlength="5" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">CVV</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" id="cvv" name="cvc" class="form-control" 
                                               placeholder="123" maxlength="3" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleCVV()">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold py-3">
                                    <i class="fas fa-lock me-2"></i>Bayar Rp 1.459.840
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    @elseif($payment_method == 'ewallet')
                    <div class="p-3">
                        <h4 class="fw-bold text-success mb-3"><i class="fas fa-mobile-alt me-2"></i>E-Wallet</h4>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="form-check card p-3 border rounded-3">
                                    <input class="form-check-input" type="radio" name="ewallet" value="gopay" id="gopay" checked>
                                    <label class="form-check-label w-100" for="gopay">GoPay</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check card p-3 border rounded-3">
                                    <input class="form-check-input" type="radio" name="ewallet" value="ovo" id="ovo">
                                    <label class="form-check-label w-100" for="ovo">OVO</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check card p-3 border rounded-3">
                                    <input class="form-check-input" type="radio" name="ewallet" value="dana" id="dana">
                                    <label class="form-check-label w-100" for="dana">Dana</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-4">
                            <div class="border rounded-3 p-3 bg-white d-inline-block">
                                <img id="qrCode" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=GoPay-{{ $id }}" 
                                     class="img-fluid mb-2">
                            </div>
                            <p class="small text-muted mt-2">Scan QR untuk membayar: <strong class="text-danger">Rp 1.459.840</strong></p>
                        </div>
                        <form id="eWalletForm" action="{{ route('flights.confirm', ['id' => $id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" value="e-wallet">
                            <input type="hidden" id="selectedEwallet" name="selected_ewallet" value="gopay">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-bolt me-2"></i>Bayar Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger mb-3"></i>
                        <h5 class="fw-bold text-danger">Metode Tidak Valid</h5>
                        <p class="text-muted">Silakan pilih metode pembayaran yang tersedia.</p>
                    </div>
                    @endif
                    
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-grid">
                            <a href="{{ route('flights.payment', ['id' => $id]) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // E-Wallet Selection
    document.querySelectorAll('input[name="ewallet"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const wallet = this.value;
            document.getElementById('selectedEwallet').value = wallet;
            document.getElementById('qrCode').src = 
                `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${wallet.toUpperCase()}-{{ $id }}`;
        });
    });
    
    // Credit Card Live Preview
    const cardNumberInput = document.getElementById('cardNumber');
    const cardNameInput = document.getElementById('cardName');
    const expiryInput = document.getElementById('expiryDate');
    
    if(cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            let formatted = value.replace(/(.{4})/g, '$1 ').trim();
            this.value = formatted;
            document.getElementById('cardNumberDisplay').textContent = formatted || 'XXXX XXXX XXXX XXXX';
        });
    }
    
    if(cardNameInput) {
        cardNameInput.addEventListener('input', function() {
            document.getElementById('cardNameDisplay').textContent = 
                this.value.toUpperCase() || 'NAMA LENGKAP';
        });
    }
    
    if(expiryInput) {
        expiryInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if(value.length > 2) {
                value = value.substring(0,2) + '/' + value.substring(2,4);
            }
            this.value = value;
            document.getElementById('expiryDisplay').textContent = value || 'MM/YY';
        });
    }
});

function toggleCVV() {
    const cvvInput = document.getElementById('cvv');
    const eyeIcon = event.currentTarget.querySelector('i');
    if(cvvInput.type === 'password') {
        cvvInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        cvvInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>
@endpush