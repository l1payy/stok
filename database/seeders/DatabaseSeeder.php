<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Obat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin Puskesmas',
            'email' => 'admin@puskesmas.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Petugas Gudang User
        User::create([
            'name' => 'Petugas Gudang',
            'email' => 'petugas@puskesmas.com',
            'password' => Hash::make('password'),
            'role' => 'petugas_gudang',
        ]);

        // Medicine Data
        $medicines = [
            ['kode_obat' => 'OBT001', 'nama_obat' => 'Paracetamol 500mg', 'satuan' => 'tablet', 'stok_sekarang' => 120, 'stok_minimum' => 50],
            ['kode_obat' => 'OBT002', 'nama_obat' => 'Amoxicillin 500mg', 'satuan' => 'kapsul', 'stok_sekarang' => 15, 'stok_minimum' => 30],
            ['kode_obat' => 'OBT003', 'nama_obat' => 'Ibuprofen 400mg', 'satuan' => 'tablet', 'stok_sekarang' => 0, 'stok_minimum' => 20],
            ['kode_obat' => 'OBT004', 'nama_obat' => 'Cetirizine 10mg', 'satuan' => 'tablet', 'stok_sekarang' => 45, 'stok_minimum' => 20],
            ['kode_obat' => 'OBT005', 'nama_obat' => 'Antasida Doen', 'satuan' => 'tablet', 'stok_sekarang' => 80, 'stok_minimum' => 30],
            ['kode_obat' => 'OBT006', 'nama_obat' => 'OBH Syrup', 'satuan' => 'botol', 'stok_sekarang' => 5, 'stok_minimum' => 10],
            ['kode_obat' => 'OBT007', 'nama_obat' => 'Loperamide 2mg', 'satuan' => 'tablet', 'stok_sekarang' => 100, 'stok_minimum' => 40],
            ['kode_obat' => 'OBT008', 'nama_obat' => 'Omeprazole 20mg', 'satuan' => 'kapsul', 'stok_sekarang' => 25, 'stok_minimum' => 25],
            ['kode_obat' => 'OBT009', 'nama_obat' => 'Dexamethasone 0.5mg', 'satuan' => 'tablet', 'stok_sekarang' => 150, 'stok_minimum' => 50],
            ['kode_obat' => 'OBT010', 'nama_obat' => 'Salbutamol 2mg', 'satuan' => 'tablet', 'stok_sekarang' => 12, 'stok_minimum' => 20],
            ['kode_obat' => 'OBT011', 'nama_obat' => 'Amlodipine 5mg', 'satuan' => 'tablet', 'stok_sekarang' => 200, 'stok_minimum' => 50],
            ['kode_obat' => 'OBT012', 'nama_obat' => 'Metformin 500mg', 'satuan' => 'tablet', 'stok_sekarang' => 300, 'stok_minimum' => 100],
        ];

        foreach ($medicines as $medicine) {
            Obat::create($medicine);
        }
    }
}
