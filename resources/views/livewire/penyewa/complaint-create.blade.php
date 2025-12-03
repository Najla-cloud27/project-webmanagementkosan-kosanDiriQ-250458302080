@php
    $header = 'Buat Keluhan';
@endphp

<div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporkan Keluhan</h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="form-group">
                            <label>Kamar <span class="text-danger">*</span></label>
                            <select wire:model="room_id" class="form-control @error('room_id') is-invalid @enderror" required>
                                <option value="">Pilih Kamar</option>
                                @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                            @error('room_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Judul Keluhan <span class="text-danger">*</span></label>
                            <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi <span class="text-danger">*</span></label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="5" required></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Foto (Opsional)</label>
                            <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-height: 200px;">
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Keluhan
                            </button>
                            <a href="{{ route('penyewa.complaints.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
