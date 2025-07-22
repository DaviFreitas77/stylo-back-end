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
        Schema::create('product_variacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fkProduto');
            $table->unsignedInteger('fkColor');
            $table->unsignedInteger('fkSize');
            $table->integer('stock');

            $table->foreign('fkProduto')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('fkColor')->references('id')->on('colors')->onDelete('restrict');
            $table->foreign('fkSize')->references('id')->on('sizes')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procuct_variacoes');
    }
};
