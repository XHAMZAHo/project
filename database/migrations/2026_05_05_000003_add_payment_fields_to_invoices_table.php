<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('stripe_session_id')->nullable()->after('paid_at');
            $table->string('stripe_payment_intent_id')->nullable()->after('stripe_session_id');
            $table->string('payment_method')->nullable()->after('stripe_payment_intent_id'); // card, bank_transfer, etc.
            $table->string('payment_gateway')->nullable()->default('stripe')->after('payment_method');
            // public pay token - allows client to pay without login
            $table->string('pay_token')->nullable()->unique()->after('payment_gateway');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_session_id',
                'stripe_payment_intent_id',
                'payment_method',
                'payment_gateway',
                'pay_token',
            ]);
        });
    }
};
