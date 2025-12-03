@php
    $header = 'Booking Saya';
@endphp

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Booking</h3>
                </div>
                <div class="card-body">
                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari kode booking...">
                        </div>
                        <div class="col-md-6">
                            <select wire:model.live="statusFilter" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="pembayaran_tertunda">Pembayaran Tertunda</option>
                                <option value="dikonfirmasi">Dikonfirmasi</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Kamar</th>
                                    <th>Durasi</th>
                                    <th>Check-in</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->booking_code }}</td>
                                    <td>{{ $booking->room->name ?? '-' }}</td>
                                    <td>{{ $booking->duration_in_months }} bulan</td>
                                    <td>{{ $booking->planned_check_in_date ? date('d/m/Y', strtotime($booking->planned_check_in_date)) : '-' }}</td>
                                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status === 'dikonfirmasi' ? 'success' : ($booking->status === 'pembayaran_tertunda' ? 'warning' : ($booking->status === 'dibatalkan' ? 'danger' : 'info')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($booking->status === 'pembayaran_tertunda')
                                        <a href="{{ route('penyewa.payment', ['bookingId' => $booking->id]) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-money-bill-wave"></i> Bayar
                                        </a>
                                        <button wire:click="cancelBooking({{ $booking->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan booking?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada booking.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
