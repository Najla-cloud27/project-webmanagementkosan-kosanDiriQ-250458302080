@php
    $header = 'Manajemen Keluhan';
@endphp

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Keluhan</h3>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari judul atau nama penyewa...">
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

                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Penyewa</th>
                                    <th>Kamar</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $complaint->user->name ?? '-' }}</td>
                                    <td>{{ $complaint->room->name ?? '-' }}</td>
                                    <td>{{ $complaint->title }}</td>
                                    <td>
                                        <span class="badge badge-{{ $complaint->status === 'resolved' ? 'success' : ($complaint->status === 'in_progress' ? 'warning' : ($complaint->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button wire:click="selectComplaint({{ $complaint->id }})" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateModal">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada keluhan.</td>
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
</div>    <!-- Update Modal -->
    @if($selectedComplaint)
    <div class="modal fade" id="updateModal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Status Keluhan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form wire:submit.prevent="updateStatus">
                    <div class="modal-body">
                        <p><strong>Penyewa:</strong> {{ $selectedComplaint->user->name }}</p>
                        <p><strong>Judul:</strong> {{ $selectedComplaint->title }}</p>
                        <p><strong>Deskripsi:</strong> {{ $selectedComplaint->description }}</p>
                        
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model="newStatus" class="form-control" required>
                                <option value="pending">Pending</option>
                                <option value="in_progress">Sedang Diproses</option>
                                <option value="resolved">Selesai</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
