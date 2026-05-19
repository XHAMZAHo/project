<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('features_ar')->nullable(); // JSON
            $table->text('features_en')->nullable(); // JSON
            $table->string('icon')->default('fas fa-cogs');
            $table->string('color')->default('#1a56f0');
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('price_max', 10, 2)->nullable();
            $table->string('price_type')->default('fixed'); // fixed, range, custom
            $table->string('delivery_days')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
