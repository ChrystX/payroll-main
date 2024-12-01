<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sumberdana extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'sumber_dana';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_perusahaan',
        'accountname',
        'no_rekening',
        'saldo',
    ];

    /**
     * Relasi ke model `Perusahaan`
     * Satu sumber dana terkait dengan satu perusahaan.
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }

}
