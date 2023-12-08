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
        Schema::create('faktur', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->integer('pelanggan_id')->unsigned();
            $table->date('tanggal');
            $table->date('batas_waktu')->nullable();
            $table->string('referensi')->nullable();
            $table->text('syarat_dan_ketentuan');
            $table->double('sub_total');
            $table->double('diskon')->default(0);
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faktur');
    }
};
