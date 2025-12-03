@php
    $header = 'Verifikasi Pembayaran';
@endphp

<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="icon fas fa-check"></i> {{ session('message') }}
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select wire:model.live="statusFilter" class="form-control">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
        <div class="col-md-9">
            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari kode pembayaran, tagihan, nama penyewa...">
        </div>
    </div>

    <!-- Payment Proofs Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Bukti Pembayaran</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pembayaran</th>
                        <th>Penyewa</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Tanggal Upload</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paymentProofs as $index => $proof)
                    <tr>
                        <td>{{ $paymentProofs->firstItem() + $index }}</td>
                        <td><strong>{{ $proof->payment_code }}</strong></td>
                        <td>{{ $proof->user->name }}</td>
                        <td>{{ $proof->bill->bill_code }}</td>
                        <td>Rp {{ number_format($proof->amount, 0, ',', '.') }}</td>
                        <td>{{ $proof->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if($proof->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($proof->status == 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <button wire:click="selectProof({{ $proof->id }})" class="btn btn-sm btn-primary" title="Verifikasi">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-info-circle"></i> Tidak ada data bukti pembayaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $paymentProofs->links() }}
        </div>
    </div>

    <!-- Modal Verification -->
    @if($selectedProof)
    <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Verifikasi Bukti Pembayaran</h4>
                    <button type="button" wire:click="closeModal" class="close"><span>×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Kode Pembayaran</th>
                                    <td>{{ $selectedProof->payment_code }}</td>
                                </tr>
                                <tr>
                                    <th>Penyewa</th>
                                    <td>{{ $selectedProof->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $selectedProof->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Tagihan</th>
                                    <td>{{ $selectedProof->bill->bill_code }}</td>
                                </tr>
                                @if($selectedProof->bill->booking)
                                <tr>
                                    <th>Kode Booking</th>
                                    <td>{{ $selectedProof->bill->booking->booking_code }}</td>
                                </tr>
                                <tr>
                                    <th>Kamar</th>
                                    <td>{{ $selectedProof->bill->booking->room->name }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Total Tagihan</th>
                                    <td>Rp {{ number_format($selectedProof->bill->amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Bayar</th>
                                    <td><strong>Rp {{ number_format($selectedProof->amount, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ $selectedProof->payment_method }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Upload</th>
                                    <td>{{ $selectedProof->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @if($selectedProof->notes)
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $selectedProof->notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Bukti Transfer:</strong></label>
                                <div class="border p-2 text-center" style="min-height: 300px;">
                                    @if($selectedProof->proof_image_url)
                                        <img src="{{ Storage::url($selectedProof->proof_image_url) }}" 
                                             alt="Bukti Transfer" 
                                             class="img-fluid"
                                             style="max-height: 400px;">
                                    @else
                                        <div class="text-muted py-5">
                                            <i class="fas fa-image fa-3x"></i>
                                            <p class="mt-3">Tidak ada gambar</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($selectedProof->status == 'pending')
                    <hr>
                    <div class="form-group">
                        <label>Catatan Admin</label>
                        <textarea wire:model="admin_notes" rows="3" class="form-control @error('admin_notes') is-invalid @enderror" placeholder="Catatan untuk penyewa (opsional untuk approve, wajib untuk reject)"></textarea>
                        @error('admin_notes') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    @elseif($selectedProof->notes)
                    <hr>
                    <div class="alert alert-info">
                        <strong>Catatan Admin:</strong><br>
                        {{ $selectedProof->notes }}
                    </div>
                    @endif
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" wire:click="closeModal" class="btn btn-default">Tutup</button>
                    @if($selectedProof->status == 'pending')
                    <div>
                        <button type="button" wire:click="rejectProof" class="btn btn-danger" onclick="return confirm('Yakin menolak bukti pembayaran ini?')">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                        <button type="button" wire:click="approveProof" class="btn btn-success" onclick="return confirm('Yakin menyetujui bukti pembayaran ini?')">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
