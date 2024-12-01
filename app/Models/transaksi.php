<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'transaksi';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_jadwal',         // Foreign key to jadwal
        'id_pekerja',        // Foreign key to pekerja (worker)
        'id_payment_account',    // Foreign key to sumberDana (payment source)
        'tgl_byr',           // Payment date
        'wkt_byr',           // Payment time
        'nominal',           // Transaction amount
        'status',            // Status of the transaction (e.g., 'completed')
    ];

    /**
     * Relasi ke model `Jadwal`
     * Banyak transaksi terkait dengan satu jadwal.
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal');
    }

    /**
     * Relasi ke model `Pekerja`
     * Banyak transaksi terkait dengan satu pekerja.
     */
    public function pekerja()
    {
        return $this->belongsTo(Pekerja::class, 'id_pekerja');
    }

    public function sumberDana()
    {
        return $this->belongsTo(sumberdana::class, 'id_payment_account');  // Adjust foreign key if needed
    }
}
