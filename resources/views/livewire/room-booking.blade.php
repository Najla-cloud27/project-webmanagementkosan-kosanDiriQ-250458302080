<div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card booking-card">
                <div class="card-body p-4">
                        @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            {{ session('error') }}
                        </div>
                        @endif

                        <form wire:submit.prevent="bookRoom">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h5 class="mb-3"><i class="fas fa-door-open me-2 text-primary"></i>Detail Kamar</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Nama Kamar:</th>
                                            <td><strong>{{ $room->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Harga/Bulan:</th>
                                            <td><strong class="text-primary">Rp {{ number_format($room->price, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        @if($room->size)
                                        <tr>
                                            <th>Ukuran:</th>
                                            <td>{{ $room->size }}</td>
                                        </tr>
                                        @endif
                                        @if($room->description)
                                        <tr>
                                            <th>Deskripsi:</th>
                                            <td>{{ $room->description }}</td>
                                        </tr>
                                        @endif
                                        @if($room->fasilitas)
                                        <tr>
                                            <th>Fasilitas:</th>
                                            <td>{{ $room->fasilitas }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="mb-3"><i class="fas fa-calendar-check me-2 text-primary"></i>Detail Booking</h5>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tanggal Check-in <span class="text-danger">*</span></label>
                                        <input type="date" wire:model="planned_check_in_date" class="form-control @error('planned_check_in_date') is-invalid @enderror" required>
                                        @error('planned_check_in_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Durasi (bulan) <span class="text-danger">*</span></label>
                                        <input type="number" wire:model.live="duration_in_months" class="form-control @error('duration_in_months') is-invalid @enderror" min="1" max="12" required>
                                        @error('duration_in_months') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                                        <textarea wire:model="notes" class="form-control" rows="3" placeholder="Catatan tambahan untuk booking Anda"></textarea>
                                    </div>

                                    <div class="alert alert-info">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong>Total Harga:</strong>
                                            <h4 class="mb-0 text-primary">Rp {{ number_format($this->totalPrice, 0, ',', '.') }}</h4>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-2 mb-2">
                                        <i class="fas fa-check me-2"></i> Konfirmasi Booking
                                    </button>
                                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary w-100 py-2">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </a>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
