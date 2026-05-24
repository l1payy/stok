<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'satuan',
        'harga_satuan',
        'sumber_obat',
        'tanggal_kadaluarsa',
        'stok_sekarang',
        'stok_minimum',
    ];

    public function stokMasuk()
    {
        return $this->hasMany(StokMasuk::class, 'obat_id');
    }

    public function stokKeluar()
    {
        return $this->hasMany(StokKeluar::class, 'obat_id');
    }
}
