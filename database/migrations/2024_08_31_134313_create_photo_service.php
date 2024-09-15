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
        Schema::create('photo_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_service');
            $table->string('name_photo');
            $table->timestamps();

            $table->foreign('id_service')->references('id')->onDelete('cascade')->onUpdate('cascade')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_service');
    }
};
