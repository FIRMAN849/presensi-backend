<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    // protected $table
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'jenis_absen',
        'tgl_absen',
        'status'
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
}
