<?php

namespace App\Livewire\Penyewa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bookings;
use Illuminate\Support\Facades\Auth;

class BookingList extends Component
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

    public function cancelBooking($bookingId)
    {
        $booking = Bookings::where('user_id', Auth::id())->findOrFail($bookingId);
        
        if ($booking->status === 'pembayaran_tertunda') {
            $booking->update(['status' => 'dibatalkan']);
            $booking->room->update(['status' => 'available']);
            session()->flash('success', 'Booking berhasil dibatalkan.');
        } else {
            session()->flash('error', 'Booking tidak dapat dibatalkan.');
        }
    }

    public function render()
    {
        $bookings = Bookings::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('booking_code', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->with(['room'])
            ->latest()
            ->paginate(10);

        return view('livewire.penyewa.booking-list', compact('bookings'));
    }
}
