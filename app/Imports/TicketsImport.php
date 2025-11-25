<?php

namespace App\Imports;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TicketsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {

            // ======================
            // 1. VALIDASI WAJIB ADA
            // ======================

            $requiredFields = [
                'tickets',
                'complaint',
                'jam',
                'date_open',
                'source',
                'company',
                'branch',
                'kota_cabang',
                'priority',
                'applicationshardware',
                'categories',
                'subcategory',
                'status_qris',
                'info_kendala',
                'assigned',
                'jabatan',
                'help_desk',
            ];

            // foreach ($requiredFields as $field) {
            //     if (!isset($row[$field]) || $row[$field] === null || $row[$field] === '') {
            //         Log::error("Missing required field: $field", $row);
            //         return null;
            //     }
            // }

            // ======================
            // 2. NORMALISASI DATA
            // ======================

            // Tanggal Excel → Carbon
            $tanggal = null;

            if (isset($row['date_open']) && $row['date_open'] != '') {
                try {
                    // Coba konversi dari Excel numeric date
                    $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_open'])
                        ->format('Y-m-d');
                } catch (\Exception $e) {
                    // fallback untuk teks format dd/mm/yyyy
                    try {
                        $tanggal = Carbon::createFromFormat('d/m/Y', $row['date_open'])->format('Y-m-d');
                    } catch (\Exception $e2) {
                        $tanggal = null; // tetap null kalau gagal parse
                    }
                }
            }


            // Jam Excel (decimal) → "HH:MM:SS"
            $jam = isset($row['jam']) && $row['jam'] != ''
                ? Carbon::createFromTimestampUTC($row['jam'] * 86400)->format('H:i:s')
                : null;

            $ticketNumber = isset($row['no']) && $row['no'] != ''
                ? preg_replace('/[^0-9]/', '', $row['no'])
                : null;

            if (!$ticketNumber) {
                Log::warning("Missing ticket number, row skipped");
                return null; // skip row supaya tidak bikin nomor random
            }

            // ======================
            // 3. MAPPING ENUM
            // ======================

            // A. Fix Mapping Application
            $appRaw = strtolower(trim($row['applicationshardware']));

            $applicationMap = [
                'mobile dashboard'   => 'Aplikasi Mobile',
                'dashboard mobile'   => 'Aplikasi Mobile',
                'aplikasi mobile dashboard' => 'Aplikasi Mobile',
                'mobile'             => 'Aplikasi Mobile',
                'aplikasi mobile'    => 'Aplikasi Mobile',
                'hardware'           => 'Hardware',
                'aplikasi kasir'     => 'Aplikasi Kasir',
                'kasir'              => 'Aplikasi Kasir',
                'aplikasi web merchant' => 'Aplikasi Web Merchant',
                'aplikasi attendance' => 'Aplikasi Attendance',
                'aplikasi web internal' => 'Aplikasi Web Internal'
            ];

            $application = $applicationMap[$appRaw] ?? 'Aplikasi Mobile';


            // B. Fix Mapping ticket_type
            $ticketRaw = strtolower(trim($row['tickets']));
            $ticketType = in_array($ticketRaw, ['open', 'close']) ? ucfirst($ticketRaw) : 'Close';


            // C. Fix Mapping complaint_type
            $complaintRaw = strtolower(trim($row['complaint']));

            $complaintTypeMap = [
                'NORMAL' => 'Normal',
                'HARD' => 'Hard',
                'hardcase' => 'Hard',
                'hard case' => 'Hard',

                // Input excel sering salah
                'close' => 'Normal',
                'closed' => 'Normal',
                'open' => 'Normal',
                'ticket close' => 'Normal',
            ];

            $complaintType = $complaintTypeMap[$complaintRaw] ?? 'Normal';


            // D. Fix Mapping status_qris
            $statusRaw = strtolower(trim($row['status_qris']));
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


            // E. Fix Mapping priority
            $priorityRaw = strtolower(trim($row['priority']));
            $priorityMap = [
                'premium' => 'Premium',
                'full service' => 'Full Service',
                'lainnya' => 'Lainnya',
                'corporate' => 'Corporate',
            ];
            $priority = $priorityMap[$priorityRaw] ?? 'Lainnya';


            // F. Fix Mapping assigned
            $assignedRaw = strtolower(trim($row['assigned']));

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


            // Categori + Sub Category langsung ambil
            $category       = $row['categories'] ?? 'Assistances';
            $subCategory    = $row['subcategory'] ?? '-';

            // ======================
            // 3.5. CEK DUPLIKAT TICKET_NUMBER
            // ======================

            $existing = \App\Models\Ticket::where('ticket_number', $ticketNumber)->first();

            if ($existing) {
                Log::warning("Duplicate ticket_number skipped: {$ticketNumber}");
                return null; // jangan insert agar tidak error
            }


            // ======================
            // 4. INSERT DATA
            // ======================

            return new Ticket([
                'user_id'        => auth()->id(),
                'ticket_number'  => $ticketNumber,
                'ticket_type'    => $ticketType,
                'complaint_type' => $complaintType,
                'jam'            => $jam,
                'tanggal'        => $tanggal,
                'source'         => $row['source'] ?? 'Help Desk',
                'company'        => $row['company'] ?? '-',
                'branch'         => $row['branch'] ?? '-',
                'kota_cabang'    => $row['kota_cabang'] ?? 'Tidak Ada Cabang',
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
            ]);
        } catch (\Exception $e) {

            Log::error("Error Importing Row: " . $e->getMessage(), $row);
            return null;
        }
    }
}
