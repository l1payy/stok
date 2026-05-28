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

        // Medicine Data
       $medicines = [
    // Obat-obatan Dana JKN 2023
    ['nama_obat' => 'Antasida tablet kunyah', 'satuan' => 'tablet', 'harga_satuan' => 500, 'sumber_obat' => 'JKN', 'stok_sekarang' => 100, 'stok_minimum' => 50, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'MgSO4 20%', 'satuan' => 'vial', 'harga_satuan' => 15000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 20, 'stok_minimum' => 5, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Propiltiourasil 100 mg', 'satuan' => 'tablet', 'harga_satuan' => 1200, 'sumber_obat' => 'JKN', 'stok_sekarang' => 50, 'stok_minimum' => 10, 'tanggal_kadaluarsa' => '2027-05-30'],

    // Obat-obatan Dana DAK 2023
    ['nama_obat' => 'Antasida tablet kunyah (DAK)', 'satuan' => 'tablet', 'harga_satuan' => 500, 'sumber_obat' => 'APBD', 'stok_sekarang' => 100, 'stok_minimum' => 50, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Asam Askorbat (Vitamin C) 50 mg', 'satuan' => 'tablet', 'harga_satuan' => 300, 'sumber_obat' => 'APBD', 'stok_sekarang' => 200, 'stok_minimum' => 50, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Deksametason 0,5 mg', 'satuan' => 'tablet', 'harga_satuan' => 400, 'sumber_obat' => 'APBD', 'stok_sekarang' => 150, 'stok_minimum' => 50, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Hidrokortison', 'satuan' => 'tube', 'harga_satuan' => 5000, 'sumber_obat' => 'APBD', 'stok_sekarang' => 30, 'stok_minimum' => 10, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Kolefion 20 mg', 'satuan' => 'tablet', 'harga_satuan' => 2000, 'sumber_obat' => 'APBD', 'stok_sekarang' => 100, 'stok_minimum' => 20, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Paracetamol 500 mg', 'satuan' => 'tablet', 'harga_satuan' => 600, 'sumber_obat' => 'APBD', 'stok_sekarang' => 500, 'stok_minimum' => 100, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Ranifin Inj', 'satuan' => 'vial', 'harga_satuan' => 12000, 'sumber_obat' => 'APBD', 'stok_sekarang' => 50, 'stok_minimum' => 10, 'tanggal_kadaluarsa' => '2027-05-30'],

    // General List
    ['nama_obat' => 'Acetyl cysteine', 'satuan' => 'kapsul', 'harga_satuan' => 1500, 'sumber_obat' => 'JKN', 'stok_sekarang' => 100, 'stok_minimum' => 20, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Air untuk injeksi', 'satuan' => 'vial', 'harga_satuan' => 3000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 50, 'stok_minimum' => 10, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Albendazol susp 200mg/5 ml', 'satuan' => 'botol', 'harga_satuan' => 8000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 30, 'stok_minimum' => 5, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Albendazol tablet 400 mg', 'satuan' => 'tablet', 'harga_satuan' => 2000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 100, 'stok_minimum' => 20, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Allopurinol tab 100 mg', 'satuan' => 'tablet', 'harga_satuan' => 800, 'sumber_obat' => 'JKN', 'stok_sekarang' => 200, 'stok_minimum' => 50, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Aminofilin inj 24 mg/ml', 'satuan' => 'ampul', 'harga_satuan' => 10000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 20, 'stok_minimum' => 5, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Amitriptilin tab sal 25 mg', 'satuan' => 'tablet', 'harga_satuan' => 700, 'sumber_obat' => 'JKN', 'stok_sekarang' => 100, 'stok_minimum' => 20, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Amlodipin 10 mg', 'satuan' => 'tablet', 'harga_satuan' => 1200, 'sumber_obat' => 'JKN', 'stok_sekarang' => 300, 'stok_minimum' => 50, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Amlodipin 5 mg', 'satuan' => 'tablet', 'harga_satuan' => 800, 'sumber_obat' => 'JKN', 'stok_sekarang' => 500, 'stok_minimum' => 100, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Amoksilin 500 mg', 'satuan' => 'tablet', 'harga_satuan' => 1000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 1000, 'stok_minimum' => 200, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Amoksisilin syr kering', 'satuan' => 'botol', 'harga_satuan' => 6000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 50, 'stok_minimum' => 10, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Anastetik lokal gigi', 'satuan' => 'vial', 'harga_satuan' => 25000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 10, 'stok_minimum' => 2, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Antasida Doen', 'satuan' => 'tablet', 'harga_satuan' => 400, 'sumber_obat' => 'JKN', 'stok_sekarang' => 500, 'stok_minimum' => 100, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Antasida Doen syr', 'satuan' => 'botol', 'harga_satuan' => 5000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 50, 'stok_minimum' => 10, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Antifungi salep', 'satuan' => 'tube', 'harga_satuan' => 4000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 40, 'stok_minimum' => 10, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Antihemoroid', 'satuan' => 'tablet', 'harga_satuan' => 3000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 60, 'stok_minimum' => 10, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Apetic drops 100 mg/ml', 'satuan' => 'botol', 'harga_satuan' => 15000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 20, 'stok_minimum' => 5, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Asam askorbat 50 mg', 'satuan' => 'tablet', 'harga_satuan' => 300, 'sumber_obat' => 'JKN', 'stok_sekarang' => 200, 'stok_minimum' => 50, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Asam Mefenamat 500 mg', 'satuan' => 'tablet', 'harga_satuan' => 1200, 'sumber_obat' => 'JKN', 'stok_sekarang' => 400, 'stok_minimum' => 100, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Asiklovir tab 400 mg', 'satuan' => 'tablet', 'harga_satuan' => 1500, 'sumber_obat' => 'JKN', 'stok_sekarang' => 100, 'stok_minimum' => 20, 'tanggal_kadaluarsa' => '2027-05-30'],
    ['nama_obat' => 'Asiklovir tab 200 mg', 'satuan' => 'tablet', 'harga_satuan' => 1000, 'sumber_obat' => 'JKN', 'stok_sekarang' => 150, 'stok_minimum' => 20, 'tanggal_kadaluarsa' => '2027-05-30'],
];

        foreach ($medicines as $medicine) {
            $medicine['kode_obat'] = 'OBT-' . strtoupper(uniqid());
            Obat::create($medicine);
        }
    }
}
