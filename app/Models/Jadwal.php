<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'jadwal';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'payment_account',  // Changed from id_sumber_dana to payment_account
        'selected_date',
        'status',
    ];

    /**
     * Relasi ke model `SumberDana`
     * Satu jadwal terkait dengan satu sumber dana.
     */
    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class, 'payment_account', 'id');  // Foreign key to sumber_dana
    }

    /**
     * Relasi ke model `Transaksi`
     * Satu jadwal terkait dengan banyak transaksi.
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_jadwal');
    }
}
