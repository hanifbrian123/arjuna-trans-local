<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('description')->nullable();
            $table->decimal('nominal', 15, 2);

            // FK: expense_category_id
            $table->unsignedBigInteger('expense_category_id')->nullable();
            $table->foreign('expense_category_id')
                ->references('id')
                ->on('expense_categories')
                ->nullOnDelete();

            // FK: vehicle_id
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
