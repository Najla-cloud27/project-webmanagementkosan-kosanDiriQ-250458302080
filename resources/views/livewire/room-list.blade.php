<div>
        <!-- Filter Section -->
        <div class="filter-card">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Cari Kamar</label>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Nama kamar...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Harga Min</label>
                    <input type="number" wire:model.live="minPrice" class="form-control" placeholder="0">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Harga Max</label>
                    <input type="number" wire:model.live="maxPrice" class="form-control" placeholder="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select wire:model.live="statusFilter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="terisi">Terisi</option>
                        <option value="perawatan">Perawatan</option>
                        <option value="sudah_dipesan">Sudah Dipesan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">&nbsp;</label>
                    <button wire:click="resetFilters" class="btn btn-secondary w-100">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Room Cards -->
        <div class="row">
            @forelse($rooms as $room)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="room-card">
                    <!-- Room Image -->
                    <div class="room-image">
                        @if($room->main_image_url)
                            <img src="{{ Storage::url($room->main_image_url) }}" alt="{{ $room->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-door-open fa-4x text-primary"></i>
                        @endif
                    </div>
                    
                    <!-- Room Details -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $room->name }}</h5>
                        <p class="card-text">{{ Str::limit($room->description, 100) }}</p>
                        
                        <!-- Room Info -->
                        <div class="room-info">
                            @if($room->size)
                            <div class="room-info-item">
                                <i class="fas fa-ruler-combined text-primary me-2"></i>
                                <span>{{ $room->size }}</span>
                            </div>
                            @endif
                            
                            @if($room->fasilitas)
                            <div class="room-info-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>{{ Str::limit($room->fasilitas, 60) }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Price and Status -->
                        <div class="price-status-wrapper">
                            <span class="price-badge">Rp {{ number_format($room->price, 0, ',', '.') }}/bln</span>
                            <span class="status-badge bg-{{ $room->status === 'tersedia' ? 'success' : 'secondary' }}">
                                @if($room->status === 'tersedia')
                                    Tersedia
                                @elseif($room->status === 'terisi')
                                    Terisi
                                @elseif($room->status === 'perawatan')
                                    Perawatan
                                @else
                                    Dipesan
                                @endif
                            </span>
                        </div>
                        
                        @if($room->stok > 0)
                            <div class="stok-info">
                                <i class="fas fa-warehouse me-1"></i> Stok: {{ $room->stok }} unit
                            </div>
                        @endif
                        
                        <!-- Action Button -->
                        @if($room->status === 'tersedia' && $room->stok > 0)
                            @auth
                                <a href="{{ route('rooms.book', $room->id) }}" class="btn-book">
                                    <i class="fas fa-calendar-check me-2"></i>Booking Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-book">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login untuk Booking
                                </a>
                            @endauth
                        @else
                            <button class="btn-book" disabled>
                                <i class="fas fa-times-circle me-2"></i>Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak ada kamar yang sesuai dengan pencarian</h4>
                    <p class="text-muted">Coba ubah filter pencarian Anda</p>
                    <button wire:click="resetFilters" class="btn btn-primary mt-3">
                        <i class="fas fa-redo me-2"></i>Reset Filter
                    </button>
                </div>
            </div>
            @endforelse
        </div>

    <!-- Pagination -->
    @if($rooms->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $rooms->links() }}
    </div>
    @endif
</div>
