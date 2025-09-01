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
       Schema::create('segments', function (Blueprint $table) {
            $table->id(); // segment_id
            $table->string('name'); // segment_name
            $table->string('type')->nullable();
            $table->string('validation_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps(); // created_at & updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segments');
    }
};
