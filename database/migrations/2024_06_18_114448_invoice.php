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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('id_order');
            $table->string('invoice_number');
            $table->string('no_po_manual')->nullable();
            $table->date('period_date')->nullable();
            $table->timestamps();

            $table->foreign('id_order')->references('id')->onDelete('cascade')->onUpdate('cascade')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
