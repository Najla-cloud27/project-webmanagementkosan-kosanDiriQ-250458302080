@php
    $header = 'Dashboard Penyewa';
@endphp

<div>
    <!-- Welcome Message -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info-circle"></i> Selamat Datang, {{ auth()->user()->name }}!</h5>
                Anda login sebagai <strong>Penyewa</strong>. Gunakan menu di samping untuk mengakses fitur-fitur yang tersedia.
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['activeBookings'] }}</h3>
                    <p>Booking Aktif</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="{{ route('penyewa.bookings.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['unpaidBills'] }}</h3>
                    <p>Tagihan Belum Lunas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <a href="{{ route('penyewa.bills.index') }}" class="small-box-footer">
                    Bayar Sekarang <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pendingComplaints'] }}</h3>
                    <p>Keluhan Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <a href="{{ route('penyewa.complaints.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($stats['totalSpent'], 0, ',', '.') }}</h3>
                    <p>Total Pembayaran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="{{ route('penyewa.bills.history') }}" class="small-box-footer">
                    Lihat Riwayat <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Bills -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice mr-1"></i>
                        Tagihan Terbaru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('penyewa.bills.index') }}" class="btn btn-tool btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBills as $bill)
                                    <tr>
                                        <td><small>{{ $bill->bill_code }}</small></td>
                                        <td>{{ $bill->created_at->format('d M Y') }}</td>
                                        <td><strong>Rp {{ number_format($bill->amount, 0, ',', '.') }}</strong></td>
                                        <td>
                                            @if($bill->status === 'dibayar')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif($bill->status === 'verifikasi_tertunda')
                                                <span class="badge badge-warning">Verifikasi</span>
                                            @elseif($bill->status === 'terlambat')
                                                <span class="badge badge-danger">Terlambat</span>
                                            @else
                                                <span class="badge badge-secondary">Belum Dibayar</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Tidak ada tagihan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($recentBills) > 0)
                <div class="card-footer text-center">
                    <a href="{{ route('penyewa.bills.index') }}">Lihat Semua Tagihan</a>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-bullhorn mr-1"></i>
                        Pengumuman Terbaru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('penyewa.announcements.index') }}" class="btn btn-tool btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($recentAnnouncements as $announcement)
                        <div class="callout callout-info mb-2">
                            <h5><i class="fas fa-info-circle"></i> {{ $announcement->title }}</h5>
                            <p class="mb-1">{{ Str::limit($announcement->content, 100) }}</p>
                            <small class="text-muted">
                                <i class="far fa-clock"></i> {{ $announcement->created_at->diffForHumans() }}
                            </small>
                        </div>
                    @empty
                        <p class="text-center text-muted py-3">Tidak ada pengumuman</p>
                    @endforelse
                </div>
                @if(count($recentAnnouncements) > 0)
                <div class="card-footer text-center">
                    <a href="{{ route('penyewa.announcements.index') }}">Lihat Semua Pengumuman</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Complaints -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Keluhan Terbaru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('penyewa.complaints.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Buat Keluhan
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50%">Subjek</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentComplaints as $complaint)
                                    <tr>
                                        <td>{{ Str::limit($complaint->subject, 60) }}</td>
                                        <td>
                                            @if($complaint->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($complaint->status === 'in_progress')
                                                <span class="badge badge-info">Diproses</span>
                                            @else
                                                <span class="badge badge-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>{{ $complaint->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('penyewa.complaints.index') }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Tidak ada keluhan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($recentComplaints) > 0)
                <div class="card-footer text-center">
                    <a href="{{ route('penyewa.complaints.index') }}">Lihat Semua Keluhan</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
