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
        Schema::create('bonu_limit_settings', function (Blueprint $table) {
            $table->id();
            $table->string("category")->nullable();
            $table->string("multi_level_bonus_configuration")->nullable();
            $table->string("min_gift_ard")->nullable();
            $table->string("max_gift_ard")->nullable();
            $table->string("status")->default("active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonu_limit_settings');
    }
};
