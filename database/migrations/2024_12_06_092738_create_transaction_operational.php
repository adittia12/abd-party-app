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
        Schema::create('transaction_oprational', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_operational');
            $table->unsignedBigInteger('id_employe');
            $table->integer('expend')->nullable();
            $table->date('tgl_periode');
            $table->timestamps();

            $table->foreign('id_operational')->references('id')->onDelete('cascade')->onUpdate('cascade')->on('operational_money');
            $table->foreign('id_employe')->references('id')->onDelete('cascade')->onUpdate('cascade')->on('employess');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_oprational');
    }
};
