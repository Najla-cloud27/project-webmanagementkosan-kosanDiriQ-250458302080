<?php

namespace App\Exports;

use App\Models\Bills;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BillsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $dateFrom;
    protected $dateTo;
    protected $status;

    public function __construct($dateFrom = null, $dateTo = null, $status = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->status = $status;
    }

    public function collection()
    {
        return Bills::with(['user', 'booking'])
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Tagihan',
            'Nama Penyewa',
            'Kode Booking',
            'Total Tagihan',
            'Tanggal Jatuh Tempo',
            'Tanggal Pembayaran',
            'Status',
            'Metode Pembayaran',
            'Tanggal Dibuat',
        ];
    }

    public function map($bill): array
    {
        return [
            $bill->bill_code,
            $bill->user->name ?? '-',
            $bill->booking->booking_code ?? '-',
            'Rp ' . number_format($bill->amount, 0, ',', '.'),
            $bill->due_date ? date('d/m/Y', strtotime($bill->due_date)) : '-',
            $bill->payment_date ? date('d/m/Y', strtotime($bill->payment_date)) : '-',
            ucfirst(str_replace('_', ' ', $bill->status)),
            $bill->payment_method ?? '-',
            date('d/m/Y H:i', strtotime($bill->created_at)),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
