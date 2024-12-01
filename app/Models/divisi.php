<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class divisi extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'divisi';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom-kolom yang dapat diisi
    protected $fillable = [
        'id_perusahaan',
        'nama_divisi',
        'gaji_pokok',
    ];

    /**
     * Relasi ke model `Perusahaan`
     * Satu divisi hanya memiliki satu perusahaan.
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }
}
