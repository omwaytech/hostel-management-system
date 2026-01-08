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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hostel_id')->nullable();
            $table->string('person_name')->nullable();
            $table->mediumText('person_image')->nullable();
            $table->string('person_address')->nullable();
            $table->string('rating')->nullable();
            $table->text('person_statement')->nullable();
            $table->string('is_helpful')->nullable();

            $table->string('slug')->nullable();

            $table->string('page_title')->nullable();
            $table->json('meta_tags')->nullable();
            $table->text('meta_description')->nullable();

            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
