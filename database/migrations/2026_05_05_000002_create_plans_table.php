<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                         // Basic, Pro, Enterprise
            $table->string('slug')->unique();               // basic, pro, enterprise
            $table->string('stripe_monthly_price_id')->nullable();
            $table->string('stripe_yearly_price_id')->nullable();
            $table->decimal('price_monthly', 10, 2)->default(0);
            $table->decimal('price_yearly', 10, 2)->default(0);
            $table->json('features')->nullable();           // JSON array of feature strings
            $table->integer('max_projects')->default(5);
            $table->integer('max_clients')->default(10);
            $table->integer('max_invoices')->default(20);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // Highlight on pricing page
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
