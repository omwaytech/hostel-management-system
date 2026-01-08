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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('block_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('role')->nullable();
            $table->string('contact_number')->nullable();
            $table->mediumText('photo')->nullable();
            $table->mediumText('citizenship')->nullable();
            $table->date('join_date')->nullable();
            $table->date('leave_date')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->integer('basic_salary')->nullable();
            $table->integer('income_tax')->nullable();
            $table->integer('cit')->nullable();
            $table->integer('ssf')->nullable();

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
        Schema::dropIfExists('staff');
    }
};
