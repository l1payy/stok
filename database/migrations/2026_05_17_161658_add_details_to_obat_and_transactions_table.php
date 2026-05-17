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
        Schema::table('obat', function (Blueprint $table) {
            $table->decimal('harga_satuan', 15, 2)->default(0)->after('satuan');
            $table->string('sumber_obat')->nullable()->after('harga_satuan');
            $table->date('tanggal_kadaluarsa')->nullable()->after('sumber_obat');
        });

        Schema::table('transaksi_masuk', function (Blueprint $table) {
            $table->string('sumber_obat')->nullable()->after('jumlah');
            $table->date('tanggal_kadaluarsa')->nullable()->after('sumber_obat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropColumn(['harga_satuan', 'sumber_obat', 'tanggal_kadaluarsa']);
        });

        Schema::table('transaksi_masuk', function (Blueprint $table) {
            $table->dropColumn(['sumber_obat', 'tanggal_kadaluarsa']);
        });
    }
};
