<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
    ];

    // Notifikasi ini milik satu user.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}