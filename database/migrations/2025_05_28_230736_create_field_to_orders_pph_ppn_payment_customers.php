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
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('pajak_pph')->nullable()->after('pajak');
            $table->bigInteger('pajak_ppn')->nullable()->after('pajak_pph');
            $table->string('descript_payment')->nullable()->after('pajak_ppn');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Batalkan perubahan jika migrasi di-rollback
            $table->dropColumn(['pajak_pph', 'pajak_ppn', 'descript_payment']);
        });
    }
};
