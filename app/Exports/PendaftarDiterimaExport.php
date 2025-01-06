<?php

namespace App\Exports;

use App\Models\Pendaftar;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarDiterimaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $pendaftar = Pendaftar::whereIn('status_pendaftaran', ['diterima', 'cadangan'])
            ->with('jurusanDiterima') // Load data jurusan
            ->orderBy('jurusan_diterima')
            ->orderBy('nilai_akhir', 'desc')
            ->get();

        // Map data untuk menambahkan nomor urut dan nama jurusan
        $dataWithNumbers = $pendaftar->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Nomor Pendaftaran' => $item->nomor_pendaftaran,
                'NISN' => $item->nisn,
                'Nama Lengkap' => $item->nama_lengkap,
                'Jenis Kelamin' => $item->jenis_kelamin,
                'Asal Sekolah' => $item->asal_sekolah,
                'Jurusan Diterima' => $item->jurusanDiterima ? $item->jurusanDiterima->nama : '-', // Tampilkan nama jurusan
                'Nilai Akhir' => $item->nilai_akhir,
            ];
        });

        return collect($dataWithNumbers);
    }

    public function headings(): array
    {
        return [
            'No',                     // Menambahkan heading untuk nomor
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
