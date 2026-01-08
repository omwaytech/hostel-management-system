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
        Schema::create('news_and_blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hostel_id')->nullable();
            $table->string('nb_title')->nullable();
            $table->mediumText('nb_image')->nullable();
            $table->string('nb_badge')->nullable();
            $table->string('nb_time_to_read')->nullable();
            $table->text('nb_description')->nullable();
            $table->string('nb_author_name')->nullable();
            $table->mediumText('nb_author_image')->nullable();

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
        Schema::dropIfExists('news_and_blogs');
    }
};
