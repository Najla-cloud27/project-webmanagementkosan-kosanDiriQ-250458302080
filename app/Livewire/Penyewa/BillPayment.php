<?php

namespace App\Livewire\Penyewa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bills;
use Illuminate\Support\Facades\Auth;

class BillPayment extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $bills = Bills::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('bill_code', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.penyewa.bill-payment', compact('bills'));
    }
}
