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
        Schema::create('oddo_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('kode_oddo');
            $table->integer('users_id');
            $table->integer('kendaraan_id');
            $table->string('areas_id');
            $table->integer('oddoOut_id');
            $table->integer('oddoIn_id');
            $table->string('safetyTools_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oddo_models');
    }
};
