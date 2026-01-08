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
        Schema::create('property_lists', function (Blueprint $table) {
            $table->id();
            $table->string('hostel_name')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('hostel_email')->nullable();
            $table->string('hostel_contact')->nullable();
            $table->string('hostel_city')->nullable();
            $table->string('hostel_location')->nullable();

            $table->string('is_approved')->default(0);

            $table->string('slug')->nullable();

            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_lists');
    }
};
