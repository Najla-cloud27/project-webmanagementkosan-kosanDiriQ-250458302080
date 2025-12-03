<?php

namespace App\Exports;

use App\Models\Rooms;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RoomsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Rooms::orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Kamar',
            'Deskripsi',
            'Harga/Bulan',
            'Fasilitas',
            'Status',
            'Tanggal Dibuat',
        ];
    }

    public function map($room): array
    {
        return [
            $room->name,
            $room->description ?? '-',
            'Rp ' . number_format($room->price, 0, ',', '.'),
            $room->facilities ?? '-',
            ucfirst($room->status),
            date('d/m/Y', strtotime($room->created_at)),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
