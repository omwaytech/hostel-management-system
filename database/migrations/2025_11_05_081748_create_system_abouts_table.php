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
        Schema::create('system_abouts', function (Blueprint $table) {
            $table->id();
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->text('about_mission')->nullable();
            $table->text('about_vision')->nullable();

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
        Schema::dropIfExists('system_abouts');
    }
};
