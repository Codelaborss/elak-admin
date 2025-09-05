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
        Schema::create('usage_term_management', function (Blueprint $table) {
            $table->id();
            $table->string("term_type")->nullable();
            $table->string("term_title")->nullable();
            $table->string("term_dec")->nullable();
            $table->string("voucher_type")->nullable();
            $table->string("management_type")->nullable();
            $table->string("customer_message")->nullable();
            $table->string("display_title")->nullable();
            $table->string("days")->nullable();
            $table->string("min_purchase_account")->nullable();
            $table->string("condition_is_not_met")->nullable();
            $table->string("message_when_condition_not_meet")->nullable();
            $table->string("status")->default("active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usage_term_management');
    }
};
