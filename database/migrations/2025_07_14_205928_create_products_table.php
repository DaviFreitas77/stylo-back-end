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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("description");
            $table->decimal("price",10,2);
            $table->decimal("lastPrice",10,2);
            $table->unsignedInteger('fkCategory');
            $table->string('image');
            $table->boolean('news');

            $table->foreign('fkCategory')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
