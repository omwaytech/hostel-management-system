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
        Schema::create('hostel_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hostel_id')->nullable();
            $table->mediumText('image')->nullable();
            $table->string('caption')->nullable();
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
        Schema::dropIfExists('hostel_images');
    }
};
