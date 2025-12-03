@php
    $header = 'Bayar Tagihan';
@endphp

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Tagihan</h3>
                </div>
                <div class="card-body">
                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Search -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari kode tagihan...">
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Tagihan</th>
                                    <th>Jumlah</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bills as $bill)
                                <tr>
                                    <td>{{ $bill->bill_code }}</td>
                                    <td>Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                                    <td>{{ $bill->due_date ? date('d/m/Y', strtotime($bill->due_date)) : '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $bill->status === 'dibayar' ? 'success' : ($bill->status === 'verifikasi_tertunda' ? 'warning' : 'danger') }}">
                                            {{ ucfirst(str_replace('_', ' ', $bill->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($bill->status === 'belum_dibayar' && $bill->booking_id)
                                        <a href="{{ route('penyewa.payment', ['bookingId' => $bill->booking_id]) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-money-bill-wave"></i> Bayar
                                        </a>
                                        @elseif($bill->status === 'menunggu_verifikasi')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Menunggu Verifikasi
                                        </span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada tagihan.</td>
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
