<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'license_plate',
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
        return $this->belongsToMany(Order::class);
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expense_vehicle');
    }
}
