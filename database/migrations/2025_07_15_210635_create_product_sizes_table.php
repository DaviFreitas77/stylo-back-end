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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fkProduct');
            $table->unsignedInteger('fkSize');

            $table->foreign('fkProduct')->references('id')->on('products')->onDelete('CASCADE');
            $table->foreign('fkSize')->references('id')->on('sizes')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
