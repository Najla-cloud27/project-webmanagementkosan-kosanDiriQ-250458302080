<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Bills;
use App\Models\Bookings;
use App\Models\Complaints;
use App\Models\Announcoments;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
   
    //  * The attributes that are mass assignable.
    //  *
    //  * @var list<string>
    //  */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'nik',
        'role',
        'avatar_url'
    ];

    /**
     * Get avatar URL (from database or generate)
     */
    public function getAvatarAttribute()
    {
        if (!empty($this->avatar_url)) {
            return asset('storage/' . $this->avatar_url);
        }
        
        return \App\Helpers\AvatarHelper::generate($this->name, 200);
    }

    // User membuat banyak booking.
    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'user_id');
    }

    /**
     * User memiliki banyak tagihan.
     * Relasi: users (1) --- (∞) bills
     */
    public function bills()
    {
        return $this->hasMany(Bills::class, 'user_id');
    }

    /**
     * User membuat banyak laporan/complaints.
     * Relasi: users (1) --- (∞) complaints
     */
    public function complaints()
    {
        return $this->hasMany(Complaints::class, 'user_id');
    }

    /**
     * User mengirim banyak bukti pembayaran.
     * Relasi: users (1) --- (∞) paymentproofs
     */
    public function paymentproofs()
    {
        return $this->hasMany(Paymentproofs::class, 'user_id');
    }

    /**
     * User menerima banyak notifications.
     * Relasi: users (1) --- (∞) notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notifications::class, 'user_id');
    }

    /**
     * User (khusus admin) dapat membuat banyak pengumuman.
     * Relasi: users (1) --- (∞) announcements
     */
    public function announcoments()
    {
        return $this->hasMany(Announcoments::class, 'user_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}