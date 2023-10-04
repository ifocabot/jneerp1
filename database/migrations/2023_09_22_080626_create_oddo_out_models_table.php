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
        Schema::create('oddoOut', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('oddo_meter_out');
            $table->string('foto_oddo_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oddo_out_models');
    }
};
