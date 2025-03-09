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
        Schema::create('operational_money', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_opartional')->nullable();
            $table->string('name_operational')->nullable();
            $table->bigInteger('budget')->nullable();
            $table->string('time_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operational_money');
    }
};
