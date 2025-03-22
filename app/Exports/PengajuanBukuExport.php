<?php

namespace App\Exports;

use App\Models\PengajuanBuku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengajuanBukuExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PengajuanBuku::all();
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nama Pengaju',
            'Tanggal Pengajuan',
            'Qty',
            'Status',
        ];
    }

    public function map($pengajuan): array
    {
        return [
            $pengajuan->id,
            $pengajuan->nama,
            $pengajuan->tgl,
            $pengajuan->qty,
            $pengajuan->status == 0 ? 'Proses' : 'Terpenuhi',
        ];
    }
}
