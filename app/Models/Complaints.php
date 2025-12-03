<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'title',
        'description',
        'image_url',
        'status',
    ];

    /**
     * Complaint ini dibuat oleh satu user.
     * Relasi: complaints  (1) users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Complaint ini terkait dengan satu room.
     * Relasi: complaints (1) rooms
     */
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }
}