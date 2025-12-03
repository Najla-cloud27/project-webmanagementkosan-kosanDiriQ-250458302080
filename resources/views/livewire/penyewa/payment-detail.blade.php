@php
    $header = 'Detail Pembayaran';
@endphp

<div>
    <!-- Success/Error Message -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-check"></i> {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fas fa-ban"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Booking Details -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-invoice"></i> Detail Booking</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Kode Booking</th>
                            <td><strong class="text-primary">{{ $booking->booking_code }}</strong></td>
                        </tr>
                        <tr>
                            <th>Kamar</th>
                            <td>{{ $booking->room->name }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>{{ $booking->duration_in_months }} Bulan</td>
                        </tr>
                        <tr>
                            <th>Check-In</th>
                            <td>{{ Carbon\Carbon::parse($booking->planned_check_in_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Check-Out</th>
                            <td>{{ Carbon\Carbon::parse($booking->selesai_booking)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status Booking</th>
                            <td>
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i> Pembayaran Tertunda
                                </span>
                            </td>
                        </tr>
                        @if($booking->notes)
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $booking->notes }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <h5><i class="icon fas fa-info-circle"></i> Cara Pembayaran:</h5>
                        <ol class="mb-0 pl-3">
                            <li>Lakukan transfer sesuai nominal tagihan</li>
                            <li>Upload bukti transfer pada form di samping</li>
                            <li>Admin akan memverifikasi pembayaran Anda</li>
                            <li>Setelah terverifikasi, booking akan dikonfirmasi</li>
                        </ol>
                    </div>

                    <h5 class="mb-2"><i class="fas fa-university"></i> Rekening Tujuan:</h5>
                    <div class="bg-light p-3 rounded">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td width="35%"><strong>Bank</strong></td>
                                <td>: BCA</td>
                            </tr>
                            <tr>
                                <td><strong>No. Rekening</strong></td>
                                <td>: <strong class="text-primary">1234567890</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Atas Nama</strong></td>
                                <td>: KosanKu Management</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-3 bg-light p-3 rounded">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td width="35%"><strong>Bank</strong></td>
                                <td>: Mandiri</td>
                            </tr>
                            <tr>
                                <td><strong>No. Rekening</strong></td>
                                <td>: <strong class="text-primary">0987654321</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Atas Nama</strong></td>
                                <td>: KosanKu Management</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-money-check-alt"></i> Rincian Tagihan</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Kode Tagihan</th>
                            <td><strong class="text-success">{{ $bill->bill_code }}</strong></td>
                        </tr>
                        <tr>
                            <th>Harga Sewa/Bulan</th>
                            <td>Rp {{ number_format($booking->room->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>{{ $booking->duration_in_months }} Bulan</td>
                        </tr>
                        <tr class="table-active">
                            <th><h5>Total Tagihan</h5></th>
                            <td><h5 class="text-success mb-0"><strong>Rp {{ number_format($bill->amount, 0, ',', '.') }}</strong></h5></td>
                        </tr>
                        <tr>
                            <th>Jatuh Tempo</th>
                            <td>
                                <span class="badge badge-danger">
                                    <i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($bill->status == 'belum_dibayar')
                                    <span class="badge badge-danger">Belum Dibayar</span>
                                @elseif($bill->status == 'menunggu_verifikasi')
                                    <span class="badge badge-warning">Menunggu Verifikasi</span>
                                @elseif($bill->status == 'dibayar')
                                    <span class="badge badge-success">Dibayar</span>
                                @else
                                    <span class="badge badge-dark">Overdue</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($existingProof)
                <!-- Already Uploaded -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-check-circle"></i> Bukti Pembayaran Terkirim</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="icon fas fa-clock"></i>
                            Bukti pembayaran Anda sedang dalam proses verifikasi oleh admin. Mohon tunggu konfirmasi.
                        </div>

                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/' . $existingProof->proof_image_url) }}" 
                                 alt="Bukti Pembayaran" 
                                 class="img-fluid rounded border"
                                 style="max-height: 300px;">
                        </div>

                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Metode Pembayaran</th>
                                <td>{{ $existingProof->payment_method }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($existingProof->status == 'pending')
                                        <span class="badge badge-warning">Menunggu Verifikasi</span>
                                    @elseif($existingProof->status == 'approved')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @if($existingProof->notes)
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $existingProof->notes }}</td>
                            </tr>
                            @endif
                            @if($existingProof->admin_notes)
                            <tr>
                                <th>Catatan Admin</th>
                                <td><em>{{ $existingProof->admin_notes }}</em></td>
                            </tr>
                            @endif
                        </table>

                        <a href="{{ route('penyewa.bookings.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Kembali ke Booking
                        </a>
                    </div>
                </div>
            @else
                <!-- Upload Form -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-upload"></i> Upload Bukti Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="uploadPaymentProof">
                            <div class="form-group">
                                <label>Metode Pembayaran <span class="text-danger">*</span></label>
                                <select wire:model="payment_method" class="form-control @error('payment_method') is-invalid @enderror">
                                    <option value="">Pilih Metode</option>
                                    <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                                    <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                    <option value="Transfer Bank BNI">Transfer Bank BNI</option>
                                    <option value="Transfer Bank BRI">Transfer Bank BRI</option>
                                    <option value="E-Wallet (OVO/DANA/GoPay)">E-Wallet (OVO/DANA/GoPay)</option>
                                </select>
                                @error('payment_method') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Bukti Transfer <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" wire:model="payment_proof" class="custom-file-input @error('payment_proof') is-invalid @enderror" id="paymentProofFile" accept="image/*">
                                    <label class="custom-file-label" for="paymentProofFile">
                                        {{ $payment_proof ? $payment_proof->getClientOriginalName() : 'Pilih file gambar...' }}
                                    </label>
                                </div>
                                @error('payment_proof') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                            </div>

                            @if($payment_proof)
                                <div class="form-group">
                                    <label>Preview:</label>
                                    <div class="text-center">
                                        <img src="{{ $payment_proof->temporaryUrl() }}" class="img-fluid rounded border" style="max-height: 300px;">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Catatan (Opsional)</label>
                                <textarea wire:model="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                @error('notes') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary btn-block" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="uploadPaymentProof">
                                        <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
                                    </span>
                                    <span wire:loading wire:target="uploadPaymentProof">
                                        <i class="fas fa-spinner fa-spin"></i> Mengirim...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
