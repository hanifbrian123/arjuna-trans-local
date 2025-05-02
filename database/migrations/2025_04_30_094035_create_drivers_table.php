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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('license_number')->unique();
            $table->date('license_expiry');
            $table->string('phone_number');
            $table->string('emergency_contact');
            $table->string('emergency_phone');
            $table->text('address');
            $table->date('birth_date');
            $table->integer('experience_years');
            $table->enum('health_status', ['excellent', 'good', 'fair', 'poor']);
            $table->enum('status', ['available', 'busy', 'off-duty', 'suspended']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
