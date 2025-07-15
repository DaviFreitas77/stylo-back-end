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
        Schema::create('product_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fkProduct');
            $table->unsignedInteger('fkColor');
            
            $table->foreign('fkColor')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('fkProduct')->references('id')->on('products')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
