<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'license_number',
        'license_expiry',
        'phone_number',
        'emergency_contact',
        'emergency_phone',
        'address',
        'birth_date',
        'experience_years',
        'health_status',
        'status',
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
