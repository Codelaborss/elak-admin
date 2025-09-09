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
        Schema::create('work_management', function (Blueprint $table) {
            $table->id();
            $table->string("voucher_id")->nullable();
            $table->string("guid_title")->nullable();
            $table->string("purchase_process")->nullable();
            $table->string("payment_confirm")->nullable();
            $table->string("voucher_deliver")->nullable();
            $table->string("redemption_process")->nullable();
            $table->string("account_management")->nullable();
            $table->string("status")->default("active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_management');
    }
};
