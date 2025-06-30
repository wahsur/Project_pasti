<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('kodeAset')->unique();
            $table->string('namaAset')->nullable();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->integer('jumlah');
            $table->integer('unit_tersedia')->default(0);
            $table->string('ruangan');
            $table->enum('status', ['aktif', 'rusak', 'maintenance'])->default('aktif');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // path foto
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
