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
        Schema::create('hostel_features', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hostel_id')->nullable();
            $table->string('feature_name')->nullable();
            $table->mediumText('feature_icon')->nullable();

            $table->string('slug')->nullable();

            $table->boolean('is_published')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostel_features');
    }
};
