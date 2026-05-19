<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop and recreate invoices table with full schema
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // INV-2026-0001
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(15); // %
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('currency', 10)->default('SAR');
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
