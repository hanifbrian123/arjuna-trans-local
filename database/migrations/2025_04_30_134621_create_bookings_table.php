<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('pickup_location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('dropoff_location_id')->constrained('locations')->onDelete('cascade');
            $table->dateTime('booking_date');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('passenger_count');
            $table->enum('status', ['pending', 'confirmed', 'ongoing', 'completed', 'cancelled', 'no-show']);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'partially_refunded']);
            $table->text('cancellation_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
