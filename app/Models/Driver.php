<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        'license_type',
        'status',
        'notes',
    ];

    protected $casts = [
        'license_type' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ordersManyToMany()
    {
        return $this->belongsToMany(Order::class, 'order_driver');
    }
}
