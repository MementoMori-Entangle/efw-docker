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
        Schema::create('fabric_images', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('physics_name')->nullable();
            $table->string('logic_name')->nullable();
            $table->string('json_name')->nullable();
            $table->string('svg_name')->nullable();
            $table->boolean('del_flg')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fabric_images');
    }
};
