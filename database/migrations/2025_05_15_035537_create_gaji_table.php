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
    Schema::create('gaji', function (Blueprint $table) {
        $table->id();
        $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
        $table->tinyInteger('bulan');
        $table->year('tahun');
        $table->integer('total_hadir')->default(0);
        $table->integer('total_izin')->default(0);
        $table->integer('total_sakit')->default(0);
        $table->integer('total_tanpa_keterangan')->default(0);
        $table->decimal('gaji_pokok', 10, 2);
        $table->decimal('potongan', 10, 2)->default(0);
        $table->decimal('gaji_bersih', 10, 2);
        $table->text('keterangan')->nullable();
        $table->date('tanggal_pembayaran')->nullable();
        $table->timestamps();
        $table->unique(['karyawan_id', 'bulan', 'tahun']); // Satu record gaji per karyawan per periode
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};