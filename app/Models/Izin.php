<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    // protected $table
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tgl_izin',
        'image',
        'keterangan',
        'alasan',
        'status',
    ];

    /**
     * Get the user that owns the Izin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get the user that owns the Izin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
