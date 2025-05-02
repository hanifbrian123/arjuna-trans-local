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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number');
            $table->string('address');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('pickup_address');
            $table->string('destination');
            $table->text('route');
            $table->integer('vehicle_count')->default(1);
            $table->string('vehicle_type');
            $table->string('driver_name');
            $table->decimal('rental_price', 10, 2);
            $table->decimal('down_payment', 10, 2)->nullable();
            $table->decimal('remaining_cost', 10, 2)->nullable();
            $table->enum('status', ['waiting', 'approved', 'canceled'])->default('waiting')->nullable();
            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
