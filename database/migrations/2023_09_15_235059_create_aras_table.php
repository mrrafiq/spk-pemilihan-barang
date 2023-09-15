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
        Schema::create('aras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('rank');
            $table->double('utility_point', 8,2);
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('barang_id')->references('id')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aras');
    }
};
