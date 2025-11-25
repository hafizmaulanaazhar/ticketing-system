<?php

namespace App\Imports;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

class TicketsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $batchSize = 500; // jumlah baris per insert
        $insertData = [];

        foreach ($rows as $row) {

            // ======================
            // 1. Ambil ticket number
            // ======================
            $ticketNumber = preg_replace('/[^0-9]/', '', $row['no'] ?? '');
            if (!$ticketNumber) continue;

            // ======================
            // 2. Cek duplikat
            // ======================
            if (Ticket::where('ticket_number', $ticketNumber)->exists()) continue;

            // ======================
            // 3. Mapping dan normalisasi
            // ======================

            // Aplikasi
            $appRaw = strtolower(trim($row['applicationshardware'] ?? ''));
            $applicationMap = [
                'mobile dashboard' => 'Aplikasi Mobile',
                'dashboard mobile' => 'Aplikasi Mobile',
                'aplikasi mobile dashboard' => 'Aplikasi Mobile',
                'mobile' => 'Aplikasi Mobile',
                'aplikasi mobile' => 'Aplikasi Mobile',
                'hardware' => 'Hardware',
                'aplikasi kasir' => 'Aplikasi Kasir',
                'kasir' => 'Aplikasi Kasir',
                'aplikasi web merchant' => 'Aplikasi Web Merchant',
                'aplikasi attendance' => 'Aplikasi Attendance',
                'aplikasi web internal' => 'Aplikasi Web Internal',
            ];
            $application = $applicationMap[$appRaw] ?? 'Aplikasi Mobile';

            // Ticket type
            $ticketRaw = strtolower(trim($row['tickets'] ?? ''));
            $ticketType = in_array($ticketRaw, ['open', 'close']) ? ucfirst($ticketRaw) : 'Close';

            // Complaint type
            $complaintRaw = strtolower(trim($row['complaint'] ?? ''));
            $complaintTypeMap = [
                'normal' => 'Normal',
                'hard' => 'Hard',
                'hardcase' => 'Hard',
                'hard case' => 'Hard',
                'close' => 'Normal',
                'closed' => 'Normal',
                'open' => 'Normal',
                'ticket close' => 'Normal',
            ];
            $complaintType = $complaintTypeMap[$complaintRaw] ?? 'Normal';

            // Status QRIS
            $statusRaw = strtolower(trim($row['status_qris'] ?? ''));
            $statusQrisMap = [
                'sukses' => 'Sukses',
                'success' => 'Sukses',
                'pending' => 'Pending/Expired',
                'expired' => 'Pending/Expired',
                'pending/expired' => 'Pending/Expired',
                'gagal' => 'Gagal',
                'failed' => 'Gagal',
                'none' => 'None',
                '-' => 'None',
            ];
            $statusQris = $statusQrisMap[$statusRaw] ?? 'None';

            // Priority
            $priorityRaw = strtolower(trim($row['priority'] ?? ''));
            $priorityMap = [
                'premium' => 'Premium',
                'full service' => 'Full Service',
                'lainnya' => 'Lainnya',
                'corporate' => 'Corporate',
            ];
            $priority = $priorityMap[$priorityRaw] ?? 'Lainnya';

            // Assigned
            $assignedRaw = strtolower(trim($row['assigned'] ?? ''));
            $assignedMap = [
                'helpdesk' => 'Helpdesk',
                'development' => 'Development',
                'marketing' => 'Marketing',
                'team support' => 'Team Support',
                'ts' => 'Team Support',
                'gudang' => 'Gudang',
                'team pac' => 'Team PAC',
            ];
            $assigned = $assignedMap[$assignedRaw] ?? 'Helpdesk';

            // Tanggal dan Jam
            $tanggal = null;
            if (!empty($row['date_open'])) {
                try {
                    $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_open'])
                        ->format('Y-m-d');
                } catch (\Exception $e) {
                    try {
                        $tanggal = Carbon::createFromFormat('d/m/Y', $row['date_open'])->format('Y-m-d');
                    } catch (\Exception $e2) {
                        $tanggal = null;
                    }
                }
            }
            $jam = !empty($row['jam'])
                ? Carbon::createFromTimestampUTC($row['jam'] * 86400)->format('H:i:s')
                : null;

            // Category & Subcategory
            $category = $row['categories'] ?? 'Assistances';
            $subCategory = $row['subcategory'] ?? '-';

            // ======================
            // 4. Tambahkan ke batch
            // ======================
            $insertData[] = [
                'user_id'        => auth()->id(),
                'ticket_number'  => $ticketNumber,
                'ticket_type'    => $ticketType,
                'complaint_type' => $complaintType,
                'jam'            => $jam,
                'tanggal'        => $tanggal,
                'source'         => $row['source'] ?? 'Help Desk',
                'company'        => $row['company'] ?? '-',
                'branch'         => $row['branch'] ?? '-',
                'kota_cabang'    => $row['kota_cabang'] ?? '-',
                'priority'       => $priority,
                'application'    => $application,
                'category'       => $category,
                'sub_category'   => $subCategory,
                'status_qris'    => $statusQris,
                'info_kendala'   => $row['info_kendala'] ?? '-',
                'pengecekan'     => $row['pengecekan'] ?? null,
                'root_cause'     => $row['rootcause'] ?? null,
                'solving'        => $row['solving'] ?? null,
                'assigned'       => $assigned,
                'pic_merchant'   => $row['pic_merchant'] ?? '-',
                'jabatan'        => $row['jabatan'] ?? '-',
                'nama_helpdesk'  => $row['help_desk'] ?? '-',
                'status'         => 'close',
                'created_at'     => now(),
                'updated_at'     => now(),
            ];

            if (count($insertData) >= $batchSize) {
                Ticket::insert($insertData);
                $insertData = [];
            }
        }

        // Insert sisa data
        if (!empty($insertData)) {
            Ticket::insert($insertData);
        }
    }

    public function chunkSize(): int
    {
        return 500; // baca 500 baris per chunk
    }
}
