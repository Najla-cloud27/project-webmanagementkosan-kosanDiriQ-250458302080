<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'booking_code',
        'duration_in_months',
        'total_price',
        'selesai_booking',
        'planned_check_in_date',
        'status',
        'notes',
    ];

    /**
     * Booking ini dibuat oleh satu user.
     * Relasi: bookings (∞) --- (1) users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Booking ini untuk satu room tertentu.
     * Relasi: bookings (∞) --- (1) rooms
     */
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    /**
     * Booking memiliki satu bill (tagihan).
     * Relasi: bookings (1) --- (1) bills
     */
    public function bill()
    {
        return $this->hasOne(Bills::class, 'booking_id');
    }
}