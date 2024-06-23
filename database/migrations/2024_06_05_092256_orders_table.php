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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable(true)->unique();
            $table->date('tgl_order')->nullable();
            $table->string('company_type')->nullable();
            $table->string('name_customer')->nullable();
            $table->unsignedBigInteger('no_phone')->nullable();
            $table->string('invoice_address')->nullable();
            $table->string('delivery_address')->nullable();
            $table->integer('initial_terms')->nullable();
            $table->enum('jenis_term', ['Hours', 'Days', 'Weeks', 'Months'])->nullable();
            $table->date('start_event')->nullable();
            $table->date('end_event')->nullable();
            $table->date('date_pasang')->nullable();
            $table->string('warehouse')->nullable();
            $table->string('price_list')->nullable();
            $table->date('close_date')->nullable();
            $table->integer('discount_rate')->nullable();
            $table->integer('dp')->nullable();
            $table->string('status_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
