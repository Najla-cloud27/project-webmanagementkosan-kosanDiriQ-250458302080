<?php

namespace App\Livewire\Penyewa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Complaints;
use Illuminate\Support\Facades\Auth;

class ComplaintList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $complaints = Complaints::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->with(['room'])
            ->latest()
            ->paginate(10);

        return view('livewire.penyewa.complaint-list', compact('complaints'));
    }
}
