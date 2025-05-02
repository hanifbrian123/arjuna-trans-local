<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'facilities',
        'status',
    ];

    protected $casts = [
        'facilities' => 'array',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
