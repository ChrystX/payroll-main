<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pekerja extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pekerja';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom-kolom yang dapat diisi
    protected $fillable = [
        'id_divisi',
        'nama_pekerja',
        'nama_bank',
        'rekening_pekerja',
    ];

    /**
     * Relasi ke model `Divisi`
     * Satu pekerja hanya terkait dengan satu divisi.
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi', 'id');
    }
}
