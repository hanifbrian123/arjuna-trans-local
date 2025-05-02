<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Vehicle extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'type',
        'capacity',
        'license_plate',
        'year_of_manufacture',
        'status',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'fuel_type',
        'transmission',
        'insurance_expiry',
        'odometer',
    ];

    protected $casts = [
        'insurance_expiry' => 'date',
    ];

    public function features()
    {
        return $this->hasMany(VehicleFeature::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
