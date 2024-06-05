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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_product');
            $table->string('description')->nullable();
            $table->integer('days');
            $table->integer('qty');
            $table->string('measure_list');
            $table->bigInteger('price');
            $table->timestamps();

            $table->foreign('id_order')->references('id')->onDelete('cascade')->onUpdate('cascade')->on('orders');
            $table->foreign('id_product')->references('id')->onDelete('cascade')->onUpdate('cascade')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
