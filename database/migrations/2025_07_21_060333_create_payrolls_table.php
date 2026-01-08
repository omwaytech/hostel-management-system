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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('staff_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('pay_date')->nullable();
            $table->string('month')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('total')->nullable();
            $table->integer('total_earning')->nullable();
            $table->integer('total_deduction')->nullable();
            $table->string('generated_by')->nullable();

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
        Schema::dropIfExists('payrolls');
    }
};
