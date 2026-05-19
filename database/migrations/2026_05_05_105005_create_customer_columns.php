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
        // Columns already added by 2026_05_05_000001_add_role_and_stripe_to_users_table
        // This migration is intentionally left as a no-op to avoid duplicate column errors.
    }

    public function down(): void
    {
        // Nothing to rollback — handled by our custom migration
    }
};
