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
        Schema::create('transaction_payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_periode_pay');
            $table->unsignedBigInteger('id_employe');
            $table->unsignedBigInteger('id_trans_operational_kasbon')->nullable();

            $table->bigInteger('payroll')->nullable();
            $table->bigInteger('another_piece')->nullable();
            $table->string('desc_payroll')->nullable();
            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('id_periode_pay')
                ->references('id')
                ->on('payroll_period')
                ->onDelete('cascade');

            $table->foreign('id_employe')
                ->references('id')
                ->on('employess')
                ->onUpdate('cascade');

            $table->foreign('id_trans_operational_kasbon')
                ->references('id')
                ->on('transaction_oprational')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_payroll');
    }
};
