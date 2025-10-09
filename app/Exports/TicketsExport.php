<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TicketsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Ticket::with('user')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No. Tiket',
            'Tanggal',
            'Jam',
            'Nama Karyawan',
            'Company',
            'Branch',
            'Kota Cabang',
            'Kategori',
            'Sub Kategori',
            'Aplikasi',
            'Info Kendala',
            'Tipe Tiket',
            'Tipe Komplain',
            'Status',
            'Pengecekan',
            'Root Cause',
            'Solving',
            'PIC Merchant',
            'Jabatan Merchant',
            'Nama Helpdesk',
            'Created At',
            'Updated At'
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->tanggal ? $ticket->tanggal->format('d/m/Y') : '-',
            $ticket->jam ? \Carbon\Carbon::parse($ticket->jam)->format('H:i') : '-',
            $ticket->user->name ?? '-',
            $ticket->company,
            $ticket->branch,
            $ticket->kota_cabang,
            $ticket->category,
            $ticket->sub_category,
            $ticket->application,
            $ticket->info_kendala,
            $ticket->ticket_type,
            $ticket->complaint_type,
            $ticket->status,
            $ticket->pengecekan,
            $ticket->root_cause ?? '-',
            $ticket->solving ?? '-',
            $ticket->pic_merchant ?? '-',
            $ticket->jabatan ?? '-',
            $ticket->nama_helpdesk ?? '-',
            $ticket->created_at->format('d/m/Y H:i'),
            $ticket->updated_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text with background color
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ]
            ],
            // Style for all cells
            'A:Z' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    'wrapText' => true
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Tickets Report';
    }
}
