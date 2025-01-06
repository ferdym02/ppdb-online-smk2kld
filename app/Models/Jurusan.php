<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'periode_id',
    ];

    public function pendaftars()
    {
        return $this->belongsToMany(Pendaftar::class, 'pendaftar_jurusan')
                    ->withPivot('urutan_pilihan')
                    ->withTimestamps();
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function jurusanDiterima()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_diterima');
    }

    // Relasi ke tabel periode_jurusan
    public function periodeJurusans()
    {
        return $this->hasMany(PeriodeJurusan::class, 'jurusan_id');
    }

}
