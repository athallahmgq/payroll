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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'tanpa keterangan'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->unique(['karyawan_id', 'tanggal']); // Karyawan hanya bisa absen sekali sehari
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
