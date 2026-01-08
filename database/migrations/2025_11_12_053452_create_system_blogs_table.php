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
        Schema::create('system_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('blog_title')->nullable();
            $table->mediumText('blog_image')->nullable();
            $table->string('blog_badge')->nullable();
            $table->string('blog_time_to_read')->nullable();
            $table->text('blog_description')->nullable();
            $table->string('blog_author_name')->nullable();
            $table->mediumText('blog_author_image')->nullable();

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
        Schema::dropIfExists('system_blogs');
    }
};
