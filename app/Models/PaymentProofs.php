<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paymentproofs extends Model
{
    protected $table = 'payment_proofs';
    
    protected $fillable = [
        'user_id',
        'bill_id',
        'proof_image_url',
        'payment_method',
        'amount',
        'payment_code',
        'notes',
        'status',
        'verified_at',
    ];

    /**
     * Bukti pembayaran ini dikirim oleh satu user.
     * Relasi: payment_proofs  (1) users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Bukti pembayaran ini untuk satu bill.
     * Relasi: payment_proofs  (1) bills
     */
    public function bill()
    {
        return $this->belongsTo(Bills::class, 'bill_id');
    }
}