<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->string('service_type');
            $table->string('budget')->nullable();
            $table->text('description');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->index('status');
            $table->index('service_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
