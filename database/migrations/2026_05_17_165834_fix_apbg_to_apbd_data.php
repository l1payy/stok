<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update 'obat' table
        DB::table('obat')->where('sumber_obat', 'APBG')->update(['sumber_obat' => 'APBD']);
        
        // Update 'transaksi_masuk' table
        DB::table('transaksi_masuk')->where('sumber_obat', 'APBG')->update(['sumber_obat' => 'APBD']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this as APBG was a typo
    }
};
