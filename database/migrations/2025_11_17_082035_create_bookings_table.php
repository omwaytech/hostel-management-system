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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->constrained('hostels')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');

            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('current_address')->nullable();

            $table->date('move_in_date')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('occupant_count')->nullable();
            $table->string('emergency_contact')->nullable();

            $table->text('dietary_preferences')->nullable();
            $table->text('additional_requests')->nullable();

            $table->enum('payment_method', ['cash_on_arrival', 'full_payment'])->nullable();
            $table->decimal('monthly_rent', 10, 2)->nullable();
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->nullable();

            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');

            $table->boolean('terms_accepted')->default(false);
            $table->boolean('privacy_accepted')->default(false);

            $table->string('slug')->nullable();

            $table->string('is_deleted')->default(0);

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
