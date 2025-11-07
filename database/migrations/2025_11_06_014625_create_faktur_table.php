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
            $table->string('no_faktur')->primary();
            $table->dateTime('tgl_faktur');
            $table->dateTime('due_date');
            $table->string('metode_bayar');
            $table->integer('ppn');
            $table->integer('dp');
            $table->integer('grand_total');
            $table->string('user');
            $table->foreignId('id_customer')->constrained('customer', 'id_customer');
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan');
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
