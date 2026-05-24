<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    protected $table = 'transaksi_masuk';

    protected $fillable = [
        'obat_id',
        'jumlah',
        'sumber_obat',
        'tanggal_kadaluarsa',
        'tanggal_masuk',
        'created_by',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
