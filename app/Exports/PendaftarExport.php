<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Pendaftar::query();

        if (isset($this->filters['jurusan'])) {
            $query->where('jurusan_id', $this->filters['jurusan']);
        }
        if (isset($this->filters['status_pendaftaran'])) {
            $query->where('status_pendaftaran', $this->filters['status_pendaftaran']);
        }
        if (isset($this->filters['status_tes'])) {
            $query->where('status_tes', $this->filters['status_tes']);
        }
        if (isset($this->filters['tanggal_awal']) && isset($this->filters['tanggal_akhir'])) {
            $query->whereBetween('tanggal_pendaftaran', [$this->filters['tanggal_awal'], $this->filters['tanggal_akhir']]);
        }

        // Ambil data pendaftar dan tambahkan nomor urut
        $data = $query->orderBy('nama_lengkap')->get([
            'nomor_pendaftaran',
            'nisn',
            'nama_lengkap',
            'jenis_kelamin',
            'asal_sekolah',
            'status_pendaftaran',
        ]);

        // Tambahkan nomor urut
        $dataWithNumbers = $data->map(function ($item, $index) {
            return [
                'No' => $index + 1, // Nomor urut
                'Nomor Pendaftaran' => $item->nomor_pendaftaran,
                'NISN' => $item->nisn,
                'Nama Lengkap' => $item->nama_lengkap,
                'Jenis Kelamin' => $item->jenis_kelamin,
                'Asal Sekolah' => $item->asal_sekolah,
                'Status Pendaftaran' => $item->status_pendaftaran,
            ];
        });

        return collect($dataWithNumbers);
    }

    public function headings(): array
    {
        return [
            'No', // Tambahkan kolom untuk nomor
            'Nomor Pendaftaran',
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Asal Sekolah',
            'Status Pendaftaran',
        ];
    }
}
