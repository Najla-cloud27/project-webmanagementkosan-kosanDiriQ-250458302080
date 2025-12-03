@php
    $header = 'Keluhan Saya';
@endphp

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Keluhan</h3>
                    <div class="card-tools">
                        <a href="{{ route('penyewa.complaints.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Buat Keluhan Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari keluhan...">
                        </div>
                        <div class="col-md-3">
                            <select wire:model.live="statusFilter" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">Sedang Diproses</option>
                                <option value="resolved">Selesai</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Judul</th>
                                    <th>Kamar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $complaint->title }}</td>
                                    <td>{{ $complaint->room->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $complaint->status === 'resolved' ? 'success' : ($complaint->status === 'in_progress' ? 'warning' : ($complaint->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal{{ $complaint->id }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada keluhan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $complaints->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
