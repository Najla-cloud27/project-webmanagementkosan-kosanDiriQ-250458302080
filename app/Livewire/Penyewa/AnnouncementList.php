<?php

namespace App\Livewire\Penyewa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Announcoments;

class AnnouncementList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $announcements = Announcoments::where('publish_status', 'published')
            ->latest()
            ->paginate(5);

        return view('livewire.penyewa.announcement-list', compact('announcements'));
    }
}
