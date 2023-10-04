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
        Schema::create('vehicels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nomor_plat');
            $table->string('tahun')->nullable();
            $table->string('model_kendaraan')->nullable();
            $table->string('vendor_kendaraan');
            $table->string('brand_kendaraan');
            $table->date('expire_tax');
            $table->date('expire_plat');
            $table->date('expire_kit');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
