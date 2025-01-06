<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AptitudeTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_id',
        'tanggal_buka_tes',
        'tanggal_tutup_tes',
        'kuota_per_hari',
        'status',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
