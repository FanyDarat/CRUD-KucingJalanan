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
        Schema::create('kucings', function (Blueprint $table) {
            $table->bigInteger("id_kucing", 1)->primary();
            $table->bigInteger("id_user")->nullable();
            $table->string("name");
            $table->string("warna");
            $table->string("rating");
            $table->string("imageUrl");
            $table->timestamps();
        
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kucings');
    }
};
