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
        Schema::create('app_banners', function (Blueprint $table) {
            $table->id();
            $table->string("app_owner_name")->nullable();
            $table->string("title")->nullable();
            $table->string("type_priority")->nullable();
            $table->string("image_or_video")->nullable();
            $table->string("status")->nullable();
            $table->string("zone_id")->nullable();
            $table->string("banner_type")->nullable();
            $table->string("store_id")->nullable();
            $table->string("voucher_id")->nullable();
            $table->string("category_id")->nullable();
            $table->string("voucher_type")->nullable();
            $table->string("external_lnk")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_banners');
    }
};
