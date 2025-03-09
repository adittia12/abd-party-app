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
            $table->unsignedBigInteger('id_list_budget')->nullable()->after('id_employe');

            $table->foreign('id_list_budget')->references('id')->onUpdate('cascade')->on('list_bugeting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_oprational', function (Blueprint $table) {
            // Batalkan perubahan jika migrasi di-rollback
            $table->dropColumn('id_list_budget');
        });
    }
};
