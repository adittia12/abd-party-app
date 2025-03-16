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
        Schema::table('transaction_oprational', function (Blueprint $table) {
            $table->text('description')->nullable()->after('expend');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_oprational', function (Blueprint $table) {
            // Batalkan perubahan jika migrasi di-rollback
            $table->dropColumn('description');
        });
    }
};
