<?php

namespace App\Livewire\Penyewa;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Bookings;
use App\Models\Bills;
use App\Models\PaymentProofs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PaymentDetail extends Component
{
    use WithFileUploads;

    public $booking;
    public $bill;
    public $payment_proof;
    public $payment_method;
    public $notes;

    protected $rules = [
        'payment_proof' => 'required|image|max:2048',
        'payment_method' => 'required|string',
        'notes' => 'nullable|string|max:500',
    ];

    public function mount($bookingId)
    {
        $this->booking = Bookings::with('room', 'user')
            ->where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Create bill if not exists
        $this->bill = Bills::firstOrCreate(
            [
                'booking_id' => $this->booking->id,
            ],
            [
                'user_id' => Auth::id(),
                'bill_code' => 'BILL-' . time() . rand(1000, 9999),
                'amount' => $this->booking->total_price,
                'due_date' => Carbon::now()->addDays(3),
                'status' => 'belum_dibayar',
                'description' => 'Pembayaran booking kamar ' . $this->booking->room->name,
            ]
        );
    }

    public function uploadPaymentProof()
    {
        $this->validate();

        // Store payment proof image
        $path = $this->payment_proof->store('payment-proofs', 'public');

        // Create payment proof record
        PaymentProofs::create([
            'bill_id' => $this->bill->id,
            'user_id' => Auth::id(),
            'payment_code' => 'PAY-' . time() . rand(1000, 9999),
            'amount' => $this->bill->amount,
            'proof_image_url' => $path,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
            'status' => 'pending',
        ]);

        // Update bill status
        $this->bill->update([
            'status' => 'menunggu_verifikasi',
        ]);

        // Update booking status
        $this->booking->update([
            'status' => 'menunggu_verifikasi',
        ]);

        session()->flash('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
        return redirect()->route('penyewa.bookings.index');
    }

    public function render()
    {
        // Check if payment proof already exists
        $existingProof = PaymentProofs::where('bill_id', $this->bill->id)->first();

        return view('livewire.penyewa.payment-detail', [
            'existingProof' => $existingProof,
        ]);
    }
}
