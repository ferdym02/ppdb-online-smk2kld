<?php

namespace App\Exports;

use App\Models\Pendaftar;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarDiterimaExport implements FromCollection, WithHeadings
{
    protected $periodeId;

    public function __construct($periodeId)
    {
        $this->periodeId = $periodeId;
    }

    public function collection()
    {
        $pendaftar = Pendaftar::whereIn('status_pendaftaran', ['diterima', 'cadangan'])
            ->where('periode_id', $this->periodeId) // Filter berdasarkan periode yang dipilih
            ->with('jurusanDiterima')
            ->orderBy('jurusan_diterima')
            ->orderBy('nilai_akhir', 'desc')
            ->get();

        return $pendaftar->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Nomor Pendaftaran' => $item->nomor_pendaftaran,
                'NISN' => $item->nisn,
                'Nama Lengkap' => $item->nama_lengkap,
                'Jenis Kelamin' => $item->jenis_kelamin,
                'Asal Sekolah' => $item->asal_sekolah,
                'Jurusan Diterima' => $item->jurusanDiterima ? $item->jurusanDiterima->nama : '-',
                'Nilai Akhir' => $item->nilai_akhir,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Pendaftaran',
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Asal Sekolah',
            'Jurusan Diterima',
            'Nilai Akhir',
        ];
    }
}
