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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('floor_id')->nullable();
            $table->bigInteger('occupancy_id')->nullable();
            $table->string('room_number')->nullable();
            $table->string('room_type')->nullable();
            $table->mediumText('photo')->nullable();
            $table->boolean('has_attached_bathroom')->nullable();
            $table->string('room_size')->nullable();
            $table->string('room_window_number')->nullable();
            $table->json('room_inclusions')->nullable();
            $table->json('room_amenities')->nullable();

            $table->string('slug')->nullable();

            $table->string('page_title')->nullable();
            $table->json('meta_tags')->nullable();
            $table->text('meta_description')->nullable();

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
        Schema::dropIfExists('rooms');
    }
};
