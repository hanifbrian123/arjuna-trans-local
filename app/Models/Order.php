<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_num',
        'name',
        'phone_number',
        'address',
        'start_date',
        'end_date',
        'pickup_address',
        'destination',
        'route',
        'vehicle_count',
        'vehicle_type',
        'driver_name',
        'rental_price',
        'down_payment',
        'remaining_cost',
        'status',
        'additional_notes',
        'user_id',
        'driver_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'order_driver');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
