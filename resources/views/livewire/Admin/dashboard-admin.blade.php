@php
    $header = 'Dashboard Admin';
@endphp

<div>
    <!-- Welcome Message -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-user-shield"></i> Selamat Datang, {{ auth()->user()->name }}!</h5>
                Anda login sebagai <strong>Administrator</strong>. Kelola semua aspek sistem kosan dari panel ini.
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Kamar -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_rooms'] }}</h3>
                    <p>Total Kamar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Kamar Tersedia: {{ $stats['available_rooms'] }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Penyewa -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['total_tenants'] }}</h3>
                    <p>Total Penyewa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Booking Aktif: {{ $stats['active_bookings'] }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Pendapatan Bulan Ini -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp {{ number_format($stats['monthly_income'], 0, ',', '.') }}</h3>
                    <p>Pendapatan Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="{{ route('admin.bills.index') }}" class="small-box-footer">
                    Lihat Tagihan <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Pembayaran Pending -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['pending_payments'] }}</h3>
                    <p>Pembayaran Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('admin.payment-proofs.index') }}" class="small-box-footer">
                    Verifikasi Sekarang <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Ringkasan Statistik
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header">{{ $stats['unpaid_bills'] }}</h5>
                                <span class="description-text">Tagihan Belum Dibayar</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $stats['active_complaints'] }}</h5>
                                <span class="description-text">Keluhan Aktif</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header">{{ $stats['available_rooms'] }}</h5>
                                <span class="description-text">Kamar Tersedia</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $stats['total_rooms'] - $stats['available_rooms'] }}</h5>
                                <span class="description-text">Kamar Terisi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-bell mr-1"></i>
                        Notifikasi Penting
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @if($stats['pending_payments'] > 0)
                        <li class="list-group-item">
                            <i class="fas fa-exclamation-circle text-warning mr-2"></i>
                            Ada {{ $stats['pending_payments'] }} pembayaran menunggu verifikasi
                            <a href="{{ route('admin.payment-proofs.index') }}" class="float-right">
                                <small>Verifikasi →</small>
                            </a>
                        </li>
                        @endif
                        
                        @if($stats['active_complaints'] > 0)
                        <li class="list-group-item">
                            <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                            Ada {{ $stats['active_complaints'] }} keluhan yang perlu ditangani
                            <a href="{{ route('admin.complaints.index') }}" class="float-right">
                                <small>Lihat →</small>
                            </a>
                        </li>
                        @endif
                        
                        @if($stats['unpaid_bills'] > 0)
                        <li class="list-group-item">
                            <i class="fas fa-file-invoice text-info mr-2"></i>
                            Ada {{ $stats['unpaid_bills'] }} tagihan belum dibayar
                            <a href="{{ route('admin.bills.index') }}" class="float-right">
                                <small>Lihat →</small>
                            </a>
                        </li>
                        @endif
                        
                        @if($stats['pending_payments'] == 0 && $stats['active_complaints'] == 0 && $stats['unpaid_bills'] == 0)
                        <li class="list-group-item text-center text-muted">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Tidak ada notifikasi penting
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Payment Proofs -->
    @if($pendingPaymentProofs->count() > 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0 bg-warning">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Bukti Pembayaran Menunggu Verifikasi
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.payment-proofs.index') }}" class="btn btn-sm btn-tool">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Pembayaran</th>
                                    <th>Penyewa</th>
                                    <th>Kamar</th>
                                    <th>Jumlah</th>
                                    <th>Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingPaymentProofs as $proof)
                                <tr>
                                    <td><strong>{{ $proof->payment_code }}</strong></td>
                                    <td>{{ $proof->user->name }}</td>
                                    <td>{{ $proof->bill->booking->room->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($proof->amount, 0, ',', '.') }}</td>
                                    <td>{{ $proof->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.payment-proofs.index') }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-check-circle"></i> Verifikasi
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i>
                        Aktivitas Terbaru
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Tipe</th>
                                    <th>Detail</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestBookings->take(3) as $booking)
                                <tr>
                                    <td><span class="badge badge-info">Booking</span></td>
                                    <td>{{ $booking->booking_code }} - {{ $booking->user->name }} - Status: {{ ucfirst($booking->status) }}</td>
                                    <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Tidak ada aktivitas terbaru</td>
                                </tr>
                                @endforelse
                                
                                @forelse($latestComplaints->take(2) as $complaint)
                                <tr>
                                    <td><span class="badge badge-warning">Keluhan</span></td>
                                    <td>{{ Str::limit($complaint->subject, 50) }}</td>
                                    <td>{{ $complaint->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>