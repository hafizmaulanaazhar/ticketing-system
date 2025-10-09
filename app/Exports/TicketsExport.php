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
            'Tipe Tiket',
            'Tipe Komplain',
            'Tanggal',
            'Jam',
            'Nama Karyawan',
            'Source',
            'Company',
            'Branch',
            'Kota Cabang',
            'Priority',
            'Application/Hardware',
            'Category',
            'Sub Category',
            'Status QRIS',
            'Info Kendala',
            'Pengecekan',
            'Root Cause',
            'Solving',
            'Assigned To',
            'PIC Merchant',
            'Jabatan',
            'Nama Helpdesk',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->ticket_type,
            $ticket->complaint_type,
            $ticket->tanggal ? $ticket->tanggal->format('d/m/Y') : '-',
            $ticket->jam ? \Carbon\Carbon::parse($ticket->jam)->format('H:i') : '-',
            $ticket->user->name ?? '-',
            $ticket->source,
            $ticket->company,
            $ticket->branch,
            $ticket->kota_cabang,
            $ticket->priority,
            $ticket->application,
            $ticket->category,
            $ticket->sub_category,
            $ticket->status_qris,
            $ticket->info_kendala,
            $ticket->pengecekan ?? '-',
            $ticket->root_cause ?? '-',
            $ticket->solving ?? '-',
            $ticket->assigned,
            $ticket->pic_merchant,
            $ticket->jabatan,
            $ticket->nama_helpdesk,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths for better readability
        $sheet->getColumnDimension('A')->setWidth(15); // No. Tiket
        $sheet->getColumnDimension('B')->setWidth(12); // Tipe Tiket
        $sheet->getColumnDimension('C')->setWidth(15); // Tipe Komplain
        $sheet->getColumnDimension('D')->setWidth(12); // Tanggal
        $sheet->getColumnDimension('E')->setWidth(10); // Jam
        $sheet->getColumnDimension('F')->setWidth(20); // Nama Karyawan
        $sheet->getColumnDimension('G')->setWidth(15); // Source
        $sheet->getColumnDimension('H')->setWidth(20); // Company
        $sheet->getColumnDimension('I')->setWidth(20); // Branch
        $sheet->getColumnDimension('J')->setWidth(15); // Kota Cabang
        $sheet->getColumnDimension('K')->setWidth(15); // Priority
        $sheet->getColumnDimension('L')->setWidth(20); // Application/Hardware
        $sheet->getColumnDimension('M')->setWidth(15); // Category
        $sheet->getColumnDimension('N')->setWidth(20); // Sub Category
        $sheet->getColumnDimension('O')->setWidth(15); // Status QRIS
        $sheet->getColumnDimension('P')->setWidth(30); // Info Kendala
        $sheet->getColumnDimension('Q')->setWidth(30); // Pengecekan
        $sheet->getColumnDimension('R')->setWidth(30); // Root Cause
        $sheet->getColumnDimension('S')->setWidth(30); // Solving
        $sheet->getColumnDimension('T')->setWidth(15); // Assigned To
        $sheet->getColumnDimension('U')->setWidth(12); // Tipe Tiket
        $sheet->getColumnDimension('V')->setWidth(15); // Tipe Komplain
        $sheet->getColumnDimension('W')->setWidth(20); // PIC Merchant
        $sheet->getColumnDimension('X')->setWidth(15); // Jabatan
        $sheet->getColumnDimension('Y')->setWidth(20); // Nama Helpdesk

        return [
            // Style the first row as bold text with background color
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ]
            ],
            // Style for all cells
            'A:Z' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    'wrapText' => true
                ],
                'font' => [
                    'size' => 10
                ]
            ],
            // Style for data rows
            'A2:Z1000' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    'wrapText' => true
                ]
            ],
        ];
    }

    public function title(): string
    {
        $start = Carbon::parse($this->startDate)->format('d-m-Y');
        $end = Carbon::parse($this->endDate)->format('d-m-Y');
        return "Tickets {$start} to {$end}";
    }
}
