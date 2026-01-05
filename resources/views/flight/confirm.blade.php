@extends('templates.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white py-4">
                        <h1 class="h4 mb-0"><i class="fas fa-credit-card me-2"></i>Konfirmasi Pembayaran</h1>
                        <p class="mb-0 small opacity-75">Penerbangan ID: {{ $id }} •
                            {{ ucfirst(str_replace('_', ' ', $payment_method)) }}
                        </p>
                    </div>

                    <div class="card-body p-4">
                        @if (request('payment_status') == 'success')
                            <div class="text-center py-5">
                                <div class="rounded-circle bg-success bg-gradient d-inline-flex align-items-center justify-content-center mb-4"
                                    style="width: 70px; height: 70px;">
                                    <i class="fas fa-check fa-2x text-white"></i>
                                </div>
                                <h3 class="fw-bold text-success mb-3">✅ Pembayaran Berhasil!</h3>
                                <p class="text-muted mb-4">Pesanan Anda telah dikonfirmasi. E-tiket akan dikirim ke email.</p>
                                <a href="{{ route('user.flights.details', ['id' => $id]) }}" class="btn btn-success px-4">
                                    <i class="fas fa-ticket-alt me-2"></i>Konfirmasi Pembayaran
                                </a>
                            </div>

                        @elseif($payment_method == 'transfer')
                            <div class="p-3">
                                <h3 class="fw-bold text-info mb-3"><i class="fas fa-university me-2"></i>Transfer Bank</h3>
                                <div class="card border border-info mb-4">
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-6"><small class="text-muted">Bank:</small>
                                                <div class="fw-bold">BCA</div>
                                            </div>
                                            <div class="col-6"><small class="text-muted">No Rek:</small>
                                                <div class="fw-bold">1234567890</div>
                                            </div>
                                            <div class="col-6"><small class="text-muted">A/N:</small>
                                                <div class="fw-bold">PT Travel Company</div>
                                            </div>
                                            <div class="col-6"><small class="text-muted">Jumlah:</small>
                                                <div class="fw-bold text-danger">Rp 1.459.840</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('flight.confirm', ['id' => $id]) }}" method="POST"
                                    enctype="multipart/form-data">
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
                                <div class="d-flex gap-3 mb-4 justify-content-start align-items-center">
                                    <div class="card p-2 shadow-sm border rounded-3"
                                        style="width: 80px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                                            alt="Mastercard" style="max-height: 100%; max-width: 100%;">
                                    </div>
                                    <div class="card p-2 shadow-sm border-primary border-2 rounded-3"
                                        style="width: 80px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg"
                                            alt="Visa" style="max-height: 100%; max-width: 100%;">
                                    </div>
                                    <div class="card p-2 shadow-sm border rounded-3"
                                        style="width: 80px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal"
                                            style="max-height: 80%; max-width: 80%;">
                                    </div>
                                </div>

                                <div class="card bg-dark text-white mb-4 border-0 shadow-sm mx-auto"
                                    style="background: linear-gradient(135deg, #1a1a1a, #373737); border-radius: 15px; max-width: 400px;">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between mb-4">
                                            <i class="fas fa-microchip fa-2x text-warning"></i>
                                            <i class="fab fa-cc-visa fa-2x"></i>
                                        </div>
                                        <div id="cardNumberDisplay" class="fs-4 fw-bold mb-3 font-monospace letter-spacing-2">
                                            XXXX XXXX XXXX XXXX</div>
                                        <div class="row">
                                            <div class="col-8">
                                                <small class="text-white-50 d-block" style="font-size: 0.7rem;">CARDHOLDER
                                                    NAME</small>
                                                <div id="cardNameDisplay" class="fw-bold text-uppercase small">NAMA LENGKAP
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <small class="text-white-50 d-block" style="font-size: 0.7rem;">EXPIRES</small>
                                                <div id="expiryDisplay" class="fw-bold small">MM/YY</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('flight.confirm', ['id' => $id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="credit_card">

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-secondary">Cardholder name</label>
                                        <input type="text" id="cardName" name="card_name"
                                            class="form-control form-control-lg border-2" placeholder="Enter name" required
                                            style="border-radius: 8px;">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-secondary">Card number</label>
                                        <input type="text" id="cardNumber" name="card_number"
                                            class="form-control form-control-lg border-2" placeholder="0000 0000 0000 0000"
                                            maxlength="19" required style="border-radius: 8px;">
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-6">
                                            <label class="form-label small fw-bold text-secondary">Expiration date</label>
                                            <input type="text" id="expiryDate" name="expiry_date"
                                                class="form-control form-control-lg border-2" placeholder="MM/YY" maxlength="5"
                                                required style="border-radius: 8px;">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold text-secondary">CVC</label>
                                            <div class="input-group">
                                                <input type="password" id="cvv" name="cvc"
                                                    class="form-control form-control-lg border-2" placeholder="123"
                                                    maxlength="3" required style="border-radius: 8px 0 0 8px;">
                                                <button type="button" class="btn btn-outline-secondary border-2 border-start-0"
                                                    onclick="toggleCVV()" style="border-radius: 0 8px 8px 0;">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid mt-5">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 shadow"
                                            style="background: linear-gradient(to right, #8e90ff, #7375ff); border: none; border-radius: 12px;">
                                            Pay now
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
                                            <input class="form-check-input" type="radio" name="ewallet" value="gopay" id="gopay"
                                                checked>
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
                                        <img id="qrCode"
                                            src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=GoPay-{{ $id }}"
                                            class="img-fluid mb-2">
                                    </div>
                                    <p class="small text-muted mt-2">Scan QR untuk membayar: <strong class="text-danger">Rp
                                            1.459.840</strong></p>
                                </div>
                                <form id="eWalletForm" action="{{ route('flight.confirm', ['id' => $id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="e-wallet">
                                    <input type="hidden" id="selectedEwallet" name="selected_ewallet" value="gopay">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-bolt me-2"></i>Konfirmasi Pembayaran
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
                                <a href="{{ route('flight.payment', ['id' => $id]) }}" class="btn btn-outline-secondary">
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
document.addEventListener('DOMContentLoaded', () => {

    // ===== E-WALLET =====
    document.querySelectorAll('[name="ewallet"]').forEach(el => {
        el.onchange = () => {
            selectedEwallet.value = el.value;
            qrCode.src =
                `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${el.value.toUpperCase()}-{{ $id }}`;
        };
    });

    // ===== CREDIT CARD PREVIEW =====
    cardNumber.oninput = () => {
        cardNumber.value = cardNumber.value.replace(/\D/g, '')
            .replace(/(.{4})/g, '$1 ').trim();
        cardNumberDisplay.innerText = cardNumber.value || 'XXXX XXXX XXXX XXXX';
    };

    cardName.oninput = () => {
        cardNameDisplay.innerText = cardName.value.toUpperCase() || 'NAMA LENGKAP';
    };

    expiryDate.oninput = () => {
        let v = expiryDate.value.replace(/\D/g, '');
        expiryDate.value = v.length > 2 ? v.slice(0,2)+'/'+v.slice(2,4) : v;
        expiryDisplay.innerText = expiryDate.value || 'MM/YY';
    };
});

// ===== TOGGLE CVV =====
function toggleCVV() {
    cvv.type = cvv.type === 'password' ? 'text' : 'password';
}
</script>
@endpush