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
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bill_id')->nullable();
            $table->string('particular')->nullable();
            $table->string('unit_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('discount')->nullable();
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('bill_items');
    }
};
