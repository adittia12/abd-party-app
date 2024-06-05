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
            $table->string('company_type')->nullable(false);
            $table->string('name_customer')->nullable(false);
            $table->integer('no_phone')->nullable(false);
            $table->string('invoice_address')->nullable(false);
            $table->string('delivery_address')->nullable(false);
            $table->integer('initial_terms')->nullable(false);
            $table->enum('jenis_term', ['Hours', 'Days', 'Weeks', 'Months'])->nullable(false);
            $table->date('start_event')->nullable(false);
            $table->date('end_event')->nullable(false);
            $table->date('date_pasang')->nullable(false);
            $table->string('warehouse')->nullable(false);
            $table->string('price_list')->nullable(false);
            $table->date('close_date')->nullable(false);
            $table->integer('discount_rate')->nullable(false);
            $table->integer('dp')->nullable(false);
            $table->string('status_order')->nullable(false);
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
