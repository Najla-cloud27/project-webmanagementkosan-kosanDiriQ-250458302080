<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug',
        'price',
        'size',
        'status',
        'fasilitas',
        'stok',
        'main_image_url',
        'icon_svg',
    ];

    // Relasi ke Bookings
    public function bookings()
    {
        return $this->hasMany(Bookings::class);
    }

    // Relasi ke RoomImages
    public function roomImages()
    {
        return $this->hasMany(RoomImage::class);
    }

    // Relasi ke Complaints
    public function complaints()
    {
        return $this->hasMany(Complaints::class);
    }
}