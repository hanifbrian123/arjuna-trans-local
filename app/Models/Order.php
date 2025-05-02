<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // $table->id();
    // $table->string('name');
    // $table->string('phone_number');
    // $table->string('address');
    // $table->dateTime('start_date');
    // $table->dateTime('end_date');
    // $table->string('pickup_address');
    // $table->string('destination');
    // $table->text('route');
    // $table->integer('vehicle_count')->default(1);
    // $table->string('vehicle_type');
    // $table->string('driver_name');
    // $table->decimal('rental_price', 10, 2);
    // $table->decimal('down_payment', 10, 2)->nullable();
    // $table->decimal('remaining_cost', 10, 2)->nullable();
    // $table->enum('status', ['waiting', 'approved', 'canceled'])->default('waiting')->nullable();
    // $table->text('additional_notes')->nullable();
    // $table->timestamps();
    protected $fillable = [
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
}
