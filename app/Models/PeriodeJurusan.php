<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeJurusan extends Model
{
    use HasFactory;

    protected $table = 'periode_jurusan';

    protected $fillable = ['jurusan_id', 'periode_id', 'kuota'];

    // Relasi ke model Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    // Relasi ke model Periode
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}
