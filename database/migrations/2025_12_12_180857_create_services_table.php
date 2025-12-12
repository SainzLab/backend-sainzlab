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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // Untuk URL ramah SEO
            $table->string('category'); // Hosting, VPS, Website, Mobile Apps
            $table->text('description');
            $table->string('price_label'); // Contoh: "Rp 15.000/bln" atau "Custom"
            $table->string('image')->nullable(); // Upload gambar
            $table->string('icon_class')->nullable(); // Jika pakai Lucide icon string
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
