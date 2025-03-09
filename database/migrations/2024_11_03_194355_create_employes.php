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
        Schema::create('employess', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_group');
            $table->string('code_employe');
            $table->string('name');
            $table->timestamps();

            $table->foreign('id_group')->references('id')->onDelete('cascade')->onUpdate('cascade')->on('groupss');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employess');
    }
};
