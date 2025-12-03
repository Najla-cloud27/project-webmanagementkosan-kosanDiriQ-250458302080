@php
    $header = 'Riwayat Pembayaran';
@endphp

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Tagihan & Pembayaran</h3>
                </div>
                <div class="card-body">
                    <!-- Summary -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-box bg-success">
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Sudah Dibayar</span>
                                    <span class="info-box-number">Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-danger">
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Belum Dibayar</span>
                                    <span class="info-box-number">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari kode...">
                        </div>
                        <div class="col-md-3">
                            <select wire:model.live="statusFilter" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="belum_dibayar">Belum Dibayar</option>
                                <option value="verifikasi_tertunda">Verifikasi Tertunda</option>
                                <option value="dibayar">Dibayar</option>
                                <option value="terlambat">Terlambat</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" wire:model.live="dateFrom" class="form-control" placeholder="Dari Tanggal">
                        </div>
                        <div class="col-md-3">
                            <input type="date" wire:model.live="dateTo" class="form-control" placeholder="Sampai Tanggal">
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kode Tagihan</th>
                                    <th>Jumlah</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bills as $bill)
                                <tr>
                                    <td>{{ $bill->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $bill->bill_code }}</td>
                                    <td>Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                                    <td>{{ $bill->due_date ? date('d/m/Y', strtotime($bill->due_date)) : '-' }}</td>
                                    <td>
                                        @if($bill->status === 'dibayar')
                                            <span class="badge badge-success">Dibayar</span>
                                        @elseif($bill->status === 'menunggu_verifikasi')
                                            <span class="badge badge-warning">Menunggu Verifikasi</span>
                                        @elseif($bill->status === 'overdue')
                                            <span class="badge badge-danger">Overdue</span>
                                        @else
                                            <span class="badge badge-secondary">Belum Dibayar</span>
                                        @endif
                                    </td>
                                    <td>{{ $bill->payment_date ? date('d/m/Y', strtotime($bill->payment_date)) : '-' }}</td>
                                    <td>
                                        @if($bill->status === 'belum_dibayar' && $bill->booking_id)
                                        <a href="{{ route('penyewa.payment', ['bookingId' => $bill->booking_id]) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-money-bill-wave"></i> Bayar
                                        </a>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $bills->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
