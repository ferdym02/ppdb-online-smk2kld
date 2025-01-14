<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_pendaftaran',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat', //tampilkan
        'asal_sekolah',
        'nisn',
        'jenis_kelamin',
        'nama_ayah',
        'nama_ibu',
        'nomor_wa',
        'prestasi_akademik',
        'prestasi_non_akademik',
        'kartu_keluarga',
        'ktp_orang_tua',
        'akte_kelahiran',
        'ijazah',
        'foto_calon_siswa',
        'raport',
        'piagam',
        'surat_keterangan',
        'status_pendaftaran', //tampilkan
        'tanggal_tes', //tampilkan jika ada
        'catatan_penolakan', //tampilkan jika ada
        'nilai_tes_minat_bakat', //tampilkan jika ada
        'status_tes', //tampilkan
        'nilai_mtk_semester_1', 'nilai_ipa_semester_1', 'nilai_bahasa_indonesia_semester_1', 'nilai_bahasa_inggris_semester_1', //tampilkan
        'nilai_mtk_semester_2', 'nilai_ipa_semester_2', 'nilai_bahasa_indonesia_semester_2', 'nilai_bahasa_inggris_semester_2', //tampilkan
        'nilai_mtk_semester_3', 'nilai_ipa_semester_3', 'nilai_bahasa_indonesia_semester_3', 'nilai_bahasa_inggris_semester_3', //tampilkan
        'nilai_mtk_semester_4', 'nilai_ipa_semester_4', 'nilai_bahasa_indonesia_semester_4', 'nilai_bahasa_inggris_semester_4', //tampilkan
        'nilai_mtk_semester_5', 'nilai_ipa_semester_5', 'nilai_bahasa_indonesia_semester_5', 'nilai_bahasa_inggris_semester_5', //tampilkan
        'periode_id',
        'aptitude_tests_id',
        'jurusan_diterima', //tampilkan jika ada
        'nilai_akhir', //tampilkan jika ada
        'daftar_ulang',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nomor_pendaftaran)) {
                // Inisialisasi nomor pendaftaran sementara hanya jika belum ada nilai
                $model->nomor_pendaftaran = 'TEMP';
            }
        });

        // static::created(function ($model) {
        //     // Update nomor pendaftaran setelah pilihan jurusan disimpan
        //     $jurusan1 = $model->pilihanJurusan1();
        //     if ($jurusan1) {
        //         $model->nomor_pendaftaran = Pendaftar::generateNomorPendaftaran($jurusan1->kode);
        //         $model->save();
        //     }
        // });
    }

    public static function generateNomorPendaftaran($kodeJurusan, $excludeId = null)
    {
        $lastPendaftar = Pendaftar::where('id', '!=', $excludeId)
            ->whereHas('jurusans', function ($query) use ($kodeJurusan) {
                $query->where('jurusans.kode', $kodeJurusan)
                    ->where('pendaftar_jurusan.urutan_pilihan', 1);
            })
            ->orderBy('nomor_pendaftaran', 'desc')
            ->first();

        $lastNumber = $lastPendaftar ? (int) substr($lastPendaftar->nomor_pendaftaran, -3) : 0;
        $nextNumber = $lastNumber + 1;
        // dd($kodeJurusan . str_pad($nextNumber, 3, '0', STR_PAD_LEFT));
        return $kodeJurusan . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * The jurusan that belong to the pendaftar.
     */
    public function jurusans()
    {
        return $this->belongsToMany(Jurusan::class, 'pendaftar_jurusan')
                    ->withPivot('urutan_pilihan')
                    ->orderBy('urutan_pilihan');
    }

    public function jurusanDiterima()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_diterima');
    }

    public function pilihanJurusan1()
    {
        return $this->jurusans()->wherePivot('urutan_pilihan', 1)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the status of the pendaftar to verified.
     */
    public function verify()
    {
        $this->status_pendaftaran = 'verified';
        $this->save();
    }

    /**
     * Set the status of the pendaftar to rejected and add a rejection note.
     */
    public function reject($note)
    {
        $this->status_pendaftaran = 'rejected';
        $this->catatan_penolakan = $note;
        $this->save();
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function aptitudeTest()
    {
        return $this->belongsTo(AptitudeTest::class, 'aptitude_tests_id');
    }

}
