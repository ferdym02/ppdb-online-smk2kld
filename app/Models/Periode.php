<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_pelajaran', 'tanggal_buka', 'tanggal_tutup', 'status', 'kuota_penerimaan',
    ];

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class);
    }

    public function aptitudeTests()
    {
        return $this->hasMany(AptitudeTest::class);
    }

    public function jurusans()
    {
        return $this->hasMany(Jurusan::class);
    }

    public static function checkActivePeriod()
    {
        return self::where('status', 1)->exists();
    }

    // Relasi ke tabel periode_jurusan
    public function periodeJurusans()
    {
        return $this->hasMany(PeriodeJurusan::class, 'periode_id');
    }
}
