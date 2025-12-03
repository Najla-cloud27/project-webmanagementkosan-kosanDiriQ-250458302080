@php
    $header = 'Pengumuman';
@endphp

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengumuman</h3>
                </div>
                <div class="card-body">
                    @forelse($announcements as $announcement)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $announcement->title }}</h5>
                            <p class="text-muted"><small>{{ $announcement->created_at->diffForHumans() }}</small></p>
                            @if($announcement->image_url)
                            <img src="{{ Storage::url($announcement->image_url) }}" class="img-fluid mb-3" alt="Announcement Image">
                            @endif
                            <p class="card-text">{{ $announcement->content }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center">Tidak ada pengumuman.</p>
                    @endforelse

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $announcements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
