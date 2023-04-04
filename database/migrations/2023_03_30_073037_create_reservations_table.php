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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_package_id')->constrained('tour_packages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('date');
            $table->unsignedInteger('price');
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedTinyInteger('discount')->default(0)->max(100);
            $table->string('payment_evidence')->nullable();
            $table->datetime('payment_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'canceled', 'finished'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
