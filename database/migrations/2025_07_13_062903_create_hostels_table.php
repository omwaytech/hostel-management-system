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
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('name')->nullable();
            $table->mediumText('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('contact')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->string('type')->nullable();

            $table->string('slug')->nullable();

            $table->string('page_title')->nullable();
            $table->json('meta_tags')->nullable();
            $table->text('meta_description')->nullable();

            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('hostels');
    }
};
